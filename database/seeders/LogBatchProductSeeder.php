<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\facades\DB;
use Carbon\Carbon;

class LogBatchProductSeeder extends Seeder
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
            DB::table('log_product_batch')->insert([
                'product_id' => rand(1, 5),
                'batch_product' => (int) (now()->addDays($i))->format('Ymd'),
                'quantity_in' => rand(0, 10),
                // 'quantity_out' => rand(0, 10),
                'tanggal' => carbon::now(),
            ]);
        }
    }
}
