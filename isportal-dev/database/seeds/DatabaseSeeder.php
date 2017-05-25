<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\User;
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User([
            'name' => 'Fake User',
            'ist_id' => 'ist0000',
            'email' => 'user@user.pt',
            'type' => 'student'
        ]);

        $user->save();

        $professor = new User([
            'name' => 'Fake Professor',
            'ist_id' => 'ist0001',
            'email' => 'prof@prof.pt',
            'type' => 'professor'
        ]);

        $professor->save();
    }
}
