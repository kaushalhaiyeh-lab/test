<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class HomePageSeeder extends Seeder
{
    public function run(): void
    {
        if (Page::where('slug', 'home')->exists()) {
            return;
        }

        Page::create([
            'title' => 'Home',
            'slug' => 'home',
            'content' => '
                <section class="text-center py-24">
                    <h1 class="text-4xl font-bold">Welcome to HR Portal</h1>
                    <p class="mt-4">Smart hiring & HR management</p>
                </section>
            ',
        ]);
    }
}
