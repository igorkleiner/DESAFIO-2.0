<?php

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
// Route::group(array('before' => 'auth','prefix' => ''),function(){
    $glob_file = __DIR__.DIRECTORY_SEPARATOR.'web'.DIRECTORY_SEPARATOR.'*';
    foreach(glob($glob_file) as $file)
    {
        include $file;
    }
// });

Route::get('/', 'UsuarioController@usuario');
// Route::get('/', function () { return view('welcome');});
Route::get('/home', 'HomeController@index')->name('home');
Auth::routes();
#rota funcional
Route::get('/phpinfo', function(){phpinfo();});