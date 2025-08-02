<?php

namespace Database\Seeders;

use App\Models\Activity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    public function run(): void
    {
        $eda = Activity::create(['name' => 'Еда']);
        $eda->children()->createMany([
            ['name' => 'Мясная продукция'],
            ['name' => 'Молочная продукция'],
        ]);

        $auto = Activity::create(['name' => 'Автомобили']);
        $truck = $auto->children()->create(['name' => 'Грузовые']);
        $car = $auto->children()->create(['name' => 'Легковые']);

        $car->children()->createMany([
            ['name' => 'Запчасти'],
            ['name' => 'Аксессуары'],
        ]);
    }
}