@extends('layout.defaulttemplate')
@section('title','GRAFICO')
@section('content')

	<script type="text/javascript">
		// INSTANCIA DAS VARIAVEIS DA PAGINA
		var viewModel, diaSemana,data,hora,usuario,time, mask, placeholder;
		diaSemana = "{{date('D',time())}}";
		data = "{{date('Y-m-d',time())}}";    
		hora = "{{date('H:i:s:u',time())}}";          
		usuario = {{json_encode($usuario)}};   
		usuario['usu_id'] = {{$usuario->usu_id}};    
		grafico = {{json_encode($grafico)}};
		mask = '99:99:99';	
	</script>

	<div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12 warning master borda1 " id='divTimer'  style="height: fit-content;">
		<div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12 borda2 fundo-claro" style="border-radius: 30px" > 
			<div class=" col-lg-2 col-md-2 col-sm-2 col-xs-2 ">
				<strong>
					<span data-bind=' relogio:agora, text:agora.data '></span>
					<span data-bind=' text:agora.hora'></span>
				</strong>			
			</div>
			<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 text-center" >
				{{-- <button class="btn-lg btn-success" style="margin-top: 6px; height: 43px;" data-bind='click:total'>Total do dia</button> --}}
				{{-- <button class="btn-lg btn-success" style="margin-top: 6px; height: 43px;" data-bind='click:consolidado'>Consolidado dia</button> --}}
			</div>
			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
					<div style="width: 50px; margin-top: 15px;">
						<span>Olá </span> 
						<span data-bind='text:usuario'></span>
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
					<div class="borda-redonda" style="margin-right: -10px">
						<img class="borda-redonda"  src="{{asset('assets/images/Capturar.png')}}" >
					</div>
				</div>
			</div>
		</div>
		<div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12 borda2 fundo-claro" style="border-radius: 30px; margin-top: 15px; vertical-align: middle;padding: 20px;" > 
			<center>
				<div id="chartContainer"   class="borda" style="height: 250px; width: 100%; margin: 0px auto;border-radius: 10px"></div>
				<div id="chartContainerr"  class="borda" style="height: 250px; width: 100%; margin: 0px auto;border-radius: 10px"></div>
			</center>
		</div>		
	</div>
	<link rel="stylesheet" type="text/css" href="{{asset('assets/CSS/timer.css')}}">
	<script type="text/javascript" src="{{asset('assets/moment-js/moments.js')}}"></script>
	<script type="text/javascript">
	//-----------Tempo-----------------------------------------------------------------------------------------------
		function Tempo(usuario,data,entrada_1,entrada_2,entrada_3,entrada_4,entrada_5,saida_1,saida_2,saida_3,saida_4,saida_5)
		{
			var self = this;
			self.data = data;
			self.entradaPeriodo1 = ko.observable(entrada_1);
			self.entradaPeriodo2 = ko.observable(entrada_2);
			self.entradaPeriodo3 = ko.observable(entrada_3);
			self.entradaPeriodo4 = ko.observable(entrada_4);
			self.entradaPeriodo5 = ko.observable(entrada_5);
			//
			self.saidaPeriodo1   = ko.observable(saida_1);
			self.saidaPeriodo2   = ko.observable(saida_2);
			self.saidaPeriodo3   = ko.observable(saida_3);
			self.saidaPeriodo4   = ko.observable(saida_4);
			self.saidaPeriodo5   = ko.observable(saida_5);
			//
			self.agora = new Relogio();
			self.dateDiff = function (date1, date2)
			{
				tempoEntrada = date1.split(':');                                
				var entrada = new Date();
				entrada.setHours(tempoEntrada[0]);
				entrada.setMinutes(tempoEntrada[1]);
				entrada.setSeconds(tempoEntrada[2]); 
				  
				tempoSaida = date2.split(':');                
				var saida = new Date();
				saida.setHours(tempoSaida[0]);
				saida.setMinutes(tempoSaida[1]);
				saida.setSeconds(tempoSaida[2]);  

				var compara = new Date();
				
				if(saida.getTime() <= entrada.getTime()) //|| entrada.getTime() > compara.getTime() )
				{                
					return '00:00:00';
				}
				
				var diff = saida - entrada, sign = diff < 0 ? -1 : 1, milliseconds, seconds, minutes, hours, days;

				if (isNaN(diff))
				{ 
					return '00:00:00';
				}
				
				try
				{                
					diff /= sign; 
					diff = ( diff - ( milliseconds = diff % 1000 )) / 1000;
					diff = ( diff - ( seconds      = diff % 60   )) / 60;
					diff = ( diff - ( minutes      = diff % 60   )) / 60;
					days = ( diff - ( hours        = diff % 24   )) / 24;
					daysInHours = ( diff - ( hours = diff % 24   ));

					hours += daysInHours;
					hours   = hours.toString().length   == 1 ? '0'+hours   : hours;
					minutes = minutes.toString().length == 1 ? '0'+minutes : minutes;
					seconds = seconds.toString().length == 1 ? '0'+seconds : seconds;
					
					return hours+':'+minutes+':'+seconds;
				}
				catch(ex)
				{
					return '00:00:00';
				}
			};
			//
			self.timeAdd = function (time1, time2, time3, time4, time5)
			{
				time1 = time1.split(':');              
				time2 = time2.split(':');
				time3 = time3.split(':');            
				time4 = time4.split(':');            
				time5 = time5.split(':');  

				var horas    = parseFloat(time1[0]) + parseFloat(time2[0]) + parseFloat(time3[0]) + parseFloat(time4[0]) + parseFloat(time5[0]);            
				var minutos  = parseFloat(time1[1]) + parseFloat(time2[1]) + parseFloat(time3[1]) + parseFloat(time4[1]) + parseFloat(time5[1]);              
				var segundos = parseFloat(time1[2]) + parseFloat(time2[2]) + parseFloat(time3[2]) + parseFloat(time4[2]) + parseFloat(time5[2]);

				try
				{
					while (segundos > 59) {segundos = segundos - 60; minutos = minutos + 1;}
					while (minutos > 59)  {minutos  = minutos  - 60; horas   = horas   + 1;}          
					if (horas    < 10) horas    = "0"+ horas.toString();
					if (minutos  < 10) minutos  = "0"+ minutos.toString();
					if (segundos < 10) segundos = "0"+ segundos.toString(); 
					return horas+':'+minutos+':'+segundos;
				}
				catch(ex)
				{
					return '00:00:00';
				}
			};
			//
			self.totalHorasPeriodo1 = ko.pureComputed(function()
			{
				var tempoEntrada = self.entradaPeriodo1()||"00:00:00";            
				var tempoSaida = self.saidaPeriodo1()||"00:00:00";            
				
				if (tempoEntrada == "") tempoEntrada = "00:00:00"
				if (tempoSaida == "") tempoSaida = "00:00:00"
				if (tempoEntrada != "00:00:00"  && tempoSaida == "00:00:00" ) return "00:00:00";
				var totalHorasPeriodo1 =  self.dateDiff(tempoEntrada, tempoSaida);
				return totalHorasPeriodo1;
			},this);
			//
			self.totalHorasPeriodo2 = ko.pureComputed(function()
			{
				var tempoEntrada = self.entradaPeriodo2()||"00:00:00";
				var tempoSaida = self.saidaPeriodo2()||"00:00:00";

				if (tempoEntrada == "") tempoEntrada = "00:00:00"
				if (tempoSaida == "") tempoSaida = "00:00:00"
				if (tempoEntrada != "00:00:00"  && tempoSaida == "00:00:00" ) return "00:00:00";
				var totalHorasPeriodo2 =  self.dateDiff(tempoEntrada, tempoSaida);
				return totalHorasPeriodo2; 
			},this);
			//
			self.totalHorasPeriodo3 = ko.pureComputed(function()
			{
				var tempoEntrada = self.entradaPeriodo3()||"00:00:00";
				var tempoSaida = self.saidaPeriodo3()||"00:00:00";

				if (tempoEntrada == "") tempoEntrada = "00:00:00"
				if (tempoSaida == "") tempoSaida = "00:00:00"
				if (tempoEntrada != "00:00:00"  && tempoSaida == "00:00:00" )  return "00:00:00";
				var totalHorasPeriodo3 =  self.dateDiff(tempoEntrada, tempoSaida);
				return totalHorasPeriodo3; 
			},this);
			//
			self.totalHorasPeriodo4 = ko.pureComputed(function()
			{
				var tempoEntrada = self.entradaPeriodo4()||"00:00:00";
				var tempoSaida = self.saidaPeriodo4()||"00:00:00";

				if (tempoEntrada == "") tempoEntrada = "00:00:00"
				if (tempoSaida == "") tempoSaida = "00:00:00"
				if (tempoEntrada != "00:00:00"  && tempoSaida == "00:00:00" )  return "00:00:00";
				var totalHorasPeriodo4 =  self.dateDiff(tempoEntrada, tempoSaida);
				return totalHorasPeriodo4; 
			},this);
			//
			self.totalHorasPeriodo5 = ko.pureComputed(function()
			{
				var tempoEntrada = self.entradaPeriodo5()||"00:00:00";
				var tempoSaida = self.saidaPeriodo5()||"00:00:00";

				if (tempoEntrada == "") tempoEntrada = "00:00:00"
				if (tempoSaida == "") tempoSaida = "00:00:00"
				if (tempoEntrada != "00:00:00"  && tempoSaida == "00:00:00" )  return "00:00:00";
				var totalHorasPeriodo5 =  self.dateDiff(tempoEntrada, tempoSaida);
				return totalHorasPeriodo5; 
			},this);
			//
			self.horasTotais = ko.pureComputed(function()
			{
				return self.timeAdd(  self.totalHorasPeriodo1()
									, self.totalHorasPeriodo2()
									, self.totalHorasPeriodo3()
									, self.totalHorasPeriodo4()
									, self.totalHorasPeriodo5()
				);
			},this);
		}				
	//-----------ViewModel-------------------------------------------------------------------------------------------
		function ViewModel()
		{
			var self = this;
			self.agora                = new Relogio();
			self.usuario              = ko.observable(usuario.usu_nome);
			self.tempos               = [];	
			self.dadosGrafico         = [];
			self.dadosGrafico2        = [];
			self.dadosGrafico2["Tp1"] = [];
			self.dadosGrafico2["Tp2"] = [];
			self.dadosGrafico2["Tp3"] = [];
			self.dadosGrafico2["Tp4"] = [];
			self.dadosGrafico2["Tp5"] = [];
				
			if (grafico.status != 0 && grafico.response != null) 
			{
				ko.utils.arrayForEach(grafico.response,function(tempo)
                {
                	//debugger;
                    self.tempos.push(
						new Tempo(
							tempo.usu_id,
							tempo.data,
							tempo.entrada_1,
							tempo.entrada_2,
							tempo.entrada_3,
							tempo.entrada_4,
							tempo.entrada_5,
							tempo.saida_1,
							tempo.saida_2,
							tempo.saida_3,
							tempo.saida_4,
							tempo.saida_5
						)
                    );
                });
                //
                ko.utils.arrayForEach(self.tempos,function(dia)
                {
					tempoEntrada = dia.horasTotais().split(':'); 
					var horas = new Date(dia.data);
					horas.setHours(tempoEntrada[0]);
					// console.log(horas.getHours());
					horas.setMinutes(tempoEntrada[1]);
					// console.log(horas.getMinutes());
					horas.setSeconds(tempoEntrada[2]); 
					var a = parseInt(horas.getHours()  <10 ? '0'+horas.getHours() : horas.getHours());
					// console.log(a);
					// var b = parseInt((parseInt(horas.getMinutes()<10 ? '0'+horas.getMinutes() : horas.getMinutes())/60)*100);
					var b = parseInt((parseInt(horas.getMinutes())/60)*100);
					console.log(dia);
					console.log(b);
					
					self.dadosGrafico.push(
						{label:dia.data.toString(), y: parseFloat(a+'.'+ ( b<10? '0'+b :b)) }
     				)
				//===================================
                    Tp1 = dia.totalHorasPeriodo1().split(':');
                    var horas = new Date(dia.data);
					horas.setHours(Tp1[0]);
					horas.setMinutes(Tp1[1]);
					horas.setSeconds(Tp1[2]);
					var a = horas.getHours()  <10 ? '0'+horas.getHours() : horas.getHours();
					var b = parseInt((parseInt(horas.getMinutes())/60)*100);
					self.dadosGrafico2["Tp1"].push(
						{ y: parseFloat(a+'.'+ ( b<10? '0'+b :b)) , label: dia.data.toString() },
                    )
                    Tp2 = dia.totalHorasPeriodo2().split(':');
                    var horas = new Date(dia.data);
					horas.setHours(Tp2[0]);
					horas.setMinutes(Tp2[1]);
					horas.setSeconds(Tp2[2]);
					var a = horas.getHours()  <10 ? '0'+horas.getHours() : horas.getHours();
					var b = parseInt((parseInt(horas.getMinutes())/60)*100);
					self.dadosGrafico2["Tp2"].push(
						{ y: parseFloat(a+'.'+ ( b<10? '0'+b :b)) , label: dia.data.toString() },
                    )
                    Tp3 = dia.totalHorasPeriodo3().split(':');
                    var horas = new Date(dia.data);
					horas.setHours(Tp3[0]);
					horas.setMinutes(Tp3[1]);
					horas.setSeconds(Tp3[2]);
					var a = horas.getHours()  <10 ? '0'+horas.getHours() : horas.getHours();
					var b = parseInt((parseInt(horas.getMinutes())/60)*100);
					self.dadosGrafico2["Tp3"].push(
						{ y: parseFloat(a+'.'+ ( b<10? '0'+b :b)) , label: dia.data.toString() },
                    )
                    Tp4 = dia.totalHorasPeriodo4().split(':');
                    var horas = new Date(dia.data);
					horas.setHours(Tp4[0]);
					horas.setMinutes(Tp4[1]);
					horas.setSeconds(Tp4[2]);
					var a = horas.getHours()  <10 ? '0'+horas.getHours() : horas.getHours();
					var b = parseInt((parseInt(horas.getMinutes())/60)*100);
					self.dadosGrafico2["Tp4"].push(
						{ y: parseFloat(a+'.'+ ( b<10? '0'+b :b)) , label: dia.data.toString() },
                    )
                    Tp5 = dia.totalHorasPeriodo5().split(':');
                    var horas = new Date(dia.data);
					horas.setHours(Tp5[0]);
					horas.setMinutes(Tp5[1]);
					horas.setSeconds(Tp5[2]);
					var a = horas.getHours()  <10 ? '0'+horas.getHours() : horas.getHours();
					var b = parseInt((parseInt(horas.getMinutes())/60)*100);
					self.dadosGrafico2["Tp5"].push(
						{ y: parseFloat(a+'.'+ ( b<10? '0'+b :b)) , label: dia.data.toString() },
                    )
				//===================================
                });
                //
				//======= grafico 1 =========================================================================================
					var chart = new CanvasJS.Chart("chartContainer", 
					{
						theme: "light2", 
						animationEnabled: true,
						title:{
							text: "Gráfico de Horas/Dia"
						},						
						axisX:{
							interval: 1
						},
						axisY:{
							title: "Horas",
							interval: 1,
						},

						data:[{
							type: "column",
							dataPoints:self.dadosGrafico 
						}]
					});	  
					chart.render();  						
				//======= grafico 2 ===========================================================================================
					var chart1 = new CanvasJS.Chart("chartContainerr", 
					{
						zoomEnabled: true,
      					panEnabled: true,
						animationEnabled: true,
						title:{
							text: "Horas - Consolidadas por Periodo",
							fontFamily: "arial black",
							fontColor: "#3a3a3a"
						},
						axisX: {
							interval: 1,
							intervalType: "day"
						},
						axisY:{
							title: "Horas",
							interval: 1,
						},
						// toolTip: {
						// 	shared: true,
						// 	content: toolTipContent
						// },
						data: 
						[
							{
								type: "stackedColumn",
								showInLegend: true,
								color: "#8e7aa3",
								name: "Periodo_1",
								// indexLabel: "#total h",
								dataPoints: self.dadosGrafico2.Tp1
							},
							{        
								type: "stackedColumn",
								showInLegend: true,
								name: "Periodo_2",
								color: "#51cda0",
								dataPoints: self.dadosGrafico2.Tp2							
							},
							{        
								type: "stackedColumn",
								showInLegend: true,
								name: "Periodo_3",
								color: "#5592ad",
								dataPoints: self.dadosGrafico2.Tp3
							},
							{        
								type: "stackedColumn",
								showInLegend: true,
								name: "Periodo_4",
								color: "#c9d45c",
								dataPoints: self.dadosGrafico2.Tp4
							},
							{        
								type: "stackedColumn",
								showInLegend: true,
								name: "Periodo_5",
								color: "#ae7d99",
								dataPoints: self.dadosGrafico2.Tp5
							}
						]
					});
					chart1.render();
				//=============================================================================================================

				// function toolTipContent(e) 
				// {
				// 	var str = "";
				// 	var total = 0;
				// 	var str2, str3;
				// 	for (var i = 0; i < e.entries.length; i++)
				// 	{
				// 		var  str1 = "<span style= \"color:"+e.entries[i].dataSeries.color + 
				// 					"\"> "+e.entries[i].dataSeries.name+"</span>: $<strong>"+
				// 					e.entries[i].dataPoint.y+"</strong>bn<br/>";

				// 		total = e.entries[i].dataPoint.y + total;
				// 		str = str.concat(str1);
				// 	}
				// 	str2 = "<span style = \"color:DodgerBlue;\"><strong>"+(e.entries[0].dataPoint.x).getFullYear()+"</strong></span><br/>";
				// 	total = Math.round(total * 100) / 100;
				// 	str3 = "<span style = \"color:Tomato\">Total:</span><strong>"+total+"</strong>h<br/>";
				// 	return (str2.concat(str)).concat(str3);
				// }
			}					
		}
	//---------------------------------------------------------------------------------------------------------------
		viewModel = new ViewModel;

		$(function(){
			ko.applyBindings(viewModel, document.getElementById('divTimer'));
		});
	//---------------------------------------------------------------------------------------------------------------

	</script>
@stop