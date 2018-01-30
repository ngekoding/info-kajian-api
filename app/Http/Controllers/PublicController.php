<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

use App\Event;

class PublicController extends Controller
{
	public function index(Request $request)
	{
		$events = Event::paginate(1);

		if (count($events) !== 0) {
			$res['success'] = true;
			$res['message'] = $events;
		} else {
			$res['success'] = true;
			$res['message'] = 'No events.';
		}
		return response($res);
	}
}