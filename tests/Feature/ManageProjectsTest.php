<?php

namespace Tests\Feature;


use App\Project;
use App\Task;
use Facades\Tests\Setup\ProjectFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;
    /** @test */
    public function a_user_can_create_a_project()
    {
        $this->signIn();
        $this->get('/projects/create')->assertStatus(200);
        $attr = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->sentence,
            'notes' => 'General notes.'
        ];
        $response = $this->post('/projects',  $attr);
        $project = Project::where($attr)->first();
        $response->assertRedirect($project->path());
        $this->get($project->path())
            ->assertSee($attr['title'])
            ->assertSee($attr['description'])
            ->assertSee($attr['notes']);
    }

    /** @test */
    public function a_user_can_update_a_project()
    {
        $project = ProjectFactory::create();
        $this->actingAs($project->owner)
            ->patch($project->path(), $attributes = ['title' => 'changed', 'description' => 'changed', 'notes' => 'Changed'])
            ->assertRedirect($project->path());
        $this->get($project->path() . '/edit')->assertOk();
        $this->assertDatabaseHas('projects', $attributes);
    }

    /** @test */
    public function a_user_can_update_a_projects_general_notes()
    {
        $project = ProjectFactory::create();
        $this->actingAs($project->owner)
            ->patch($project->path(), $attributes = ['notes' => 'Changed']);
        $this->assertDatabaseHas('projects', $attributes);
    }
    /** @test */
    public function a_user_can_view_their_project()
    {
        $project = ProjectFactory::create();
        $this->actingAs($project->owner)
            ->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);
    }
    /** @test */
    public function an_authenticated_user_cannot_view_projects_of_others()
    {
        $this->be(factory('App\User')->create());
        $project = factory('App\Project')->create();
        $this->get($project->path())->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_cannot_update_projects_of_others()
    {
        $this->be(factory('App\User')->create());
        $project = factory('App\Project')->create();
        $this->patch($project->path())->assertStatus(403);
    }
    /** @test */
    public function a_project_requires_a_title()
    {
        $this->actingAs(factory('App\User')->create());
        $attr = factory('App\Project')->raw(['title' => '']);
        $this->post('/projects',  $attr)->assertSessionHasErrors('title');
    }
    /** @test */
    public function a_project_requires_a_description()
    {
        $this->actingAs(factory('App\User')->create());
        $attr = factory('App\Project')->raw(['description' => '']);
        $this->post('/projects',  $attr)->assertSessionHasErrors('description');
    }
    /** @test */
    public function guests_cannot_manage_projects()
    {
        $project = factory('App\Project')->create();
        $this->post('/projects',  $project->toArray())->assertRedirect('login');
        $this->get('/projects')->assertRedirect('login');
        $this->get('/projects/create')->assertRedirect('login');
        $this->get($project->path())->assertRedirect('login');
        $this->get($project->path() . '/edit')->assertRedirect('login');
    }
}
