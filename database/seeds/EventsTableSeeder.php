<?php

use Illuminate\Database\Seeder;

class EventsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('events')->delete();

        $user = DB::table('users')->first();

        $task = app()->make('App\Event');
        $task->fill([
        	'user_id' 		  => $user->id,
        	'title'           => 'Kajian Pra Ramadhan',
            'date_time_start' => '2017-01-01 12:00:00',
        	'date_time_end'   => '2017-01-01 15:00:00',
        	'place'			  => 'Masjid Al-Ukhuwah Perumahan Kavling UII',
        	'lat'			  => '-7.692855',
        	'long'			  => '110.420524',
        	'speaker'		  => 'Ustadz Nur Muhammad',
        	'poster'		  => 'http://mahadilmi.id/wp-content/uploads/2014/01/kajian-islam-sunnah.jpg',
        	'description'	  => 'Kajian ini diselenggaran oleh Takmir Masjid Al-Ukhuwah Perumahan Kavling UII.',
        	'loop'			  => '0'
        ]);
        $task->save();
    }
}
