<?php
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;
    /** @test */
    public function a_user_can_create_a_project()
    {
        $this->withExceptionHandling();
        $this->actingAs(factory('App\User')->create());
        $this->get('/projects/create')->assertStatus(200);
        $attr = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph
        ];
        $this->post('/projects',  $attr)->assertRedirect('/projects');
        $this->assertDatabaseHas('projects', $attr);
        $this->get('projects')->assertSee($attr['title']);
    }
    /** @test */
    public function a_user_can_view_their_project()
    {
        $this->be(factory('App\User')->create());
        $project = factory('App\Project')->create(['owner_id' => auth()->id()]);
        $this->get($project->path())
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
        // $this->withoutExceptionHandling();
        $project = factory('App\Project')->create();
        $this->post('/projects',  $project->toArray())->assertRedirect('login');
        $this->get('/projects')->assertRedirect('login');
        $this->get('/projects/create')->assertRedirect('login');
        $this->get($project->path())->assertRedirect('login');
    }
}
