<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ProjectUp extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $user = new User;
       $user->name = 'John Doe';
       $user->email = 'johndoe@example.com';
       $user->password = bcrypt('password');
       $user->save();

       $adminRole = Role::create(['name' => 'admin']);
       $editorRole = Role::create(['name' => 'editor']);
       $user->assignRole($adminRole);

       $permissions = [
           'create task',
           'edit task',
           'delete task',
           'view task',
         
       ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
            $adminRole->givePermissionTo($permission);
        }

        $editorRole->givePermissionTo('view task');

        return;

       
    }
}
