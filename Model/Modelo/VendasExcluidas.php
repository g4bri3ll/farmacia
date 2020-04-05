<?php

class VendasExcluidas{
	
	private $id;
	private $idCompra;
	Private $idUsuario;
	//Pegar o valor da compra do produto, o unico produto vendido
	private $valorProdDesconto;
	private $data;
	private $marca;
	//Receber o nome do produto que esta sendo cancelado pelo usuario
	private $nomeproduto;
	
	//Atribuir o set a todos os atributos
	public function __set($atrib, $value){
		$this->$atrib = $value;
	}
	
	//Atribuir o get a todos os atributos
	public function __get($atrib){
		return $this->$atrib;
	}
	
}