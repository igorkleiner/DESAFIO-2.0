<?php

namespace App\Traits;

use Validator;
use App\Mail\StandardMailBuilder;
use Illuminate\Support\Facades\Mail;
use App\Exceptions\NegocioException;
use Illuminate\Support\Facades\App;

trait HelperTrait
{
	/**
	 * default sistem validator for throlling erros (use only in service context)
	 * @param @data array with response data
	 * @param @rules array of validation rules mandatory
	 * @param @names array of bind :attibute param on string message nom mandatory
	 * @param @messages array of custom messages for overrides default behaivoring
	 * @throws NegocioException a default sistem error throller
	 */
	public function _validate(array $data, array $rules, array $names = array(), array $messages = array())
	{
		$validator = Validator::make($data, $rules, $messages, $names);
		if ($validator->fails())
		{
			$erros = $validator->errors();
			foreach($erros->all() as $message)
			{
				throw new NegocioException($message);
			}
		}
	}

	/**
	 * default sistem mail sender to easely send messages
	 * @param $to string e-mail address to 
	 * @param $view string name to view mail
	 * @param $data array payload data to set variables in view (optional)
	 * @param $withbcc array to include hidden recipier
	 * @return $this context
	 */
	public function _sendEmail($subject, $to, $view, array $data = [], $withbcc = [])
	{
		$mail = Mail::to($to);

		if($withbcc) $mail->bcc($withbcc);

		$mail->send(new StandardMailBuilder($subject, $view, $data));

		return $this;
	}

	/**
	 * if folder does not exists, make it happen!.. have fun ;)
	 * @param $path string path to desired folder
	 * @return void 
	 */
	public function _checkIfFolderExists($path)
	{
		if(!is_dir($path)) mkdir($path,751);
	}
	/**
	 * make unique string token
	 * @return string token
	 */
	public function _hash()
	{
		$a = microtime(true);
		$b = date("Y-m-d H:i:s");
		$c = rand(000, 999);
		$d = rand(000, 999);
		return hash('sha256', (sha1($a) . md5($b) . sha1($c) . md5($d)));
	}
	/**
	 * make a array data become a object
	 * @param $data array
	 * @return object stdClass array converted
	 */
	public function _toObject($data)
	{
		return json_decode(json_encode($data));
	}
	/**
	 * make a BLR number formated like 1.000,00
	 * @param $valor the value to be formated
	 * @param $precisao the amount of decimals
	 * @param $separador_decimal the string decimal separator
	 * @param $separador_milhar the string separator of thousands
	 * @return number_format
	 */
	public function _formatNumber($valor = 0 ,$precisao = 2)
	{
		$numeros = [
			'pt' => (object)['dec'=>',','mil'=>'.'],
			'fr' => (object)['dec'=>',','mil'=>'.'],		
			'es' => (object)['dec'=>',','mil'=>'.'],
			'de' => (object)['dec'=>',','mil'=>'.'],
			'en' => (object)['dec'=>'.','mil'=>','],
			'zh' => (object)['dec'=>'.','mil'=>','],
		];
		$locale = App::getLocale();
		$_number = array_key_exists($locale,$numeros)
			? $numeros[$locale]
			: (object)['dec'=>',','mil'=>'.']
		;
		return number_format($valor??0,$precisao,$_number->dec,$_number->mil);
	}
	/**
	 * default date formater using language parameters
	 * @param $stringDate in format Y-m-d or Y-m-d H:i:s
	 * @return string formated date
	 */
	public function _dateFormat($stringDate,$withHours = '')
	{
		$datas = config('mofab.formatos.datas');
		$locale = App::getLocale();
		$_date = array_key_exists($locale, $datas)
			? $datas[$locale]
			: 'd/m/Y'
		;
		return date(($_date.$withHours),strtotime($stringDate));
	}
	/**
	 * convert a formated string numvber like 1.000,00 to 1000.00
	 * @param $valor the value
	 * @return number
	 */
	public function _stringToNumber($valor)
	{
		return $valor
			? preg_replace('/(\,)/','.',preg_replace('/(\.)/','',$valor))
			: null
		;
	}

	public function _convertObject($data)
	{
		return json_decode(json_encode($data));
	}
}