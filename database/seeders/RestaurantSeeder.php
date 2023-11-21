<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\MenuGroup;
use App\Models\Restaurant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RestaurantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Restaurant::truncate();

        Restaurant::factory()->count(5)->create()->each(function($restaurant) {

            $groups = ['Dishes', 'Beverages', 'Desserts'];
            $menuGroupIds = [];
            foreach($groups as $group) {
                $group = MenuGroup::factory()->create(['name' => $group, 'restaurant_id' => $restaurant->id]);
                $menuGroupIds[] = $group->id;
            }

            Menu::factory()->count(35)->create([
                'restaurant_id' => $restaurant->id,
                'menu_group_id' => $menuGroupIds[array_rand($menuGroupIds)],
                ]);

        });
    }
}
