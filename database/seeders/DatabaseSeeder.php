<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Plan;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        \App\Models\User::factory()->create([
            'email' => 'nguyenlehuyuit@gmail.com',
            'name' => 'huy'
        ]);

        Plan::query()->insert(
            [
                [
                    'title' => 'Monthly',
                    'slug' => 'monthly',
                    'price' => 10
                ],
                [
                    'title' => 'Yearly',
                    'slug' => 'yearly',
                    'price' => 50
                ],
                [
                    'title' => 'Forever',
                    'slug' => 'forever',
                    'price' => 300
                ]
            ]
        );
    }
}
