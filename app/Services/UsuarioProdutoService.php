<!-- CREATE TABLE `usu_produto` (
  `usu_prodid` int(11) NOT NULL AUTO_INCREMENT,
  `usu_id` int(11) NOT NULL,
  `idproduto` int(11) NOT NULL,
  PRIMARY KEY (`usu_prodid`),
  KEY `usu_id_fk_idx` (`usu_id`),
  KEY `idproduto_fk_idx` (`idproduto`),
  CONSTRAINT `idproduto_fk` FOREIGN KEY (`idproduto`) REFERENCES `produto` (`idproduto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `usu_id_fk` FOREIGN KEY (`usu_id`) REFERENCES `usuario` (`usu_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8;
 -->
<?php
namespace App\Services;
class UsuarioProdutoService
{
	public function all()
	{
		return Usu_Produto::all();
	}

	public function salvar($data)
	{
		$data->save();
		return;
	}	

	public function excluir($data)
	{
		$data->delete();
		 return;
	}

	public function editar()
	{

	}
}	