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

Route::get('/patientinfo', [PatientsController::class, 'PatientInfo']);
Route::get('/patient', [PatientsController::class, 'patientsDetail']);
Route::get('/address', [PatientsController::class, 'addressesDetail']);
Route::get('/island', [PatientsController::class, 'islandsDetail']);
Route::get('/patient/{id}', [PatientsController::class, 'showPatient']);
Route::get('/address/{id}', [PatientsController::class, 'showAddress']);


Route::post('/patient', [PatientsController::class, 'patient']);
Route::post('/island', [PatientsController::class, 'island']);
Route::post('/address', [PatientsController::class, 'address']);
Route::put('/patient/{id}', [PatientsController::class, 'UpdatePatient']);
Route::put('/address/{id}', [PatientsController::class, 'UpdateAddress']);
Route::delete('/patient/{id}', [PatientsController::class, 'delPatient']);
Route::delete('/address/{id}', [PatientsController::class, 'delAddress']);

