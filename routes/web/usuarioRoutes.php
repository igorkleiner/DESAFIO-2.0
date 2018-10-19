<?php

Route::name('usuario.')->prefix('usuario')->group(function()
{
	Route::any('/usuario', 'UsuarioController@usuario')->name('usuario');
	//{{Route('usuario.usuario')}}
	Route::post('/salvar', 'UsuarioController@salvarProduto')->name('salvar');
	//{{Route('salvar.salvar')}}
	Route::post('/excluir', 'UsuarioController@excluirProduto')->name('excluir');
	//{{Route('excluir.excluir')}}
	Route::post('/salvacadastro', 'UsuarioController@salvarUsuario')->name('salvacadastro');
	//{{Route('salvacadastro.salvacadastro')}}
	Route::post('/excluicadastro', 'UsuarioController@excluirUsuario')->name('excluicadastro');
	//{{Route('salvacadastro.salvacadastro')}}
	Route::post('/getusuario', 'UsuarioController@getUsuario')->name('getusuario');
	//{{Route(getusuario.getusuario) }}
	Route::post('/salvausuario', 'UsuarioController@salvaUsuario')->name('salvausuario');
	//{{Route(salvausuario.salvausuario) }}
});