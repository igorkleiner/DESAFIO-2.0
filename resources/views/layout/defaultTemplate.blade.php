<html>
	<head>
		<meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <title>
	    	@yield('title')
	    </title>
		@include('layout.head')
	</head>

	<style>
		.body {background-color: rgba(6, 75, 65, 0.41);}
	</style>
	    
	<body>
		<div style="padding: 5px;">		
			 @include('componentes.knockoutComponents') 
			@include('layout.menusuperior')
			@include('layout.confirmModal')								
			<div class="container">
				@yield('content')
			</div>	
		</div>		
	</body>
</html>
	<script type="text/javascript" src="{{asset('assets/bootstrap-3.3.6-dist/js/bootstrap.js')}}"></script>
	<script type="text/javascript">

		function GlobalViewModel()
		{
			var self = this;
			self.submit = function(url, dadosPost, callback)
			{
				$("#loading-modal").modal('show');
				$.post(url, dadosPost)
					.done(function(o_que_voltou_de_return_do_controller){
						callback(JSON.parse(o_que_voltou_de_return_do_controller));
					})
					.fail(function(error){

						$("#alert-modal #alert-msg").html(error.statusText);
						$("#alert-modal").modal('show');
					})
					.always(function(done){
						$("#loading-modal").modal('hide');
					});
			}
		}
		var globalViewModel = new GlobalViewModel();
	</script>