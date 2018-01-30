<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

use App\Event;

class EventController extends Controller
{
	private $user_id;

	public function __construct(Request $request)
	{
		$this->user_id = $request->user()->id;
	}

	/**
	 * get all event by user id
	 */
	public function index(Request $request)
	{
		$events = Event::where('user_id', $this->user_id)->paginate(10);

		if (count($events) !== 0) {
			$res['success'] = true;
			$res['message'] = $events;
		} else {
			$res['success'] = true;
			$res['message'] = 'No events.';
		}
		return response($res);
	}

	/**
	 * get event detail
	 */
	public function detail(Request $request, $id)
	{
		$event = Event::find($id);

		if (count($event) !== 0) {
			$res['success'] = true;
			$res['message'] = $event;
		} else {
			$res['success'] = false;
			$res['message'] = 'Not found.';
		}
		return response($res);
	}

	public function create(Request $request)
	{
		// Validating data
		$validator = Validator::make($request->all(), [
			'title' 			=> 'required',
			'date_time_start' 	=> 'required',
			'date_time_end' 	=> 'required',
			'place'				=> 'required',
			'speaker'			=> 'required',
			'description' 		=> 'required'
		]);

		if ($validator->fails()) {
			$res['success'] = false;
			$res['message'] = array_values($validator->messages()->all());
			return response($res);
		}

		$imageName = NULL;
		if (!empty($request->file('poster'))) {
			$imageName  = time().'.'.$request->file('poster')->getClientOriginalExtension();
			$uploadPath = base_path().'/public/assets/posters/';

			$request->file('poster')->move($uploadPath, $imageName);
		}

		$event = new Event();

		$event->fill([
			'user_id'			=> $this->user_id,
			'title'	  			=> $request->input('title'),
			'date_time_start' 	=> $request->input('date_time_start'),
			'date_time_end' 	=> $request->input('date_time_end'),
			'place'				=> $request->input('place'),
			'lat'				=> $request->input('lat'),
			'long'				=> $request->input('long'),
			'speaker'			=> $request->input('speaker'),
			'poster'			=> $imageName,
			'description' 		=> $request->input('description'),
			'loop' 				=> $request->input('loop')
		]);
		
		if ($event->save()) {
			$res['success'] = true;
			$res['message'] = ['New event created.'];
		} else {
			$res['success'] = false;
			$res['message'] = ['Failed creating event.'];
		}
		return response($res);
	}

	public function update(Request $request, $id)
	{
		// Validating data
		$validator = Validator::make($request->all(), [
			'title' 			=> 'required',
			'date_time_start' 	=> 'required',
			'date_time_end' 	=> 'required',
			'place'				=> 'required',
			'speaker'			=> 'required',
			'description' 		=> 'required'
		]);

		if ($validator->fails()) {
			$res['success'] = false;
			$res['message'] = array_values($validator->messages()->all());
			return response($res);
		}

		$event = Event::find($id);

		$event->title 			= $request->input('title');
		$event->date_time_start = $request->input('date_time_start');
		$event->date_time_end 	= $request->input('date_time_end');
		$event->place 			= $request->input('place');
		$event->lat 	  		= $request->input('lat');
		$event->long 			= $request->input('long');
		$event->speaker			= $request->input('speaker');
		$event->poster 			= $request->input('poster');
		$event->description 	= $request->input('description');
		$event->loop 			= $request->input('loop');

		if ($event->save()) {
			$res['success'] = true;
			$res['message'] = ['Event updated.'];
		} else {
			$res['success'] = false;
			$res['message'] = ['Failed updating event.'];
		}
		return response($res);
	}

	public function delete(Request $request, $id)
	{
		$event = Event::find($id);
		
		if ($event->delete()) {
			$res['success'] = true;
			$res['message'] = ['Event deleted.'];
		} else {
			$res['success'] = false;
			$res['message'] = ['Failed deleting event.'];
		}
		return response($res);

	}
}