<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            ['code' => 'PROD001', 'name' => 'Laptop Dell XPS 13', 'price' => 15000000, 'stock' => 10],
            ['code' => 'PROD002', 'name' => 'Mouse Logitech MX Master', 'price' => 1200000, 'stock' => 25],
            ['code' => 'PROD003', 'name' => 'Keyboard Mechanical RGB', 'price' => 800000, 'stock' => 15],
            ['code' => 'PROD004', 'name' => 'Monitor LG 24 inch', 'price' => 2500000, 'stock' => 8],
            ['code' => 'PROD005', 'name' => 'Webcam Logitech C920', 'price' => 1500000, 'stock' => 12],
            ['code' => 'PROD006', 'name' => 'Headset Gaming HyperX', 'price' => 900000, 'stock' => 20],
            ['code' => 'PROD007', 'name' => 'SSD Samsung 1TB', 'price' => 1800000, 'stock' => 18],
            ['code' => 'PROD008', 'name' => 'RAM Corsair 16GB', 'price' => 1100000, 'stock' => 22],
            ['code' => 'PROD009', 'name' => 'Printer Canon', 'price' => 2200000, 'stock' => 6],
            ['code' => 'PROD010', 'name' => 'Router TP-Link', 'price' => 500000, 'stock' => 30],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(
                ['code' => $product['code']],
                [
                    'name' => $product['name'],
                    'price' => $product['price'],
                    'stock' => $product['stock'],
                ]
            );
        }
    }
}
