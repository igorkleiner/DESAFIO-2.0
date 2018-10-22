<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function usuario()
	{	
		$nome = 'Igor';//Auth::user()->usu_nome;
		$date = date('d-m-Y',time());
		$hora = date('H:i:s:u',time());
		$usuario = json_encode( ['usu_id'=>1,'usu_nome'=>'Igor','per_id'=>4]);

		\Log::info("<< {$nome}, at: ,{$date}, {$hora} >> called LISTAR USUARIO blade" );		
		$result =$this->_callService('UsuarioService', 'listar') ;	
		debug([
			"RESULT"=>$result,
			"USUARIO"=>$usuario
		])	;
		return view('usuario.listar_usuario')->with('dados',$result)->with('usuario',$usuario);
	}

	public function salvarUsuario()
	{
		$data = Input::all();
		$result = $this->_callService('UsuarioService', 'salvar', $data);
		return json_encode($result);
	}

	public function excluirUsuario()
	{
		$data = Input::all();
		$result = $this->_callService('UsuarioService', 'excluir', $data);
		return json_encode($result);
	}
}
