<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ManageProjectTest extends TestCase
{

    use WithFaker, RefreshDatabase;

    /** @test */
    public function test_auth_users_can_create_projects()
    {
        $attributes = Project::factory()->raw();

        $this->post('/projects', $attributes)->assertRedirect('login');
    }

    /** @test */
    public function test_user_can_create_project()
    {

        $this->withoutExceptionHandling();

        $this->actingAs(User::factory()->create());

        $attributes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph
        ];

        // post a new project and be redirected to the projects endpoint
        $this->post('/projects', $attributes)->assertRedirect('/projects');

        // assert database has a projects table with a project inside
        $this->assertDatabaseHas('projects', $attributes);

        // assert projects table has a column for title
        $this->get('/projects')->assertSee($attributes['title']);
    }

    /** @test */
    public function test_user_can_view_a_project()
    {
        $this->withoutExceptionHandling();

        $this->actingAs(User::factory()->create());

        $project = Project::factory()->create();

        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);
    }

    /** @test */
    public function test_project_requires_title()
    {
        $this->actingAs(User::factory()->create());

        // raw builds up attributes, but stores it as an array
        $attributes = Project::factory()->raw(['title' => []]);

        $this->post('/projects', $attributes)->assertSessionHasErrors('title');
    }

    /** @test */
    public function test_project_requires_description()
    {
        $this->actingAs(User::factory()->create());

        $attributes = Project::factory()->raw(['description' => []]);

        $this->post('/projects', $attributes)->assertSessionHasErrors('description');
    }
}
