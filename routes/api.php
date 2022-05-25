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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::resource('patients', PatientsController::class );

//to list All the data of the table
Route::get('/patient', [PatientsController::class, 'patientsDetail']);
Route::get('/address', [PatientsController::class, 'addressesDetail']);
Route::get('/island', [PatientsController::class, 'islandsDetail']);

// to post data from form include patient info, address info, island info
Route::post('/patient', [PatientsController::class, 'store']);


