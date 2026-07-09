<?php

namespace Database\Seeders;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Database\Seeder;

class TodoSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::query()->first();

        if (! $user) {
            return;
        }

        $items = [
            ['title' => 'Buy groceries', 'priority' => 'high', 'position' => 1],
            ['title' => 'Write spec Kit flow', 'priority' => 'medium', 'position' => 2, 'completed' => true],
            ['title' => 'Run feature tests', 'priority' => 'low', 'position' => 3],
        ];

        foreach ($items as $item) {
            $user->todos()->create($item);
        }
    }
}
