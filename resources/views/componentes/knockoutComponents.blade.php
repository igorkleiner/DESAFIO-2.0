@foreach(glob(app_path('views'.DIRECTORY_SEPARATOR.'componentes'.DIRECTORY_SEPARATOR.'container').DIRECTORY_SEPARATOR.'*.blade.php') as $f)
	<?php
		$arquivo = str_replace(DIRECTORY_SEPARATOR, '.', 
			str_replace('.blade.php', '', 
				str_replace(app_path('views'.DIRECTORY_SEPARATOR), '', $f)
			)
		);
	?>
	@include($arquivo)
@endforeach