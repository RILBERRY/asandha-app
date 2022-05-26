<?php
use App\http\controllers\PatientsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/patient', [PatientsController::class, 'patientsDetail']);
Route::get('/address', [PatientsController::class, 'addressesDetail']);
Route::get('/island', [PatientsController::class, 'islandsDetail']);


Route::post('/patient', [PatientsController::class, 'patient']);
Route::post('/island', [PatientsController::class, 'island']);
Route::post('/address', [PatientsController::class, 'address']);

