<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InvolvementType;

class InvolvementTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $type1 = [
            'Choral Speaking',
            'International Mathematic Olympiad (IMO)',
            'Jambori',
            'Jogathon',
            'Karnival',
            'Karnival Kesenian',
            'Kawad',
            'Kawad Hos',
            'Kejohanan',
            'KEJORA (Kejohanan Olahraga)',
            'Kem',
            'Kem Cuti',
            'Kuiz',
            'Kuiz Olimpiad',
            'Lawatan',
            'Olimpiad Matematik Kebangsaan (OMK)',
            'Perkhemahan',
            'Perlawanan Persahabatan',
            'Pertandingan',
            'Summer Camp Permata Pintar',
        ];

        $type2 = [
            'Badan Wakil Pelajar',
            'Demonstrasi',
            'Expo',
            'Festival Muzik',
            'Forum',
            'Gerai Terbaik',
            'Hari Anugerah',
            'Hari Graduasi',
            'Hari Pendaftaran',
            'Homeroom',
            'Inovasi',
            'Jawatankuasa',
            'Kole Kediaman',
            'Lawatan',
            'Lembaga Disiplin Pelajar',
            'Lembaga Pengurusan Asrama',
            'Majalah Maktab',
            'Majlis',
            'Malam Amal',
            'Malam merdeka',
            'Malaysia Book of Records',
            'Malaysian Junior Apprentice',
            'Minggu',
            'Minggu Aktiviti',
            'Minggu Aktiviti Maktab',
            'Minggu Ko-kurikulum',
            'Minggu Orientasi',
            'Minggu Orientasi Maktab',
            'Olimpiad Matematik Kebangsaan (OMK)',
            'Pameran',
            'Pasukan Sorak',
            'Pemilihan',
            'Penyokong',
            'Perbahasan',
            'Perbarisan',
            'Perhimpunan Rasmi',
            'Perkhemahan',
            'Perlawanan Persahabatan',
            'Persatuan Pelajar Islam Maktab (PERPIM)',
            'Persembahan',
            'Persidangan',
            'Pertandingan',
            'Pertemuan',
            'Pesta',
            'Petugas Teknikal',
            'Program',
            'Program Pembimbing Rakan Sebaya',
            'Program Usahawan Muda Maktab',
            'Projek',
            'Pusat Sumber Pembelajaran',
            'Seminar',
            'Subjek',
            'Sukan Tahunan Maktab',
            'Sukarelawan',
            'Summer Camp Permata Pintar',
            'Syarikat Terbaik',
            'Webinar',
            'Kolokium',
            'Kongres',
            'Konvensyen',
            'Kooperasi Maktab',
            'Kursus',
        ];

        $type3 = [
            'CSR Rebung',
            'Dinnerton',
            'Gerak Gempur',
            'Pasukan Sorak',
            'Pemilihan',
            'Penyokong',
            'Perhimpunan Rasmi',
            'Pesta',
        ];

        foreach ($type1 as $desc) {
            InvolvementType::create([
                'type' => 1,
                'description' => $desc,
            ]);
        }

        foreach ($type2 as $desc) {
            InvolvementType::create([
                'type' => 2,
                'description' => $desc,
            ]);
        }

        foreach ($type3 as $desc) {
            InvolvementType::create([
                'type' => 3,
                'description' => $desc,
            ]);
        }

        $this->command->info('Involvement types seeded successfully!');
    }
}