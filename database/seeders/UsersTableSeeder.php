<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'names' => 'Jon',
            'lastnames' => 'Snow',
            'identity_document' => '47845795',
            'username' => 'jox',
            'email' => 'emailo@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => '$2y$12$2HFe2yXZbEKfxvS/zZQyz.V74HW32cIvYNRLeRgP91triNuTOTNbi',
            'balance' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'deleted_at' => null,
        ]);
    }
}
