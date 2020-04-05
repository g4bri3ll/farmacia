<?php

class ValoresVendas{
	
	private $id;
	private $valor_venda;
	private $codigo_venda;
	
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