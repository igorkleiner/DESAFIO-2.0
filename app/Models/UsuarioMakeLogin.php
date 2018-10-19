<?php

namespace App\Models;

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
	
class UsuarioMakeLogin extends Eloquent implements UserInterface, RemindableInterface
{
	public $usu_id;
	
	public function getAuthIdentifier()
	{
		return $this->usu_id;
	}

	public function getAuthPassword()
	{

	}

	public function getRememberToken()
	{

	}

	public function setRememberToken($value)
	{

	}

	public function getRememberTokenName()
	{

	}

	public function getReminderEmail()
	{
		return ''; // $this->email;
	}

	public function newQuery()
	{
		return new UsuarioLogadoQuery();
	}

	public function set($data)
	{
		foreach ($data AS $key => $value)
		{
			$this->{$key} = $value;
		}
	}
}

class UsuarioLogadoQuery
{
	public function find($id)
	{
		if (Session::has("user") && Session::get("user")->usu_id == $id)
		{
			return Session::get("user");
		}
		return null;
	}
}