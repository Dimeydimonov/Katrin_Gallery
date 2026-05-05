<?php

namespace Database\Seeders;

use App\Models\Artwork;
use App\Models\ArtworkImage;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ArtworkSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        if (!$user) {
            $user = User::create([
                'name' => 'Kateryna Pohrebenna',
                'email' => 'katarts@example.com',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ]);
        }

        $categories = [
            ['name' => 'Живопись', 'slug' => 'paintings', 'description' => 'Картины маслом и акрилом'],
            ['name' => 'Портреты', 'slug' => 'portraits', 'description' => 'Карандашные и графические портреты'],
            ['name' => 'Light Art', 'slug' => 'light-art', 'description' => 'Уникальное шоу рисования светом'],
        ];

        foreach ($categories as $catData) {
            Category::updateOrCreate(['slug' => $catData['slug']], $catData + ['is_active' => true]);
        }

        $paintings = Category::where('slug', 'paintings')->first();
        $portraits = Category::where('slug', 'portraits')->first();
        $lightArt = Category::where('slug', 'light-art')->first();

        $artworks = [
            [
                'title' => 'Горный пейзаж',
                'slug' => 'mountain-landscape',
                'description' => 'Величественные горы в лучах заката. Масло на холсте, передающее всю глубину и мощь природы.',
                'image' => 'painting-mountains.jpg',
                'categories' => [$paintings->id],
                'price' => 15000,
                'materials' => 'Масло, холст',
                'year' => 2024,
            ],
            [
                'title' => 'Закат над морем',
                'slug' => 'sunset-sea',
                'description' => 'Тёплые краски заката отражаются в морской глади. Работа наполнена спокойствием и гармонией.',
                'image' => 'painting-sunset-sea.jpg',
                'categories' => [$paintings->id],
                'price' => 12000,
                'materials' => 'Масло, холст',
                'year' => 2024,
            ],
            [
                'title' => 'Ангел',
                'slug' => 'angel',
                'description' => 'Образ ангела-хранителя, написанный в классической технике с современным видением.',
                'image' => 'painting-angel.jpg',
                'categories' => [$paintings->id],
                'price' => 18000,
                'materials' => 'Масло, холст',
                'year' => 2023,
            ],
            [
                'title' => 'Выставка',
                'slug' => 'exhibition',
                'description' => 'Момент с персональной выставки. Искусство в пространстве галереи.',
                'image' => 'artist-exhibition.jpg',
                'categories' => [$paintings->id],
                'price' => 0,
                'materials' => 'Фотография',
                'year' => 2024,
            ],
            [
                'title' => 'В мастерской',
                'slug' => 'in-the-studio',
                'description' => 'Процесс создания нового произведения. Птица как символ свободы творчества.',
                'image' => 'artist-painting-bird.jpeg',
                'categories' => [$paintings->id],
                'price' => 22000,
                'materials' => 'Масло, холст',
                'year' => 2024,
            ],
            [
                'title' => 'Портрет мальчика',
                'slug' => 'portrait-boy',
                'description' => 'Детский портрет, выполненный карандашом. Передача эмоций через графику.',
                'image' => 'portrait-boy.jpeg',
                'categories' => [$portraits->id],
                'price' => 8000,
                'materials' => 'Карандаш, бумага',
                'year' => 2023,
            ],
            [
                'title' => 'Девушка в тени',
                'slug' => 'girl-in-shadow',
                'description' => 'Контрастный портрет с игрой света и тени. Глубокая проработка деталей.',
                'image' => 'portrait-girl-dark.jpg',
                'categories' => [$portraits->id],
                'price' => 9000,
                'materials' => 'Уголь, бумага',
                'year' => 2024,
            ],
            [
                'title' => 'Женщина в жилете',
                'slug' => 'woman-in-vest',
                'description' => 'Стильный портрет с акцентом на текстуры ткани и выражение лица.',
                'image' => 'portrait-woman-vest.jpeg',
                'categories' => [$portraits->id],
                'price' => 10000,
                'materials' => 'Карандаш, бумага',
                'year' => 2024,
            ],
            [
                'title' => 'Light Art — Пара',
                'slug' => 'light-art-couple',
                'description' => 'Романтическая композиция, нарисованная светом в темноте. Уникальная техника light painting.',
                'image' => 'light-art-couple.jpg',
                'categories' => [$lightArt->id],
                'price' => 5000,
                'materials' => 'Light painting',
                'year' => 2024,
            ],
            [
                'title' => 'Light Art — Монах',
                'slug' => 'light-art-monk',
                'description' => 'Медитативный образ, созданный с помощью световых линий. Философия в свете.',
                'image' => 'light-art-monk.jpg',
                'categories' => [$lightArt->id],
                'price' => 5000,
                'materials' => 'Light painting',
                'year' => 2024,
            ],
            [
                'title' => 'Light Art — Промо',
                'slug' => 'light-art-promo',
                'description' => 'Промо-работа для шоу рисования светом. Магия света в каждом штрихе.',
                'image' => 'light-art-promo.jpg',
                'categories' => [$lightArt->id],
                'price' => 0,
                'materials' => 'Light painting',
                'year' => 2025,
            ],
        ];

        foreach ($artworks as $data) {
            $artwork = Artwork::updateOrCreate(
                ['slug' => $data['slug']],
                [
                    'title' => $data['title'],
                    'description' => $data['description'],
                    'price' => $data['price'],
                    'materials' => $data['materials'],
                    'year' => $data['year'],
                    'user_id' => $user->id,
                    'is_available' => true,
                    'is_featured' => in_array($data['slug'], ['mountain-landscape', 'angel', 'girl-in-shadow', 'light-art-couple']),
                    'width' => rand(30, 120),
                    'height' => rand(40, 150),
                ]
            );

            $artwork->categories()->sync($data['categories']);

            ArtworkImage::updateOrCreate(
                ['artwork_id' => $artwork->id, 'filename' => $data['image']],
                [
                    'original_name' => $data['image'],
                    'path' => 'artworks/' . $data['image'],
                    'mime_type' => str_ends_with($data['image'], '.png') ? 'image/png' : 'image/jpeg',
                    'size' => filesize(storage_path('app/public/artworks/' . $data['image'])),
                    'order' => 0,
                    'is_primary' => true,
                ]
            );
        }
    }
}
