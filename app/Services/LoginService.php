<?php
namespace App\Services;
class LoginService
{
	/**
	* FUNCTION DESCRIPCTIONS
	* @param array ['usuario', 'senha'];
	* @return string "sucesso"
	**/
	function validarLogin($data)
	{
		if(empty($data['usuario']) || empty($data['senha']))
		{
			throw new Exception("Dados inválidos para login");
		}
		
		$usuario = Usuario::where(function($q) use ($data)
			{
				$q->where('usu_login',$data['usuario'])
				  ->where('usu_password', $data['senha']);
			})
			->first();		
		if(!$usuario)
		{
			throw new Exception("Login ou senha incorretos.");
		}
		$t = new UsuarioMakeLogin;
		$t->usu_id = $usuario->usu_id;
		$t->usu_nome = $usuario->usu_nome;
		$t->per_id = $usuario->per_id;
		$t->usu_login = $usuario->usu_login;
		$t->usu_password = $usuario->usu_password;		
		Auth::login($t);
		Session::set('user',$t);				
		if(Auth::user())
		{
			Log::debug("<<< Login efetuado com sucesso. >>>");
			Log::debug(Auth::user()->usu_nome);
			return;
		}
		else
		{
			Log::debug("<<< Login NAO efetuado... TENTE NOVAMENTE >>>");
			Log::debug(Auth::user()->usu_nome);
			return;
		}		
	}	

	function logout()
	{
		Session::flush();
		Log::debug("<<< Logout efetuado >>>");		
		return ;
	}	
}