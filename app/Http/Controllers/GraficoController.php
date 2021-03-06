<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GraficoController extends Controller
{
    public function graficoHoras(){
		// $nome = Auth::user()->usu_nome;
		$date = date('d-m-Y',time());
		$hora = date('H:i:s:u',time());
		$result = $this->_callService('TimerService', 'minhasHoras') ;
		// Log::info("<< {$nome}, at: ,{$date}, {$hora} >> called GRAFICO blade" );
		return View::make('timer.grafico')
							->with('usuario',Auth::user())
							->with('grafico', $result);
	}
}
