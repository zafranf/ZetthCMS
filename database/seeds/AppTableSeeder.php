<?php

use Illuminate\Database\Seeder;

class AppTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Models\Application::create([
            'name' => 'NYPSoft',
            'description' => 'NyariPeluang Software',
            'logo' => '',
            'status' => 1,
        ]);
    }
}
