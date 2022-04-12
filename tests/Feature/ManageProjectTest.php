<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ManageProjectTest extends TestCase
{

    use WithFaker, RefreshDatabase;

    /** @test */
    public function test_user_can_create_project()
    {

        $this->withoutExceptionHandling();

        $attributes = [
            'title' => $this->faker->sentence,
            'body' => $this->faker->paragraph
        ];

        $this->post('/projects', $attributes)->assertRedirect('/projects');

        $this->assertDatabaseHas('projects', $attributes);

        $this->get('/projects')->assertSee($attributes['title']);
    }
}
