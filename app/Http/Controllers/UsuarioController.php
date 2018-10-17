<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function usuario()
	{	
		$nome = Auth::user()->usu_nome;
		$date = date('d-m-Y',time());
		$hora = date('H:i:s:u',time());
		Log::info("<< {$nome}, at: ,{$date}, {$hora} >> called LISTAR USUARIO blade" );		
		$result = MakeRequest::callService('UsuarioService', 'listar') ;		
		return View::make('usuario.listar_usuario')->with('dados',$result)->with('usuario',Auth::user());	
	}

	public function salvarUsuario()
	{
		$data = Input::all();
		$result = MakeRequest::callService('UsuarioService', 'salvar', $data);
		return json_encode($result);
	}

	public function excluirUsuario()
	{
		$data = Input::all();
		$result = MakeRequest::callService('UsuarioService', 'excluir', $data);
		return json_encode($result);
	}
}
