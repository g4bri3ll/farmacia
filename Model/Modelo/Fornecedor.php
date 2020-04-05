<?php

class Fornecedor {
	
	private $id;
	private $nome;
	private $endereco;
	private $cidade;
	private $telefone;
	private $cnpj;
	private $email;
	private $sexo;
	private $cep;
	
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