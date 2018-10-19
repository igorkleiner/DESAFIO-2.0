<?php

namespace App\Services;

use App\Models\Perfil;

class PerfilService
{
	public function listar()
	{
		return Perfil::all();
	}

	public function salvar($data)
	{
		$data->save();
		return;
	}	

	public function excluir($data)
	{
		$data->delete();
		 return;
	}

	public function editar()
	{

	}
}	