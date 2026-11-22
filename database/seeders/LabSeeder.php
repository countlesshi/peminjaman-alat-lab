<?php

namespace Database\Seeders;

use App\Models\Lab;
use Illuminate\Database\Seeder;

class LabSeeder extends Seeder
{
    public function run(): void
    {
        $labs = [
            [
                'name' => 'Lab Komputer & Robotik',
                'prefix' => 'KOM',
                'items' => [
                    'Laptop' => 4,
                    'Proyektor' => 2,
                    'Arduino Uno Kit' => 3,
                    'ESP32 DevKit' => 3,
                    'Raspberry Pi 4' => 2,
                    'Sensor Kit' => 3,
                    'Robot Line Follower' => 2,
                ],
            ],
            [
                'name' => 'Lab Multimedia (MMD)',
                'prefix' => 'MMD',
                'items' => [
                    'Kamera Mirrorless' => 2,
                    'Tripod' => 3,
                    'Lighting Kit' => 2,
                    'Microphone' => 2,
                    'VR Headset' => 1,
                ],
            ],
            [
                'name' => 'Lab Jaringan',
                'prefix' => 'NET',
                'items' => [
                    'Router' => 2,
                    'Switch 24 Port' => 2,
                    'Access Point' => 2,
                    'Crimping Tool Set' => 3,
                ],
            ],
        ];

        foreach ($labs as $data) {
            $lab = Lab::create(['name' => $data['name']]);
            $no = 1;

            foreach ($data['items'] as $name => $qty) {
                for ($i = 1; $i <= $qty; $i++) {
                    $lab->items()->create([
                        'code' => $data['prefix'] . '-' . str_pad($no++, 3, '0', STR_PAD_LEFT),
                        'name' => $name . ' #' . str_pad($i, 2, '0', STR_PAD_LEFT),
                    ]);
                }
            }
        }
    }
}