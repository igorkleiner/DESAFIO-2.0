<?php
namespace App\Services;
class ProdutoService
{
	public function listar()
	{
		return Produto::all();
	}

	public function salvar($data)
	{
		$produto = !empty($data['prod_id']) ? Produto::find($data['prod_id']) : new Produto;
		$produto->prod_nome = $data['prod_nome'];
		$produto->prod_preco = $data['prod_preco'];
		$produto->prod_qtd = $data['prod_qtd'];		
		$produto->save();
		return $produto;
	}	

	public function excluir($data)
	{
		$produto = Produto::find($data['prod_id']);
		$produto->delete();
	}

}	