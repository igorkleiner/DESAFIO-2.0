<?php 

namespace App\Models;

class Timer extends BaseModel
{
	/*recebe espelho da base de dados da tabela timer*/
	protected $table = "timer";
	protected $primaryKey = "timer_id";	
}