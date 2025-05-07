<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssetController;
use Illuminate\Support\Facades\Auth;
use App\Models\Asset;

Route::get('/', function () {
    if(Auth::check()) {
        Auth::logout();
        return view('auth/login');
    }
    else {
        return view('auth/login');
    }
})->name('login');

Route::post('login', [AssetController::class, 'login']);

Route::middleware(['auth'])->group(function () {

    Route::get('/asset_form', function () {
        return view('asset_form');
    });

    Route::match(['get','post'],'/asset_list', function () {
        return view('asset_list');
    });

    Route::get('/logout', function() {
        return redirect()->route('login');
    });

    Route::get('ch_pwd_form', function() {
        return view('auth/ch_pwd_form');
    });

    Route::get('ins_new_usr', function () {
        return view('new_user_form');
    });

    Route::get('/asset_manager', function () {
        return view('welcome');
    });

    Route::get("/mng_user", function() {
        return view('auth/mng_user');
    });

     Route::get('/ass_form/{asset_id}', function($asset_id) {
        return view('assign_form', ['id' => $asset_id]);
    });

    Route::post('/validate', [AssetController::class,'createAsset']);

    Route::post('/loadDevice',[AssetController::class,'loadDeviceSelect']);

    Route::post('/loadCompany',[AssetController::class,'loadCompanySelect']);

    Route::post('/loadName', [AssetController::class,'loadNameSelect']);

    Route::post('createTable/{value}', [AssetController::class,'getAsset']);

    Route::post('ch_pwd/{id}', [AssetController::class,'ch_pwd']);

    Route::post('new_usr', [AssetController::class, 'new_usr']);

    Route::post('ass_asset/{asset_id}', [AssetController::class, 'ass_asset']);

    Route::post('del_asset/{asset_id}', [AssetController::class, 'del_asset']);

});

Route::fallback(function () {
    abort(404);
});
