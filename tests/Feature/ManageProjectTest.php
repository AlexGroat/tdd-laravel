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
    public function test_guests_have_no_access_to_projects()
    {
        $project = Project::factory()->create();

        $this->get('/projects')->assertRedirect('login');
        $this->get('/projects/create')->assertRedirect('login');
        $this->post('/projects', $project->toArray())->assertRedirect('login');
        $this->get($project->path())->assertRedirect('login');
    }

    /** @test */
    public function test_user_can_create_project()
    {

        $this->withoutExceptionHandling();

        $this->actingAs(User::factory()->create());

        $this->get('/projects/create')->assertStatus(200);

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
    public function test_user_can_view_their_project()
    {
        $this->be(User::factory()->create());

        $this->withoutExceptionHandling();

        // be method logged in user is the owner of this project
        $project = Project::factory()->create(['owner_id' => auth()->id()]);

        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);
    }

    /** @test */
    public function test_user_cannot_view_others_projects()
    {
        $this->be(User::factory()->create());

        // $this->withoutExceptionHandling();

        $project = Project::factory()->create();

        $this->get($project->path())->assertStatus(403);
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
