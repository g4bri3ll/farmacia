<?php

class SituacaoCaixa {
	
	private $id;
	private $hora;
	private $data;
	private $codigo;
	private $idCaixa;
	private $idUsuario;
	private $aberto_fechado;
	
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