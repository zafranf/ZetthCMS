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
            'name' => 'ZetthCMS Core',
            'description' => 'Core System ZetthCMS',
            'logo' => '',
            'status' => 1,
        ]);
    }
}
