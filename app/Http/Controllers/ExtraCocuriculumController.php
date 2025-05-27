<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Models\CommunityServices;
use App\Models\ExtraCocuricullum;
use App\Models\Services;
use App\Models\SpecialAward;
use App\Models\Student;
use App\Models\Tier;
use App\Models\TimmsAndPisa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ExtraCocuriculumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->hasrole('admin')) {
            $students = Student::paginate(10);
        } else {
            $teacher = auth()->user()->teacher; // Assuming the logged-in user is a teacher

            $students = Student::where('mentor_id', $teacher->id)->paginate(10);
            // dd($students);
        }

        $existingEvaluations = [];
        foreach ($students as $student) {
            Log::info('Student:', ['student' => $student]);
            // Safely get classroom id, handle if classroom is null
            $classroomId = $student->classroom->id ?? null;
            if ($classroomId) {
                $existingEvaluations[$student->id] = ExtraCocuricullum::where('student_id', $student->id)
                    ->where('class_id', $classroomId)
                    ->first();
            } else {
                $existingEvaluations[$student->id] = null;
            }
        }

        // Log::info('Students:', ['students' => $students]);
        Log::info('Existing:', ['existingEvaluation' => $existingEvaluations]);
        return view('cocuriculum.extra-cocuriculum',compact(['students', 'existingEvaluations']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Student $student)
    {
        // Check if the student already has an evaluation for the current class
        $existingEvaluation = ExtraCocuricullum::where('student_id', $student->id)
            ->where('class_id', $student->classroom->id)
            ->first();

        if ($existingEvaluation) {
            return redirect()->route('pajsk.extra-cocuriculum.result', ['student' => $student->id, 'evaluation' => $existingEvaluation])
                ->with('error', 'This student already has an evaluation for the current class. Displaying existing evaluation.');
        }

        $student = Student::find($student->id);
        Log::info('Student:', ['student' => $student]);

        $services = Services::all();
        Log::info('Services:', ['services' => $services]);

        $special_awards = SpecialAward::all();
        Log::info('Special Awards:', ['specialAwards' => $special_awards]);

        $community_services = CommunityServices::all();
        Log::info('Community Services:', ['community_services' => $community_services]);

        $achievements = Achievement::all();
        Log::info('Achievements:', ['achievements' => $achievements]);

        $tiers = Tier::all();
        Log::info('Tiers:', ['tiers' => $tiers]);

        $timms_pisa= TimmsAndPisa::all();
        Log::info('Timms and Pisa:', ['timms_pisa' => $timms_pisa]);



        return view('cocuriculum.create-extra-cocuriculum',compact('student','services','special_awards','community_services','achievements','tiers','timms_pisa'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $studentId)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'service_point' => 'required|exists:services,id',
            'special_award_point' => 'required|exists:special_awards,id',
            'community_service_point' => 'required|exists:community_services,id',
            'achievement' => 'required|exists:achievements,id',
            'tiers' => 'required|exists:tiers,id',
            'timms_and_pisa_point' => 'required|exists:timms_and_pisa,id',
        ]);

        // Retrieve the Nilam point based on achievement and tier
        $achievementId = $validated['achievement'];
        $tierId = $validated['tiers'];

        $nilamPoint = Achievement::where('id', $achievementId)
            ->whereHas('tiers', function ($query) use ($tierId) {
                $query->where('tiers.id', $tierId); // Explicitly specify the table name
            })
            ->first()
            ->tiers()
            ->where('tiers.id', $tierId) // Explicitly specify the table name
            ->first()
            ->pivot
            ->point ?? 0;

        // Calculate the total points
        $servicePoint = Services::find($validated['service_point'])->point ?? 0;
        $specialAwardPoint = SpecialAward::find($validated['special_award_point'])->point ?? 0;
        $communityServicePoint = CommunityServices::find($validated['community_service_point'])->point ?? 0;
        $timmsAndPisaPoint = TimmsAndPisa::find($validated['timms_and_pisa_point'])->point ?? 0;
        Log::info('servicePoint = '.$servicePoint);
        Log::info('specialAwardPoint = '.$specialAwardPoint);
        Log::info('communityServicePoint = '.$communityServicePoint);
        Log::info('nilamPoint = '.$nilamPoint);
        Log::info('timmsAndPisaPoint = '.$timmsAndPisaPoint);
        $totalPoint = $servicePoint + $specialAwardPoint + $communityServicePoint + $nilamPoint + $timmsAndPisaPoint;
        $totalPoint = min($totalPoint, 10);
        
        $student = Student::find($studentId);
        // Create the ExtraCocuricullum record
        $evaluation = ExtraCocuricullum::create([
            'student_id' => $studentId,
            'class_id' => $student->classroom->id,
            'service_id' => $validated['service_point'],
            'special_award_id' => $validated['special_award_point'],
            'community_service_id' => $validated['community_service_point'],
            'nilam_id' => $achievementId, // Store the achievement ID as Nilam
            'timms_pisa_id' => $validated['timms_and_pisa_point'],
            'total_point' => $totalPoint,
        ]);

        return redirect()->route('pajsk.extra-cocuriculum.result', ['student' => $studentId, 'evaluation' => $evaluation])->with('success', 'Extra Cocuricculum data added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * show history of extra cocuricullum
     */
    public function history(Request $request)
    {
        $query = ExtraCocuricullum::with(['student.user', 'classroom', 'service', 'specialAward', 'communityService', 'nilam', 'timmsAndPisa']);

        if (auth()->user()->hasrole('admin')) {
            $query->whereHas('student.user.roles', function ($q) {
                $q->where('name', 'student');
            });
        } else {
            $teacher = auth()->user()->teacher; // Assuming the logged-in user is a teacher
            $query->whereHas('student.user', function ($q) use ($teacher) {
                $q->where('mentor_id', $teacher->id);
            });
        }

        $search = $request->get('search');
        $year_filter = $request->get('year_filter');
        
        if ($search) {
            $query->whereHas('student.user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }
        if ($year_filter) {
            $query->whereHas('classroom', function ($q) use ($year_filter) {
                $q->where('year', $year_filter);
            });
        }

        $evaluations = $query->latest()->paginate(10);

        return view('cocuriculum.extra-cocuriculum-history', compact('evaluations'));
    }

    /**
     * show result of extra cocuricullum
     */
    public function result(Request $request, Student $student)
    {
        $extraCocuricullum = ExtraCocuricullum::where('student_id', $student->id)->first();
        if (!$extraCocuricullum) {
            return redirect()->back()->with('error', 'No extra cocuricullum data found for this student.');
        }

        $result = [
            'student' => $student,
            'extraCocuricullum' => $extraCocuricullum,
        ];

        return view('cocuriculum.extra-cocuriculum-result', compact('result'));
    }
}
