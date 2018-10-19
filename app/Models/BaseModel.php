<?php

namespace App\Models;

class BaseModel extends \Eloquent
{
	public $timestamps = false;
	protected $softDelete = false;
}