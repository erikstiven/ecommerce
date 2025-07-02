<?php

namespace Database\Seeders;

use App\Models\Option;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $options = [
            [
                'name' => 'Talla',
                'type' => '1',
                'features' => [
                    [
                        'value' => 'S',
                        'description' => 'Small',
                    ],
                    [
                        'value' => 'M',
                        'description' => 'Medium',
                    ],
                    [
                        'value' => 'L',
                        'description' => 'Large',
                    ],
                    [
                        'value' => 'XL',
                        'description' => 'Extra Large',
                    ],
                    [
                        'value' => 'XXL',
                        'description' => 'Double Extra Large',
                    ],
                ],
            ],
            [
                'name' => 'Color',
                'type' => '2',
                'features' => [
                    [
                        'value' => '#000000',
                        'description' => 'Black',
                    ],
                    [
                        'value' => '#FFFFFF',
                        'description' => 'White',
                    ],
                    [
                        'value' => '#FF0000',
                        'description' => 'Red',
                    ],
                    [
                        'value' => '#00FF00',
                        'description' => 'Green',
                    ],
                    [
                        'value' => '#0000FF',
                        'description' => 'Blue',
                    ],
                    [
                        'value' => '#FFFF00',
                        'description' => 'Yellow',
                    ],
                    [
                        'value' => '#FF00FF',
                        'description' => 'Magenta',
                    ],
                    [
                        'value' => '#00FFFF',
                        'description' => 'Cyan',
                    ],
                    [
                        'value' => '#808080',
                        'description' => 'Gray',
                    ],
                    [
                        'value' => '#FFA500',
                        'description' => 'Orange',
                    ],
                    [
                        'value' => '#800080',
                        'description' => 'Purple',
                    ],
                    [
                        'value' => '#FFC0CB',
                        'description' => 'Pink',
                    ],
                    [
                        'value' => '#A52A2A',
                        'description' => 'Brown',
                    ],
                ],
            ],
            [
                'name' => 'Sexo',
                'type' => '1',
                'features' => [
                    [
                        'value' => 'H',
                        'description' => 'Hombre',
                    ],
                    [
                        'value' => 'M',
                        'description' => 'Mujer',
                    ],

                ],
            ],
        ];

        foreach ($options as $option) {
            $optionModel = Option::create([
                'name' => $option['name'],
                'type' => $option['type'],
            ]);
            foreach ($option['features'] as $feature) {
                $optionModel->features()->create([
                    'option_id' => $optionModel->id,
                    'value' => $feature['value'],
                    'description' => $feature['description'],
                ]);
            }
        }
    }
}
