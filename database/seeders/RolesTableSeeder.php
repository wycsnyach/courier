<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use App\Models\Role;
use Bouncer;
class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

  

    public function run()
    {
        $roles=['Admin','Treasury','Management','Normal','Clerk'];

        foreach($roles as $role){

	        Bouncer::role()->firstOrCreate([
	           'name' => $role,
	           'title' => $role,

	        ]);

        }
    }
}
