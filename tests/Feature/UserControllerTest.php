<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Spatie\Permission\Models\Role;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $mockRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mockRepository = Mockery::mock(UserRepositoryInterface::class);
        $this->app->instance(UserRepositoryInterface::class, $this->mockRepository);

        $this->actingAs(User::factory()->create());
    }

    public function testIndex()
    {
        // Mocking the repository to return users with IDs
        $users = User::factory()->count(3)->create(); // Use create() to persist users and assign IDs
    
        $this->mockRepository
            ->shouldReceive('all')
            ->once()
            ->andReturn($users);
    
        $response = $this->get(route('admin.user.index'));
    
        // Ensure the status code is checked
        $response->assertStatus(200);
        $response->assertViewIs('admin.users.index');
        $response->assertViewHas('users');
    
        
    }

    public function testCreate()
    {
        $roles = Role::create(['name' => 'Admin']);
        
        $response = $this->get(route('admin.user.create'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.users.create');
        $response->assertViewHas('roles');
    }

    public function testStore()
    {
        $user = User::factory()->make();
        $data = [
            'name' => 'John Doe',
            'email' => 'test@example.com',
        ];

        $this->mockRepository
            ->shouldReceive('create')
            ->once()
            ->with($data)
            ->andReturn($user);

        $response = $this->post(route('api.user.store'), $data);
        $response->assertStatus(200);

    }
    
    public function testEdit()
    {
        $user = User::factory()->create(['id' => 1]);
    
        
    
        $this->mockRepository
            ->shouldReceive('find')
            ->once()
            ->with(1)
            ->andReturn($user);

    
        $response = $this->get(route('admin.user.edit', ['id' => 1]));
    
        $response->assertStatus(200); // Ensure the status code is checked
        $response->assertViewIs('admin.users.edit');
        $response->assertViewHas(['user', 'roles']);
    }
    


    public function testUpdate()
    {
        $user = User::factory()->make(['id' => 1]);
        $data = [
            'name' => 'John Doe',
            'email' => 'test@email.com',
        ];

        $this->mockRepository
            ->shouldReceive('update')
            ->once()
            ->with(1, $data)
            ->andReturn($user);

        $response = $this->post(route('api.user.update', ['id' => 1]), $data);
        $response->assertStatus(200);
    }

    public function testDestroy()
    {
        $this->mockRepository
            ->shouldReceive('delete')
            ->once()
            ->with(1);

        $response = $this->post(route('api.user.destroy', ['id' => 1]));
        $response->assertStatus(200);
    }


    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
