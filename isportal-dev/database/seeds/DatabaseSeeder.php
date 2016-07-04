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
        $faker = Faker\Factory::create();

        factory(App\User::class, 'organization', 10)->create()
            ->each(function ($u) {
                factory(App\Activity::class, 4)->create([
                    "creator_id" => $u->id
                ]);
            });

        $user = factory(App\User::class, 'organization')->create([
            'name' => 'Nokia',
            'email' => 'nokia@nokia.pt',
            'password' => bcrypt('nokia999')
        ]);

        factory(App\Activity::class, 6 )->create([
            'creator_id' => $user->id
        ]);

        $professor = new User([
            'name' => 'Mr Professor',
            'email' => 'prof@prof.pt',
            'password' => bcrypt('prof999'),
            'type' => 'professor'
        ]);

        $professor->save();

    }
}
