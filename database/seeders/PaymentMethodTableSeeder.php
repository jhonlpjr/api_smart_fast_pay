<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentMethodTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('payment_method')->insert([
            [
                'id' => 1,
                'name' => 'Pix',
                'slug' => 'pix',
                'commission' => 0.015,
                'created_at' => Carbon::parse('2024-08-15 21:08:16'),
                'updated_at' => Carbon::parse('2024-08-15 21:08:16'),
            ],
            [
                'id' => 2,
                'name' => 'Ticket',
                'slug' => 'ticket',
                'commission' => 0.02,
                'created_at' => Carbon::parse('2024-08-15 21:08:37'),
                'updated_at' => Carbon::parse('2024-08-15 21:08:37'),
            ],
            [
                'id' => 3,
                'name' => 'Bank Transfer',
                'slug' => 'bank_transfer',
                'commission' => 0.04,
                'created_at' => Carbon::parse('2024-08-15 21:10:57'),
                'updated_at' => Carbon::parse('2024-08-15 21:10:57'),
            ],
        ]);
    }
}
