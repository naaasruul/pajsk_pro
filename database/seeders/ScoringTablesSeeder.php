<?php

namespace Database\Seeders;

use App\Models\AttendanceScore;
use App\Models\CommitmentScore;
use App\Models\ServiceContributionScore;
use Illuminate\Database\Seeder;

class ScoringTablesSeeder extends Seeder
{
    public function run(): void
    {
        // Attendance scores (40 points total)
        for ($i = 1; $i <= 12; $i++) {
            AttendanceScore::create([
                'attendance_count' => $i,
                'score' => round(($i / 12) * 40, 2) // Calculate score based on attendance (max 40 points)
            ]);
        }

        // Commitment scores (10 points total)
        $commitments = [
            ['commitment_name' => 'Menunjukkan Kepimpinan', 'score' => 3],
            ['commitment_name' => 'Mengurus Aktiviti', 'score' => 3],
            ['commitment_name' => 'Membantu guru atau rakan', 'score' => 2],
            ['commitment_name' => 'Menyedia Peralatan', 'score' => 2],
            ['commitment_name' => 'Mengemas Peralatan', 'score' => 2],
        ];

        foreach ($commitments as $commitment) {
            CommitmentScore::create($commitment);
        }

        $serviceContributions = [
            ['service_name' => 'ATLET/PESERTA', 'score' => 10, 'description' => 'Murid yang didaftarkan sebagai atlet atau peserta program / pertandingan / Karnival / kursus'],
            ['service_name' => 'KEMAHIRAN KHUSUS', 'score' => 10, 'description' => 'Melibatkan kemahiran khusus – berkaitan aspek teknikal (pengadil, jurulatih pasukan, dll yang berkaitan dengan aspek teknikal)'],
            ['service_name' => 'PERSEMBAHAN', 'score' => 8, 'description' => 'Penglibatan murid yang terlibat dalam aktiviti seperti persembahan selingan'],
            ['service_name' => 'SOKONGAN', 'score' => 5, 'description' => 'Membantu dari segi menjayakan aktiviti kelab persatuan sukan sekolah seperti mengambil bahagian dalam perbarisan atau persembahan, kumpulan sorak/ penyokong, dan yang berkaitan'],
        ];

        foreach ($serviceContributions as $service) {
            ServiceContributionScore::create($service);
        }
    }
}