<?php

Route::group(array('before' => 'auth','prefix' => ''),function(){

    Route::any('/usuario', 'GraficoController@graficoHoras')->name('usuario');

});