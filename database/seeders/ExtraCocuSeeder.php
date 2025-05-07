<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExtraCocuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $this->call(ExtraCocuServices::class);
        $this->call(ExtraCocuSpecialAwards::class);
        $this->call(ExtraCocuCommunityServices::class);
        $this->call(NilamSeeder::class);
        $this->call(ExtraCocuTIMMS_PISA::class);


		$this->command->info('Extra Cocu. seeded successfully');

        
    }
}
