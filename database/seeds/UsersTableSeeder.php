<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $hasher = app()->make('hash');

        DB::table('users')->delete();
        
        $user = app()->make('App\User');
        $user->fill([
        	'name'		=> 'Nur Muhammad',
        	'username' 	=> 'ngekoding',
        	'email'		=> 'about.nurmuhammad@gmail.com',
        	'password'	=> $hasher->make('1sampai8'),
        	'api_token'	=> sha1(time())
        ]);
        $user->save();
    }
}
