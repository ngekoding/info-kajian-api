<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', function () use ($app) {
    return 'Build with Lumen and Love by Nur Muhammad - blog.nurmuhammad@gmail.com';
});

$app->post('/login', 'LoginController@index');
$app->post('/register', 'UserController@create');

$app->group(['middleware' => 'auth'], function() use ($app) {
	$app->get('/user/{id}', 'UserController@getUser');
	
	$app->get('/events', 'EventController@index');
	$app->get('/event/detail/{id}', 'EventController@detail');
	$app->post('/event', 'EventController@create');
	$app->put('/event/{id}', 'EventController@update');
	$app->delete('/event/{id}', 'EventController@delete');
});

