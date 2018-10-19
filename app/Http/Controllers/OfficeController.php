<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OfficeController extends Controller
{
    public function teste()
	{
		$data = Input::all();
		// $nome = Auth::user()->usu_nome;
		$date = date('d-m-Y',time());
		$hora = date('H:i:s:u',time());
		// Log::info("<< {$nome}, at: ,{$date}, {$hora} >> called TIMER blade" );
		$result = $this->_callService('TimerService', 'listarHoje') ;
		Log::info('<< DADOS VINDOS DO BANCO: >>', $result);		
		return view('timer.teste')
							// ->with('usuario',Auth::user())
							->with('time', $result);
    }
    
    public function salvarTimer()
	{
		$data = Input::all();		
		Log::info('<< metodo salvar no controler: >>', $data);	
		$result = $this->_callService('TimerService', 'salvar', $data) ;
		return json_encode($result);
	}
}
