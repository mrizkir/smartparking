<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () use ($router) {
  return 'Smart Car Parking API versi 1';
});

Route::group(['prefix'=>'v1', 'middleware'=>'api'], function () use ($router)
{
	//sensor login	
	$router->get('/sensor/{id}', [App\Http\Controllers\Data\SensorController::class, 'show'])->name('sensor.show');	
  $router->post('/sensor', [App\Http\Controllers\Data\SensorController::class, 'store'])->name('sensor.store');	
});