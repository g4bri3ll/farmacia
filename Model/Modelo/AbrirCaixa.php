<?php

/*Essa classe de abrir caixa, ela cadastrar alterar, exvluir e lista todos os funcionarios
 * capacitado para abrir o caixa, os os cadastrado teram acesso a parte de abrir o caixa
 * sem isso e imposssivel abrir, sem o codigo de acesso gerado na parte de cadastrado*/
class AbrirCaixa{
	
	private $id;
	private $codigoAbrircaixa;
	private $nome;
	private $cpf;
	private $email;
	private $idUsuario;
	
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