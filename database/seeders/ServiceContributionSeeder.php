<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ServiceContribution;

class ServiceContributionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            ['service_name' => 'ATLET/PESERTA', 'score' => 10, 'description' => 'Murid yang didaftarkan sebagai atlet atau peserta program / pertandingan / Karnival / kursus'],
            ['service_name' => 'KEMAHIRAN KHUSUS', 'score' => 10, 'description' => 'Melibatkan kemahiran khusus – berkaitan aspek teknikal (pengadil, jurulatih pasukan, dll yang berkaitan dengan aspek teknikal)'],
            ['service_name' => 'PERSEMBAHAN', 'score' => 8, 'description' => 'Penglibatan murid yang terlibat dalam aktiviti seperti persembahan selingan'],
            ['service_name' => 'SOKONGAN', 'score' => 5, 'description' => 'Membantu dari segi menjayakan aktiviti kelab persatuan sukan sekolah seperti mengambil bahagian dalam perbarisan atau persembahan, kumpulan sorak/ penyokong, dan yang berkaitan'],
        ];

        foreach ($services as $service) {
            ServiceContribution::create($service);
        }
    }
}
