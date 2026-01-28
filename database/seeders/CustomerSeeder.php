<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = [
            [
                'code' => 'CUST001',
                'name' => 'PT. Technology Indonesia',
                'full_address' => 'Jl. Sudirman No. 123',
                'province' => 'DKI Jakarta',
                'city' => 'Jakarta Selatan',
                'district' => 'Setiabudi',
                'village' => 'Kuningan Timur',
                'postal_code' => '12950',
            ],
            [
                'code' => 'CUST002',
                'name' => 'CV. Digital Solutions',
                'full_address' => 'Jl. Ahmad Yani No. 45',
                'province' => 'Jawa Timur',
                'city' => 'Surabaya',
                'district' => 'Gubeng',
                'village' => 'Airlangga',
                'postal_code' => '60286',
            ],
            [
                'code' => 'CUST003',
                'name' => 'Toko Komputer Maju',
                'full_address' => 'Jl. Gajah Mada No. 78',
                'province' => 'Jawa Tengah',
                'city' => 'Semarang',
                'district' => 'Semarang Tengah',
                'village' => 'Pandansari',
                'postal_code' => '50134',
            ],
            [
                'code' => 'CUST004',
                'name' => 'PT. Sejahtera Makmur',
                'full_address' => 'Jl. Asia Afrika No. 99',
                'province' => 'Jawa Barat',
                'city' => 'Bandung',
                'district' => 'Sumur Bandung',
                'village' => 'Braga',
                'postal_code' => '40111',
            ],
            [
                'code' => 'CUST005',
                'name' => 'UD. Jaya Abadi',
                'full_address' => 'Jl. Malioboro No. 56',
                'province' => 'DI Yogyakarta',
                'city' => 'Yogyakarta',
                'district' => 'Gondomanan',
                'village' => 'Prawirodirjan',
                'postal_code' => '55121',
            ],
        ];

        foreach ($customers as $customer) {
            Customer::updateOrCreate(
                ['code' => $customer['code']],
                [
                    'name' => $customer['name'],
                    'full_address' => $customer['full_address'],
                    'province' => $customer['province'],
                    'city' => $customer['city'],
                    'district' => $customer['district'],
                    'village' => $customer['village'],
                    'postal_code' => $customer['postal_code'],
                ]
            );
        }
    }
}
