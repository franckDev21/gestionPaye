<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('welcome', function () {
    return view('welcome');
});

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::group(['middleware' =>['auth' , 'admin']] , function(){

    Route::get('/dash', 'DashboardController@index');
    
    Route::get('/barcode','BarcodeController@index');
    Route::get('/download/{id}/barcode',"BarcodeController@create");

    Route::get('/employe', 'EmployeController@index');
    Route::get('/employe/create', 'EmployeController@create');
    Route::post('/employe', 'EmployeController@store');
    Route::get('/employe/{employe}', 'EmployeController@show');
    Route::get('/employe/{employe}/edit', 'EmployeController@edit');
    Route::patch('/employe/{employe}', 'EmployeController@update');
    Route::delete('/employe/{employe}',  'EmployeController@destroy');

    Route::post('/employe/search/all','EmployeController@searchEmployes');

    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/gerer_paie' , 'GestPaieController@index');
    Route::get('search' , 'GestPaieController@search');
    Route::post('search' , 'GestPaieController@search');
    Route::post('searchAjax','GestPaieController@searchAjax');
    Route::get('/transaction', 'TransactionController@index');
    Route::post('/searchTransaction', 'TransactionController@search');
    Route::post('/payer-prime', 'TransactionController@payer');

    Route::get('/caisse', 'CaisseController@index');
    Route::post('/decaisser/{id_employer}','PrimeController@decaisser');
    Route::post('/save-caisse', 'CaisseController@ajouter');

    Route::get('edit-montant/{id}', 'CaisseController@editcaisse');
    Route::post('/modifie-montant/{id}', 'CaisseController@modifier');

    Route::post('/save-prime', 'PrimeController@ajouterprime');

});



