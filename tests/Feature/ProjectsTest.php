<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function a_user_can_create_a_project()
    {

        // $this->withExceptionHandling();
        $this->actingAs(factory('App\User')->create());


        $attr = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph
        ];
        $this->post('/projects',  $attr)->assertRedirect('/projects');

        $this->assertDatabaseHas('projects', $attr);

        $this->get('projects')->assertSee($attr['title']);
    }

    /** @test */
    public function a_user_can_view_a_project()
    {
        // $this->withoutExceptionHandling();

        $project = factory('App\Project')->create();
        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);
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
    public function only_authenticated_users_can_create_projects()
    {
        // $this->withoutExceptionHandling();

        $attr = factory('App\Project')->raw();
        $this->post('/projects',  $attr)->assertRedirect('login');
    }
}
