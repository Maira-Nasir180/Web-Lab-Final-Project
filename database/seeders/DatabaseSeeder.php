<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Staff (admin) sign-in URL: /admin/login
     * Customer sign-in URL: /login
     *
     * Admin login (change password in production):
     * email: admin@sweetbite.test
     * password: password
     */
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@sweetbite.test'],
            [
                'name' => 'SweetBite Admin',
                'password' => Hash::make('password'),
                'is_admin' => true,
            ]
        );

        $rows = [
            ['name' => 'Chocolate Cake', 'price' => 1500, 'image' => 'chocolate-cake.jpg', 'stock' => 25, 'sort_order' => 1],
            ['name' => 'Cupcake', 'price' => 250, 'image' => 'cupcake.jpg', 'stock' => 25, 'sort_order' => 2],
            ['name' => 'Macaron', 'price' => 350, 'image' => 'macaron.jpg', 'stock' => 25, 'sort_order' => 3],
            ['name' => 'Cookies', 'price' => 300, 'image' => 'cookies.jpg', 'stock' => 25, 'sort_order' => 4],
            ['name' => 'Blueberry Cake', 'price' => 2000, 'image' => 'blueberry-cake.jpg', 'stock' => 25, 'sort_order' => 5],
            ['name' => 'Croissant', 'price' => 500, 'image' => 'croissant.jpg', 'stock' => 25, 'sort_order' => 6],
        ];

        foreach ($rows as $row) {
            Product::query()->updateOrCreate(
                ['slug' => Str::slug($row['name'])],
                [
                    'name' => $row['name'],
                    'price' => $row['price'],
                    'image' => $row['image'],
                    'stock' => $row['stock'],
                    'is_active' => true,
                    'sort_order' => $row['sort_order'],
                ]
            );
        }

        if (Review::query()->doesntExist()) {
            $seedReviews = [
                ['name' => 'Ayesha Khan', 'email' => 'ayesha.review@local.test', 'body' => 'The chocolate cake was divine! Moist, rich, and simply irresistible.'],
                ['name' => 'Sarah Malik', 'email' => 'sarah.review@local.test', 'body' => 'Their croissants are the best in town. Flaky and buttery perfection!'],
                ['name' => 'Ali Raza', 'email' => 'ali.review@local.test', 'body' => 'Loved the macarons! Perfectly sweet and so pretty.'],
            ];
            foreach ($seedReviews as $sr) {
                $user = User::query()->firstOrCreate(
                    ['email' => $sr['email']],
                    [
                        'name' => $sr['name'],
                        'password' => Hash::make(Str::password(32)),
                        'is_admin' => false,
                    ]
                );
                Review::query()->create([
                    'user_id' => $user->id,
                    'body' => $sr['body'],
                ]);
            }
        }
    }
}
