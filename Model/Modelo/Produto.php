<?php

class Produto {
	
	private $id;
	private $nome;
	private $marca;
	//Codigo de barra da unidade
	private $codBarra;
	//Codigo do produto
	private $codigo;
	//valor a ser vendido
	private $valorDesconto;
	//valor que era para ser
	private $valorProduto;
	private $qtda;
	
	//Atribuir o set a todos os atributos
	public function __set($atrib, $value){
		$this->$atrib = $value;
	}
	
	//Atribuir o get a todos os atributos
	public function __get($atrib){
		return $this->$atrib;
	}
	
}

?>