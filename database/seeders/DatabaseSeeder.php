<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
// use Illuminate\Support\Facades\DB; // Có thể đã có

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ❌ XÓA hoặc Ghi chú dòng này (User::factory()->create()...)
        // \App\Models\User::factory(10)->create();

        // ❌ XÓA hoặc Ghi chú dòng này (Nếu có)
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // ✅ CHỈ GỌI ProductSeeder của chúng ta
        $this->call(ProductSeeder::class);
    }
}
