<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Repositories\RoleRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $mockRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mockRepository = Mockery::mock(RoleRepositoryInterface::class);
        $this->app->instance(RoleRepositoryInterface::class, $this->mockRepository);

        $this->actingAs(User::factory()->create());
    }

    public function testIndex()
    {
        // Create roles manually
        $roles = Role::create(['name' => 'Admin']);
        $roles = Role::create(['name' => 'User']);

        $this->mockRepository
            ->shouldReceive('all')
            ->once()
            ->andReturn(collect([$roles]));

        $response = $this->get(route('admin.role.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.roles.index');
        $response->assertViewHas('roles');
    }

    public function testCreate()
    {
        // Create permissions manually
        $permissions = Permission::create(['name' => 'edit articles']);
        $permissions = Permission::create(['name' => 'delete articles']);

        $response = $this->get(route('admin.role.create'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.roles.create');
        $response->assertViewHas('permissions');
    }

    public function testStore()
    {
        // Create permissions manually
        $permissions = Permission::create(['name' => 'edit articles']);
        $permissions = Permission::create(['name' => 'delete articles']);

        $roleData = [
            'name' => 'New Role',
            'permission' => [$permissions->id]
        ];

        $this->mockRepository
            ->shouldReceive('create')
            ->once()
            ->with(['name' => 'New Role'])
            ->andReturn(Role::create(['name' => 'New Role']));

        $response = $this->post(route('api.role.store'), $roleData);

        $response->assertStatus(200);
    }

    public function testEdit()
    {
        
        // Create role and permissions manually
        $role = Role::create(['name' => 'AdminTwo']);
        $permissions = Permission::create(['name' => 'edit articles']);
        $permissions = Permission::create(['name' => 'delete articles']);

        // Assign permissions to role
        $role->syncPermissions([$permissions]);

        $this->mockRepository
            ->shouldReceive('find')
            ->once()
            ->with($role->id)
            ->andReturn($role);

        $response = $this->get(route('admin.role.edit', ['id' => $role->id]));

        $response->assertStatus(200);
        $response->assertViewIs('admin.roles.edit');
        $response->assertViewHas('role');
        $response->assertViewHas('permissions');
    }

    public function testUpdate()
    {
        // Create role and permissions manually
        $role = Role::create(['name' => 'AdminTwo']);
        $permissions = Permission::create(['name' => 'edit articles']);
        $permissions = Permission::create(['name' => 'delete articles']);

        $roleData = [
            'name' => 'Updated Role',
            'permission' => [$permissions->id]
        ];

        $this->mockRepository
            ->shouldReceive('update')
            ->once()
            ->with($role->id, ['name' => 'Updated Role'])
            ->andReturn($role);

        $response = $this->post(route('api.role.update', ['id' => $role->id]), $roleData);

        $response->assertStatus(200);
    }

    public function testDestroy()
    {
        // Create role manually
        $role = Role::create(['name' => 'test']);

        $this->mockRepository
            ->shouldReceive('delete')
            ->once()
            ->with($role->id);

        $response = $this->post(route('api.role.destroy', ['id' => $role->id]));

        $response->assertStatus(200);

        
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}

