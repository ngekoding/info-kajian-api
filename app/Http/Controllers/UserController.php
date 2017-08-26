<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\User;

class UserController extends Controller
{
	/**
	 * Register new user
	 *
	 * @param $request Request
	 */
	public function create(Request $request)
	{
		// Validating data
		$validator = Validator::make($request->all(), [
			'name'		=> 'required',
			'username' 	=> 'required|unique:users',
			'email'		=> 'required|email|unique:users',
			'password'	=> 'required'
		]);

		if ($validator->fails()) {
			$res['success'] = false;
			$res['message'] = $validator->messages();
			return response($res);
		}

		$hasher = app()->make('hash');

		$name 	  = $request->input('')
		$username = $request->input('username');
		$email	  = $request->input('email');
		$password = $hasher->make($request->input('password'));

		$create = User::create([
			'name'	   => $name,
			'username' => $username,
			'email'	   => $email,
			'password' => $password
		]);

		if ($create) {
			$res['success'] = true;
			$res['message'] = 'New user registered.';
		} else {
			$res['success'] = false;
			$res['message'] = 'Failed to create user.';
		}

		return response($res);
	}

	public function getUser(Request $request, $id)
	{
		$user = User::where('id', $id)->get();

		if ($user) {
			$res['success'] = true;
			$res['message'] = $user;
		} else {
			$res['success'] = false;
			$res['message'] = 'Can\'t find user!';
		}

		return response($res);
	}
}