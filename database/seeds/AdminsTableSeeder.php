<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\Admin;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::truncate();
        factory(Admin::class)->create([
            'password' => bcrypt('123456')
        ]);
    }
}
