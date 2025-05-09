<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Todo;

class TodoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $todos = [
            [
                'title' => 'Veritabanı Şemasını Tasarla',
                'description' => 'Todo uygulaması için gerekli tabloları ve ilişkileri tasarla',
                'status' => 'pending',
                'priority' => 'high',
                'due_date' => '2025-11-05 18:00:00',
                'category_ids' => [1, 3],
            ],
            [
                'title' => 'JWT ile Kimlik Doğrulama Ekle',
                'description' => 'Laravel API için JWT tabanlı kullanıcı giriş sistemi kur',
                'status' => 'in_progress',
                'priority' => 'medium',
                'due_date' => '2025-10-10 12:00:00',
                'category_ids' => [1],
            ],
            [
                'title' => 'Dashboard Bileşenlerini Kodla',
                'description' => 'Frontend tarafında todo istatistiklerini gösteren kartlar oluştur',
                'status' => 'completed',
                'priority' => 'low',
                'due_date' => '2025-09-30 16:00:00',
                'category_ids' => [2],
            ],
        ];

        foreach ($todos as $data) {
            $todo = Todo::create([
                'title' => $data['title'],
                'description' => $data['description'],
                'status' => $data['status'],
                'priority' => $data['priority'],
                'due_date' => $data['due_date'],
            ]);

            $todo->categories()->sync($data['category_ids']);
        }
    }
}
