<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            $data_user = User::firstOrCreate(array(
                'email' => "admin@transisi.id",
                'password' => "transisi"
            ));
            $data_user->save();

        echo "\n\n";
    }
}
