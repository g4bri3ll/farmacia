<?php

class Usuario {
	
	private $id;
	private $nome;
	private $endereco;
	private $cidade;
	private $complemento;
	private $telefone;
	private $cpf;
	private $login;
	private $senha;
	private $senhaVelha;
	private $senhaAtual;
	private $comfirmar_senha;
	private $email;
	private $nivel_log;
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