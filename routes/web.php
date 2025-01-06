<?php

use App\Http\Controllers\AppointmentController;
use Illuminate\Support\Facades\Route;


Route::controller(AppointmentController::class)->group(function () {
    route::get("/", "index")->name("index");
    route::get("/create", "create")->name("create");
    route::post("/create", "store")->name("store");
    route::get("/show/{appointment}", "show")->name("show");
    route::get("/edit/{appointment}", "edit")->name("edit");
    route::patch("/edit/{appointment}", "update")->name("update");
    route::delete("/show/{appointment}", "destroy")->name("destroy");
});




