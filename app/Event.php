<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
	
	protected $table = 'events';

	protected $fillable = ['user_id', 'title', 'date_time_start', 'date_time_end', 'place', 'long', 'lat', 'speaker', 'poster', 'description', 'loop'];

}