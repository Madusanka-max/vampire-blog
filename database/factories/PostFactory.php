<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->sentence(6);
        
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'content' => $this->faker->paragraphs(15, true),
            'image' => $this->faker->optional()->imageUrl(1280, 720, 'blog', true),
            'user_id' => \App\Models\User::factory(),
            'category_id' => \App\Models\Category::factory(),
            'status' => $this->faker->randomElement(['draft', 'published', 'archived']),
            'published_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => now(),
        ];
    }

    /**
     * Configure the model factory with relationships
     */
    public function configure()
    {
        return $this->afterCreating(function (\App\Models\Post $post) {
            // Attach 3-5 random tags
            $tags = \App\Models\Tag::inRandomOrder()
                ->limit($this->faker->numberBetween(3, 5))
                ->get();
            
            $post->tags()->attach($tags);
        });
    }

    /**
     * State for published posts
     */
    public function published()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'published',
                'published_at' => now(),
            ];
        });
    }

    /**
     * State for draft posts
     */
    public function draft()
    {
        return $this->state([
            'status' => 'draft',
            'published_at' => null,
        ]);
    }
}