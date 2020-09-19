<?php

use Illuminate\Support\Facades\Route;

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
    return redirect()->route('home');
});

Auth::routes([
    'register'=> false
]);

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware('auth')->group(function () {
    Route::resource('fabricantes', 'FabricanteController');
    Route::resource('produtos', 'ProdutoController');
    Route::get('lista-produtos', 'ProdutoController@listaProdutos')->name('lista.produtos');
    Route::resource('clientes', 'ClienteController');
    Route::get('lista-clientes', 'ClienteController@listaClientes')->name('lista.clientes');

    Route::resource('vendas', 'VendaController')->only([
        'index', 'create', 'store', 'show'
    ]);
});