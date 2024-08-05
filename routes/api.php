<?php
use App\Http\Controllers\client\CarInformationController;
use App\Http\Controllers\admin\RequestStatusController;
use App\Http\Controllers\client\UserImageController;
use App\Http\Controllers\client\UserInformationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Authentication\AuthController;
use App\Http\Controllers\authorized\AuthorizedController;
use App\Http\Controllers\superAdmin\PromoteAdminController;
use App\Http\Controllers\superAdmin\SuperAdminController;
use Illuminate\Session\Middleware\StartSession;


// login Route 
Route::post('/login',AuthController::class . '@login');
Route::post('/register',AuthController::class . '@register');
Route::group(['middleware' => [StartSession::class]], function () {
    Route::get('/login/google', [AuthController::class, 'redirectToGoogle']);
    Route::get('/callback/google', [AuthController::class, 'handleGoogleCallback']);
});
Route::get('/users',AuthController::class . '@index')->middleware(['auth:sanctum']);
Route::post('/logout',AuthController::class . '@logout')->middleware(['auth:sanctum']);
Route::get('check-role',AuthController::class . '@checkRole')->middleware(['auth:sanctum']);

//client routes
Route::apiResource('/badge-request/user-information',UserInformationController::class)->middleware(['auth:sanctum']);
Route::apiResource('/badge-request/user-image',UserImageController::class)->middleware(['auth:sanctum']);
Route::apiResource('/badge-request/car-information',CarInformationController::class)->middleware(['auth:sanctum']);

//admin routes
Route::get('admin/requests',RequestStatusController::class . '@index')->middleware(['auth:sanctum']);
Route::get('admin/requests/{name}',RequestStatusController::class . '@requests')->middleware(['auth:sanctum']);
Route::post('admin/requests/send-mail',RequestStatusController::class . '@sendMail')->middleware(['auth:sanctum']);

//authorized routes
Route::get('authorize/requests/{name}',AuthorizedController::class . '@requests')->middleware(['auth:sanctum']);
Route::get('authorize/requests',AuthorizedController::class . '@index')->middleware(['auth:sanctum']);
Route::post('authorize/requests/send-mail',AuthorizedController::class . '@sendMail')->middleware(['auth:sanctum']);
Route::post('authorize/requests',AuthorizedController::class . '@store')->middleware(['auth:sanctum']);

// super admin
Route::get('super-admin/received-badge',SuperAdminController::class . '@receivedBadge')->middleware(['auth:sanctum']);
Route::get('super-admin/unreceived-badge',SuperAdminController::class . '@unReceivedBadge')->middleware(['auth:sanctum']);
Route::get('super-admin/certified-From-Authorizer',SuperAdminController::class . '@certifiedFromAuthorizer')->middleware(['auth:sanctum']);
Route::get('super-admin/to-print',SuperAdminController::class . '@waitToPrinting')->middleware(['auth:sanctum']);
Route::get('super-admin/rejected',SuperAdminController::class . '@rejected')->middleware(['auth:sanctum']);
Route::apiResource('super-admin/employees',PromoteAdminController::class)->middleware(['auth:sanctum']);