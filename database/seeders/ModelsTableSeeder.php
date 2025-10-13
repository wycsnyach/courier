<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;

class ModelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            
            ['id' => 1, 'name' => 'User', 'friendly' => 'Manage Users'],
            ['id' => 2, 'name' => 'Role', 'friendly' => 'Manage Roles'], 
            ['id' => 3, 'name' => 'Country', 'friendly' => 'Manage Countries'], 
            ['id' => 4, 'name' => 'Email', 'friendly' => 'Manage Emails'], 
            ['id' => 5, 'name' => 'Status', 'friendly' => 'Manage Statuses'], 
            ['id' => 6, 'name' => 'Paymentmode', 'friendly' => 'Manage Payment Modes'], 
          


        ];

        foreach ($items as $item) {

            $matchThese=['id'=>$item['id']];

            \App\Models\Mo::updateOrCreate($matchThese,$item);           

            
        }
    }
}
