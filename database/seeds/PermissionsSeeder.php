<?php
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    /**
     * Create the initial roles and permissions.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'edit permission']);
        Permission::create(['name' => 'edit own permission']);
        Permission::create(['name' => 'delete permission']);
        Permission::create(['name' => 'delete own permission']);
        Permission::create(['name' => 'publish permission']);
        Permission::create(['name' => 'unpublish permission']);
        Permission::create(['name' => 'create permission']);
        Permission::create(['name' => 'view permission']);
        Permission::create(['name' => 'viewAny permission']);

        // create roles and assign existing permissions
        $role1 = Role::create(['name' => 'writer']);
        $role1->givePermissionTo('edit own permission');
        $role1->givePermissionTo('create permission');
        $role1->givePermissionTo('view permission');
        $role1->givePermissionTo('viewAny permission');
        $role1->givePermissionTo('delete own permission');

        $role2 = Role::create(['name' => 'admin']);
        $role2->givePermissionTo('edit permission');
        $role2->givePermissionTo('publish permission');
        $role2->givePermissionTo('unpublish permission');

        $role3 = Role::create(['name' => 'Super Admin']);
        // gets all permissions via Gate::before rule; see AuthServiceProvider

        // create demo users
        $user = Factory(App\User::class)->create([
            'name' => 'I\'m Writer',
            'email' => 'writer@example.com',
            // factory default password is 'password'
        ]);
        $user->assignRole($role1);

        $user = Factory(App\User::class)->create([
            'name' => 'I\'m Admin',
            'email' => 'admin@example.com',
            // factory default password is 'password'
        ]);
        $user->assignRole($role2);
        $user->assignRole($role1);

        $user = Factory(App\User::class)->create([
            'name' => 'I\'m Super Admin',
            'email' => 'superadmin@example.com',
            // factory default password is 'password'
        ]);
        $user->assignRole($role3);
    }
}