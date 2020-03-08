<?php

use App\Models\Reservation;
use Illuminate\Database\Seeder;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Reservation::class, 15)->create();

        $user = factory(Reservation::class, 16)->create([
            'flight_id' => 5,
            'class' => 1,
        ]);
    }
}
