<?php

class Vendas {
	
	private $id;
	private $nome;
	private $nomeComprador;
	//para validar se a vendas esta em aberto ou fechado
	private $aberto_fechado;
	private $marca;
	private $codBarra;
	private $valorDesconto;
	private $valorProduto;
	//qtda de vendas feitas
	private $qtda;
	private $idProduto;
	private $idUsuario;
	private $data;
	//receber o codigo da venda
	private $codigoVenda;
	
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