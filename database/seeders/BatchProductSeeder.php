<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\facades\DB;
use Carbon\Carbon;

class BatchProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        for ($i = 0; $i <= 10; $i++) {
            DB::table('batch_product')->insert([
                'id' => (int) (now()->addDays($i))->format('Ymd'),
                'tanggal_masuk' => now(),
                'tanggal_kadaluwarsa' => now(),
                'jumlah' => rand(1, 10),
                'created_at' => carbon::now($i),
                'updated_at' => carbon::now($i),
            ]);
        }
    }
}
