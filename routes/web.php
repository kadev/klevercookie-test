<?php

use App\Models\PetInfo;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetInfoController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $client = new Client(); //GuzzleHttp\Client
    $url = "https://api.thedogapi.com/v1/breeds?limit=150";

    $response = $client->request('GET', $url, [
        'verify'  => false,
    ]);

    $breeds = json_decode($response->getBody());

    return view('index', compact('breeds'));
})->name("new-pet");

Route::post("/meals/create-custom-plan", [PetInfoController::class, 'store'])->name("create-custom-plan");

Route::get('/successful-creation/{pet_id}', function ($pet_id) {
    $pet = PetInfo::find($pet_id);

    return view('successful-creation', compact('pet'));
})->name('successful-pet-creation');

Route::get('/pets', function () {
    $pets = PetInfo::all()->sortByDesc("id");
    return view('pets', compact('pets'));
})->name('pets');

Route::get("/pets/delete/{pet_id}", [PetInfoController::class, 'destroy'])->name("delete-pet");
