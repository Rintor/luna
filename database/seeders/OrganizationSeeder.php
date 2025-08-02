<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Building;
use App\Models\Organization;
use App\Models\OrganizationPhone;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrganizationSeeder extends Seeder
{
    public function run(): void
    {
        Organization::factory()
            ->count(20)
            ->create()
            ->each(function ($org) {
                // Телефоны
                OrganizationPhone::factory()->count(rand(1, 3))->create([
                    'organization_id' => $org->id,
                ]);

                // Связь с деятельностями
                $activityIds = Activity::inRandomOrder()->take(rand(1, 3))->pluck('id');
                $org->activities()->attach($activityIds);
            });
    }
}
