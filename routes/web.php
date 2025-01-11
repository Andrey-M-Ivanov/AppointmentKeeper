<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Route;


Route::resource('appointments', AppointmentController::class);
Route::resource("clients", ClientController::class);

Route::get("/", function () {
    return redirect()->route("appointments.index");
});
