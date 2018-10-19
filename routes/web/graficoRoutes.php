<?php

Route::name('grafico.')->prefix('grafico')->group(function()
{
    Route::any('/diario', 'GraficoController@graficoHoras')->name('diario');
});