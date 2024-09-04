<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Project;
use App\Repositories\ProjectRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery;

class ProjectControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $mockRepository;

    protected function setUp(): void
    {
        parent::setUp();

        // Set up a mock repository
        $this->mockRepository = Mockery::mock(ProjectRepositoryInterface::class);
        $this->app->instance(ProjectRepositoryInterface::class, $this->mockRepository);

        // Authenticate a test user
        $this->actingAs(User::factory()->create());
    }

    public function testStoreProject()
    {
        // Arrange: Prepare the input data
        $data = [
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
        ];
    
        // Act: Expect the repository's create method to be called with this data
        $this->mockRepository
            ->shouldReceive('create')
            ->once()
            ->with($data);
    
        // Act: Make a POST request to the store route
        $response = $this->post(route('api.project.store'), $data);
        $response->assertStatus(200);
    }


    public function testUpdateProject()
    {
        $project = Project::factory()->make(['id' => 1]);

        $data = [
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
        ];

        $this->mockRepository
            ->shouldReceive('update')
            ->once()
            ->with(1, $data);

        $response = $this->post(route('api.project.update', 1), $data);
        $response->assertStatus(200);

    }

    public function testDestroyProject()
    {
        $this->mockRepository
            ->shouldReceive('delete')
            ->once()
            ->with(1);

        $response = $this->post(route('api.project.destroy', 1));
        $response->assertStatus(200);
    }

    public function testEditProject()
    {
        $project = Project::factory()->make(['id' => 1]);

        $this->mockRepository
            ->shouldReceive('find')
            ->once()
            ->with(1)
            ->andReturn($project);

        $response = $this->get(route('admin.project.edit', 1));
        $response->assertViewIs('admin.project.edit');
        $response->assertViewHas('project', $project);
    }

    public function testCreateProject()
    {
        $response = $this->get(route('admin.project.create'));
        $response->assertViewIs('admin.project.create');
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
