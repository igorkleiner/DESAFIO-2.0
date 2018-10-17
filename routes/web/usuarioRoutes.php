<?php

Route::group(array('before' => 'auth','prefix' => ''),function(){
    //{{Route('produto.produto')}}
	Route::any('/usuario',         array('as'=> 'usuario.usuario',               'uses' => 'HomeController@usuario'));
	//{{Route('usuario.usuario')}}
	Route::post('/salvar',         array('as'=> 'salvar.salvar',                 'uses' => 'HomeController@salvarProduto'));
	//{{Route('salvar.salvar')}}
	Route::post('/excluir',        array('as'=> 'excluir.excluir',               'uses' => 'HomeController@excluirProduto'));
	//{{Route('excluir.excluir')}}
	Route::post('/salvacadastro',  array('as'=> 'salvacadastro.salvacadastro',   'uses' => 'HomeController@salvarUsuario'));
	//{{Route('salvacadastro.salvacadastro')}}
	Route::post('/excluicadastro', array('as'=> 'excluicadastro.excluicadastro', 'uses' => 'HomeController@excluirUsuario'));
	//{{Route('salvacadastro.salvacadastro')}}
	Route::post('/getusuario'  ,   array('as'=>'igor.getusuario'  ,              'uses'=>'HomeController@getUsuario'));
	//{{Route(getusuario.getusuario) }}
	Route::post('/salvausuario',   array('as'=>'igor.salvausuario',              'uses'=>'HomeController@salvaUsuario'));
	//{{Route(salvausuario.salvausuario) }}
});