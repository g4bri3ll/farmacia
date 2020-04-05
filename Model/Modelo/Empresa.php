<?php

class Empresa{
	
	private $id;
	private $nome;
	private $telefone;
	private $endereco;
	private $cnpj;
	private $email;
	private $cep;
	//Mensagem destina ao usuario que receberam o comprovante de venda da empresa
	private $msg;

	//Atribuir o set a todos os atributos
	public function __set($atrib, $value){
		$this->$atrib = $value;
	}
	
	//Atribuir o get a todos os atributos
	public function __get($atrib){
		return $this->$atrib;
	}
	
}