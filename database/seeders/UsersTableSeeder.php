<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Role;
use App\Models\User;
use Bouncer;
use Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role=Bouncer::role()->firstOrCreate([
        'name' => 'Admin',
        'title' => 'Admin',
        ]);


        $user= User::updateOrCreate(
            ['first_name' => 'Demo', 
            'middle_name' => 'Test', 
            'last_name' => 'User',
            'email' =>'admin@admin.com',
            'phone_number' => '+254735465970',
            'password' => Hash::make('MyD3m0d@t@'),
            'role_id' => $role->id
            ]
        );    
      
        $models=['User','Role','Country','Supplier','Status','Paymentmode','Productcategory',
        'Product','colors','Email'];
        $actions=['Create','View','Edit','Delete'];
        
    

        foreach($models as $model){

          foreach($actions as $action){

                $ability = Bouncer::ability()->firstOrCreate([
                    'name' => $action."_".$model,
                    'title' =>$action." ".$model,
                ]);

                Bouncer::allow($role)->to($ability);
             }

        } 


       
        Bouncer::assign($role)->to($user);
    }
}
