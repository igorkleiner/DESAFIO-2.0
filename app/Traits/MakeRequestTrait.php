<?php

namespace App\Traits;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Exceptions\NegocioException;
use App\Services\LogService;
use App\Models\LogSincronizacaoWebService;
use Illuminate\Support\Facades\Auth;

trait MakeRequestTrait
{
	private $class;
	private $method;
	private $params;
	private $concat_class_name;
	private $start;
	/**
	 * this function must be called to perform a service layer consume.
	 * this context is injected on Controller and all data must pass
	 * through this mehod
	 */
	public function _callService($class, $method, array $params = [])
	{
		$params['USUARIO_LOGADO'] = (array)session()->get('user',[]);
		$this->start = microtime(true);
		$this->class = $class;
		$this->method = $method;
		$this->params = $params;
		$this->concat_class_name = "\\App\\Services\\{$class}";
		$context = null;
		try
		{
			$context = [
				 'status'   => 1
				,'response' => $this->__makeTransaction__(true/*persist log activity*/)
				,'message'  => trans("app.std.msg.pedido_exec_sucesso")
			];
		}
		catch (NegocioException $e)
		{
			$context = ['status'=>0,'response'=>null,'message'=>$e->getMessage()];
		}
		catch(Exception $e)
		{
			debug([
				'line' => $e->getLine(),
				'code' => $e->getCode(),
				'erro' => $e->getMessage(),
				'trace' => $e->getTraceAsString()
			]);
			$context = ['status'=>0,'response'=>null,'message'=>trans("app.std.msg.erro_contate_adm")];
		}
		Log::info("{$class}@{$method} time:". $this->requestTime().' ms' );
		return $context;
	}
	/**
	 * this method must be call only to execute modulationtool cronjobs
	 * all requests are made on CronjobsController and all cronjobs routes
	 * is placed in ./routes/web/cronjobsRoutes.php
	 */
	public function _cronExec($class, $method, $params = array(), $tipo = null)
	{
		set_time_limit(0);
		$this->start = microtime(true);
		$context = null;
		$log = null;
		$this->class = $class;
		$this->method = $method;
		$this->params = $params;
		$this->concat_class_name = "\\App\\Cronjobs\\{$class}";
		if (!$this->_cronIsRunning($tipo))
		{
			Log::info("==========>>> CRONJOB START <<<==========");
			$log = $this->__persistCronLog($tipo);
			try
			{
				$context = [
					'status'=>1, 
					'mensagem'=> trans("app.std.msg.cronjob_exec_sucesso"),
					'response'=> $this->__makeTransaction__()
				];
				$log->lsws_status = 1;
				$log->lsws_status_descricao = trans("app.std.msg.cronjob_exec_sucesso");
				Log::info("==========>>> CRONJOB END. TIME: ".$this->requestTime(). " ms <<<==========");
			}
			catch (Exception $e)
			{
				$log->lsws_status = 0;
				$log->lsws_status_descricao = $e->getMessage();
				$context = ['status'=>0, 'mensagem'=>trans("app.std.msg.cronjob_exec_falha"), 'Error'=>$e->getMessage()];
            Log::info(' ========= > OCORRREU UM PROBLEMA < =============');
				Log::info(' ==============> INFORMACOES <=================');
				Log::info("[Servico: {$class}@{$method}]");
				Log::info("==========>>> CRONJOB EXECUTADO COM ERRO:{$e->getMessage()}, TIME: ".$this->requestTime()." <<<==========");
				debug([
					'line' => $e->getLine(),
					'code' => $e->getCode(),
					'erro' => $e->getMessage(),
					'trace' => $e->getTraceAsString()
				]);
			}
		}
		else
		{
			Log::info("==========>>> TENTATIVA DE RODAR CRONJOB SIMULTÂNEO EVITADO TIPO:{$tipo} <<<==========");
			$context = ['status'=>0, 'mensagem'=>trans("app.std.msg.cronjob_em_execucao")];
		}
		if (!is_null($log))
		{
			$log->lsws_data_fim = date('Y-m-d H:i:s');
			$log->save();
		}
		return $context;
	}
	private function _cronIsRunning($type)
	{
		return LogSincronizacaoWebService::where('tsws_id', $type)
			->whereNull('lsws_data_fim')
			->exists();
	}
	private function __persistCronLog($type)
	{
		$log = new LogSincronizacaoWebService;
		$log->tsws_id = $type;
		$log->save();
		return $log;
	}
	private function __makeTransaction__($persisActivityLog = false)
	{
		$retult = null;
		DB::transaction(function() use (&$result,$persisActivityLog)
		{
			$result = (new $this->concat_class_name)->{$this->method}($this->params);
			if($persisActivityLog) $this->_persisActivityLog();
		});
		return $result;
	}
	private function _persisActivityLog()
	{
		// return (new LogService)->registrarAtividade([
		// 	'classe'     => $this->class,
		// 	'metodo'     => $this->method,
		// 	'parametros' => $this->params
		// ]);
	}

	private function requestTime()
	{
		$time = (microtime(true) - $this->start)*1000;
		return number_format($time,0,',','.');
	}
}