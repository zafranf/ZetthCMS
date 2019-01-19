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
            'tagline' => '',
            'logo' => '',
            'icon' => '',
            'description' => 'Core System ZetthCMS',
            'keyword' => '',
            'status' => 1,
            'active_at' => date("Y-m-d H:i:s"),
            'email' => '',
            'address' => '',
            'phone' => '',
            // 'google_analytic' => '',
            'location' => '',
        ]);
    }
}
