<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

use App\User;

class LoginController extends Controller
{
	/**
	 * Index login controller
	 *
	 * When user success login, will retrive callback as api_token
	 */
	public function index(Request $request)
	{
		// Validating data
		$validator = Validator::make($request->all(), [
			'email'		=> 'required|email',
			'password'	=> 'required'
		]);

		if ($validator->fails()) {
			$res['success'] = false;
			$res['message'] = $validator->messages();
			return response($res);
		}

		$hasher = app()->make('hash');

		$email		= $request->input('email');
		$password	= $request->input('password');

		$login = User::where('email', $email)->first();

		if (!$login) {
			$res['success'] = false;
			$res['message'] = 'Incorrect username or password.';
		} else {
			if ($hasher->check($password, $login->password)) {
				$api_token 	  = sha1(time());
				$create_token = User::where('id', $login->id)->update(['api_token' => $api_token]);
				if ($create_token) {
					$res['success']   = true;
					$res['message']   = ['api_token' => $api_token, 'user' => $login];
				}
			} else {
				$res['success'] = false;
				$res['message'] = 'Incorrect username or password.';
			}
		}
		return response($res);
	}
}