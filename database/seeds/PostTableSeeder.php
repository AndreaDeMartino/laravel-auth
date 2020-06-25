<?php

use Illuminate\Database\Seeder;
use App\Post;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        
        for ($i = 0; $i < 10; $i++) { 
            $newPost = new Post();
            $randomTitle = $faker->text(10);

            $newPost->user_id = 2;
            $newPost->title = $randomTitle;
            $newPost->body = $faker->paragraph(3, true);
            $newPost->slug = Str::slug($randomTitle, '-');

            $newPost->save();
        }
    }
}
