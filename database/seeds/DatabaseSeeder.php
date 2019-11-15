<?php

use App\User;
use App\Restaurant;
use App\Order;
use App\Consumable;
use App\Openingtime;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = 'Jouri Zevenhek';
        $user->address = 'jijkomenhier';
        $user->zipcode = '1111gg';
        $user->city = 'Amsterdam';
        $user->phone = '061234567';
        $user->email = '186078@talnet.nl';
        $user->password = bcrypt('testtest');
        $user->is_admin = 1;
        $user->save();

        $user = new User();
        $user->name = 'Maximus Durpus';
        $user->address = 'jijhierhe 22b';
        $user->zipcode = '1111jb';
        $user->city = 'Amsterdam';
        $user->phone = '0623423423';
        $user->email = '123456789@talnet.nl';
        $user->password = bcrypt('testtest');
        $user->is_admin = 0;
        $user->save();

        $restaurant = new Restaurant();
        $restaurant->title = 'Oma Ietje';
        $restaurant->address = 'Heesterveld 3';
        $restaurant->zipcode = '1102SB';
        $restaurant->city = 'Amsterdam';
        $restaurant->phone = '0612345678';
        $restaurant->email = 'OmaIetje@talnet.nl';
        $restaurant->user_id = 1;
        $restaurant->save();

        $restaurant = new Restaurant();
        $restaurant->title = 'Ichi-E';
        $restaurant->address = 'ArenA Boulevard 175';
        $restaurant->zipcode = '1101EJ';
        $restaurant->city = 'Amsterdam';
        $restaurant->phone = '0644551122';
        $restaurant->email = 'Ichi-E@talnet.nl';
        $restaurant->user_id = 2;
        $restaurant->save();
        
        $restaurant = new Restaurant();
        $restaurant->title = 'Peepee';
        $restaurant->address = 'ArenA Douche 17';
        $restaurant->zipcode = '1107EJ';
        $restaurant->city = 'Amsterdam';
        $restaurant->phone = '0644557722';
        $restaurant->email = 'PeePee@talnet.nl';
        $restaurant->user_id = 2;
        $restaurant->save();

        $consumable = new Consumable;
        $consumable->title = 'candy';
        $consumable->category = 1;
        $consumable->price = 5;
        $consumable->restaurant_id = 1;
        $consumable->save();

        $openingtime = new Openingtime;
        $openingtime->restaurant_id = 1;
        $openingtime->open = '09:00:00';
        $openingtime->close = '18:00:00';
        $openingtime->save();

        $openingtime = new Openingtime;
        $openingtime->restaurant_id = 2;
        $openingtime->open = '12:00:00';
        $openingtime->close = '20:00:00';
        $openingtime->save();
    }
}
