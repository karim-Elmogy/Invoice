<?php
namespace Database\Seeders;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $user = User::create([
            'name' => 'Karim Elmogy',
            'email' => 'kimo72636@gmail.com',
            'password' => bcrypt('12345678'),
            'roles_name' => ["owner"],
            'Status' => 'مفعل',
            'image' => '',
        ]);

        $role = Role::create(['name' => 'owner']);

        $permissions = Permission::pluck('id','id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);


    }
}
