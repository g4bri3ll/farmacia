<?php

include_once 'Conexao/Conexao.php';

class SituacaoCaixaDAO {

	private $conn = null;

	//Cadastrar o funcionario no caixa para abrir o caixa
	public function cadastrarParaAbrir(SituacaoCaixa $situacaoCaixa) {
		
		try {
			
			$sql = "INSERT INTO situacao_caixa (hora, data, codigo, idCaixa, aberto_fechado, id_usuario) 
					VALUES ('".$situacaoCaixa->hora."',	'".$situacaoCaixa->data."', '".$situacaoCaixa->codigo."', 
					'".$situacaoCaixa->idCaixa."', '".$situacaoCaixa->aberto_fechado."', '".$situacaoCaixa->idUsuario."')";
				
			$conn = new Conexao ();
			$conn->openConnect ();
				
			$mydb = mysqli_select_db ( $conn->getCon (), $conn->getBD());
			$resultado = mysqli_query ( $conn->getCon (), $sql );
			
			$conn->closeConnect ();
				
			header ( "Location: ../PaginaInicial.php" );
			
		} catch ( PDOException $e ) {
				
			return $e->getMessage ();
			header ( "Location: ../PaginaInicial.php" );
			
		}
		
	}
	
	//Cadastrar o funcionario no caixa para fechar o caixa
	public function cadastrarParaFechar(SituacaoCaixa $situacaoCaixa) {

		try {
			
			$sql = "INSERT INTO situacao_caixa (hora, data, codigo, idCaixa, aberto_fechado, id_usuario)
					VALUES ('".$situacaoCaixa->hora."',	'".$situacaoCaixa->data."', '".$situacaoCaixa->codigo."', 
					'".$situacaoCaixa->idCaixa."', '".$situacaoCaixa->aberto_fechado."', '".$situacaoCaixa->idUsuario."')";
				
			$conn = new Conexao ();
			$conn->openConnect ();
				
			$mydb = mysqli_select_db ( $conn->getCon (), $conn->getBD());
			$resultado = mysqli_query ( $conn->getCon (), $sql );
			
			$conn->closeConnect ();
				
			header ( "Location: ../PaginaInicial.php" );
			
		} catch ( PDOException $e ) {
				
			return $e->getMessage ();
			header ( "Location: ../PaginaInicial.php" );
			
		}

	}
	
	//altera o caixa se ele estiver aberto para fechado
	public function AlteraCaixaAberto($situacaoCaixa) {

		try {

			$sql = "UPDATE situacao_caixa SET aberto_fechado='".$situacaoCaixa."'";
			
			$conn = new Conexao ();
			$conn->openConnect ();
				
			$mydb = mysqli_select_db ( $conn->getCon (), $conn->getBD());
			$resultado = mysqli_query ( $conn->getCon (), $sql );
			
			$conn->closeConnect ();
				
		} catch ( PDOException $e ) {
			return $e->getMessage ();
		}

	}
	
	// Retorna a lista com a situaчуo do caixa
	public function listaSituacaoCaixa() {
	
		$sql = sprintf ( "SELECT * FROM situacao_caixa" );
	
		$conn = new Conexao ();
		$conn->openConnect ();
	
		$mydb = mysqli_select_db ( $conn->getCon (), $conn->getBD());
		$resultado = mysqli_query ( $conn->getCon (), $sql );
	
		$array = array ();
	
		while ( $row = mysqli_fetch_assoc ( $resultado ) ) {
			$array [] = $row;
		}
	
		$conn->closeConnect ();
		return $array;
	}

	// Pegar o id que esta na sessao e retorna o resultado
	public function listaUsuarioPeloId($id) {
	
		try {
		
		$sql = "SELECT * FROM situacao_caixa WHERE id_usuario = '" . $id . "'";
		
		$conn = new Conexao ();
		$conn->openConnect ();
	
		$mydb = mysqli_select_db ( $conn->getCon (), $conn->getBD());
		$resultado = mysqli_query ( $conn->getCon (), $sql);
	
		$array = array ();
	
		while ( $row = mysqli_fetch_assoc( $resultado ) ) {
			$array [] = $row;
		}
	
		$conn->closeConnect ();
		
		} catch (PDOException $e){
			
			$e->getMessage();
			
		}
		
		return $array;
		
	}
	
	// Retorna o ultimo id do funcionario com o caixa aberto
	public function RetornaUltimoId() {
	
		$conn = new Conexao ();
		$conn->openConnect ();
	
		$mydb = mysqli_select_db ( $conn->getCon (), $conn->getBD());
		$resultado = mysqli_query ( $conn->getCon (), 
		"SELECT id_usuario, idCaixa, aberto_fechado FROM situacao_caixa ORDER BY id DESC LIMIT 1");
	
		$array = array ();
	
		while ( $row = mysqli_fetch_assoc ( $resultado ) ) {
			$array [] = $row;
		}
	
		$conn->closeConnect ();
		return $array;
	}

	// Pegar o id do usuario que fez a abertura do caixa
	public function PegarIdParaFecharCaixa() {
	
		$conn = new Conexao ();
		$conn->openConnect ();
	
		$mydb = mysqli_select_db ( $conn->getCon (), $conn->getBD());
		$resultado = mysqli_query ( $conn->getCon (), 
		"SELECT id_usuario, aberto_fechado FROM situacao_caixa ORDER BY id DESC LIMIT 1");
	
		$array = array ();
	
		while ( $row = mysqli_fetch_assoc ( $resultado ) ) {
			$array [] = $row;
		}
	
		$conn->closeConnect ();
		return $array;
	}
	
	// Retorna o valor se esta aberto ou fechado e se estiver aberto retorna tambem o id do usuario que abriu o caixa
	public function AbertoFechado() {
	
		$conn = new Conexao ();
		$conn->openConnect ();
	
		$mydb = mysqli_select_db ( $conn->getCon (), $conn->getBD());
		$resultado = mysqli_query ( $conn->getCon (), "SELECT * FROM situacao_caixa ORDER BY id DESC LIMIT 1");
	
		$array = array ();
	
		while ( $row = mysqli_fetch_assoc ( $resultado ) ) {
			$array [] = $row;
		}
	
		$conn->closeConnect ();
		return $array;
	}
	
}

?>