<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InitialCatalogSeeder extends Seeder
{
    public function run(): void
    {
        // SITE SETTINGS
        DB::table('site_settings')->insert([
            [
                'key'       => 'store_name',
                'value'     => env('APP_NAME', 'Multimarcas'),
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'key'       => 'whatsapp_phone',
                // formato internacional sem "+" (ex: 55DDDNUMERO)
                'value'     => '556196391006',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'key'       => 'store_city',
                'value'     => 'Brasília',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'key'       => 'store_state',
                'value'     => 'DF',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
        ]);

        // VEÍCULOS
        $now = now();

        $vehicles = [
            [
                'slug'           => 'chevrolet-onix-2023-lt-10-flex',
                'title'          => 'Chevrolet Onix LT 1.0 Flex 2023',
                'description'    => 'Onix LT 1.0 Flex 2023, ótimo estado, único dono, revisões em dia.',
                'price'          => 78990.00,
                'brand'          => 'Chevrolet',
                'model'          => 'Onix',
                'version'        => 'LT 1.0',
                'year'           => 2023,
                'model_year'     => 2023,
                'mileage_km'     => 15000,
                'fuel'           => 'Flex',
                'transmission'   => 'Manual',
                'color'          => 'Prata',
                'status'         => 'available',
                'featured'       => true,
                'whatsapp_phone' => null, // usa o global
                'published_at'   => $now,
                'created_at'     => $now,
                'updated_at'     => $now,
            ],
            [
                'slug'           => 'hyundai-hb20-2022-comfort-plus',
                'title'          => 'Hyundai HB20 Comfort Plus 2022',
                'description'    => 'HB20 Comfort Plus 2022, completo, baixa quilometragem.',
                'price'          => 73990.00,
                'brand'          => 'Hyundai',
                'model'          => 'HB20',
                'version'        => 'Comfort Plus',
                'year'           => 2022,
                'model_year'     => 2022,
                'mileage_km'     => 22000,
                'fuel'           => 'Flex',
                'transmission'   => 'Automático',
                'color'          => 'Branco',
                'status'         => 'available',
                'featured'       => true,
                'whatsapp_phone' => null,
                'published_at'   => $now,
                'created_at'     => $now,
                'updated_at'     => $now,
            ],
            [
                'slug'           => 'fiat-cronos-2021-drive-13',
                'title'          => 'Fiat Cronos Drive 1.3 2021',
                'description'    => 'Fiat Cronos Drive 1.3 2021, econômico e espaçoso.',
                'price'          => 68990.00,
                'brand'          => 'Fiat',
                'model'          => 'Cronos',
                'version'        => 'Drive 1.3',
                'year'           => 2021,
                'model_year'     => 2021,
                'mileage_km'     => 30000,
                'fuel'           => 'Flex',
                'transmission'   => 'Manual',
                'color'          => 'Preto',
                'status'         => 'available',
                'featured'       => false,
                'whatsapp_phone' => null,
                'published_at'   => $now,
                'created_at'     => $now,
                'updated_at'     => $now,
            ],
        ];

        DB::table('vehicles')->insert($vehicles);

        // pegar IDs inseridos
        $vehiclesInDb = DB::table('vehicles')->get()->keyBy('slug');

        // FOTOS FAKE (paths)
        $photos = [
            // Onix
            [
                'vehicle_id' => $vehiclesInDb['chevrolet-onix-2023-lt-10-flex']->id,
                'path'       => 'vehicles/onix-2023-lt-1.jpg',
                'alt_text'   => 'Chevrolet Onix 2023 frente',
                'position'   => 1,
                'is_cover'   => true,
            ],
            [
                'vehicle_id' => $vehiclesInDb['chevrolet-onix-2023-lt-10-flex']->id,
                'path'       => 'vehicles/onix-2023-lt-2.jpg',
                'alt_text'   => 'Chevrolet Onix 2023 interior',
                'position'   => 2,
                'is_cover'   => false,
            ],

            // HB20
            [
                'vehicle_id' => $vehiclesInDb['hyundai-hb20-2022-comfort-plus']->id,
                'path'       => 'vehicles/hb20-2022-1.jpg',
                'alt_text'   => 'Hyundai HB20 2022 frente',
                'position'   => 1,
                'is_cover'   => true,
            ],
            [
                'vehicle_id' => $vehiclesInDb['hyundai-hb20-2022-comfort-plus']->id,
                'path'       => 'vehicles/hb20-2022-2.jpg',
                'alt_text'   => 'Hyundai HB20 2022 lateral',
                'position'   => 2,
                'is_cover'   => false,
            ],

            // Cronos
            [
                'vehicle_id' => $vehiclesInDb['fiat-cronos-2021-drive-13']->id,
                'path'       => 'vehicles/cronos-2021-1.jpg',
                'alt_text'   => 'Fiat Cronos 2021 frente',
                'position'   => 1,
                'is_cover'   => true,
            ],
        ];

        foreach ($photos as &$photo) {
            $photo['created_at'] = $now;
            $photo['updated_at'] = $now;
        }

        DB::table('vehicle_photos')->insert($photos);
    }
}
