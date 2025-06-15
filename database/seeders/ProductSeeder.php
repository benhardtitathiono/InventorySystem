<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\facades\DB;
use Carbon\Carbon;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $product = [
            ['nama' => 'a', 'satuan' => 'box', 'stock_quantity' => 10, 'description' => 'Midea AC Portable MPHA-05CRN7 AC Portable 0.5PK cocok digunakan untuk ruangan kantor, studio, cafe, ruangan sewa',],
            ['nama' => 'b', 'satuan' => 'box', 'stock_quantity' => 10, 'description' => 'SKYAIR Non Inverter AC FLOOR STANDING'],
            ['nama' => 'c', 'satuan' => 'box', 'stock_quantity' => 10, 'description' => 'Electric Scenting Mesin Diffuser Pengharum Ruangan Otomatis 400ML'],
            ['nama' => 'd', 'satuan' => 'box', 'stock_quantity' => 10, 'description' => '2 filters in one for lasting good performance The 2-layer filtration of NanoProtect HEPA and pre-filter ensures that you are protected from PM2.5, bacteria, pollen, dust, pet dander and other pollutants.'],
            ['nama' => 'e', 'satuan' => 'box', 'stock_quantity' => 10, 'description' => 'Krisbow 16 Inci Kipas Angin Industrial 2 In 1 55 Watt'],
        ];

        foreach ($product as $item) {
            DB::table('product_abis_pakai')->insert([
                'nama_barang' => $item['nama'],
                'satuan' => $item['satuan'],
                'deskripsi' => $item['description'],
                'jumlah' => $item['stock_quantity'],
                'created_at' => carbon::now(),
                'updated_at' => carbon::now(),
            ]);
        }
    }
}
