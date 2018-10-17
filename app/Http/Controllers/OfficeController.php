<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OfficeController extends Controller
{
    public function teste()
	{
		$data = Input::all();
		$nome = Auth::user()->usu_nome;
		$date = date('d-m-Y',time());
		$hora = date('H:i:s:u',time());
		$true = true;
		Log::info("<< {$nome}, at: ,{$date}, {$hora} >> called TIMER blade" );
		$result = MakeRequest::callService('TimerService', 'listarHoje') ;
		Log::info('<< DADOS VINDOS DO BANCO: >>', $result);		
		return View::make('timer.teste')
							->with('usuario',Auth::user())
							->with('time', $result)
							->with('true',$true);
    }
    
    public function salvarTimer()
	{
		$data = Input::all();		
		Log::info('<< metodo salvar no controler: >>', $data);	
		$result = MakeRequest::callService('TimerService', 'salvar', $data) ;
		return json_encode($result);
	}
}
