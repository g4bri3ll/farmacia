<?php

/*Essa classe de abrir caixa, ela cadastrar alterar, exvluir e lista todos os funcionarios
 * capacitado para abrir o caixa, os os cadastrado teram acesso a parte de abrir o caixa
 * sem isso e imposssivel abrir, sem o codigo de acesso gerado na parte de cadastrado*/
include_once 'Conexao/Conexao.php';

class AbrirCaixaDAO {
	
	private $conn = null;
	
	public function cadastrar(AbrirCaixa $abrirCaixa) {
		
		try {
			
			$sql = "INSERT INTO abrir_caixa (codigoAbrircaixa, nome, cpf, email, id_usuario) VALUES ('" . $abrirCaixa->codigoAbrircaixa . "', 
					'" . $abrirCaixa->nome . "', '" . $abrirCaixa->cpf . "', '" . $abrirCaixa->email . "', '" . $abrirCaixa->idUsuario . "')";
			
			$conn = new Conexao ();
			$conn->openConnect ();
			
			$mydb = mysqli_select_db ( $conn->getCon (), $conn->getBD() );
			$resultado = mysqli_query ( $conn->getCon (), $sql );
			
			$conn->closeConnect ();
			
			return true;
			
		} catch ( PDOException $e ) {
			return $e->getMessage ();
		}
		
	}
	
	// alterar os dados do usuario do caixa
	public function alterar(AbrirCaixa $abrirCaixa) {
		
		$sql = "UPDATE abrir_caixa SET nome='" . $abrirCaixa->nome . "', cpf='" . $abrirCaixa->cpf . "',
				email='" . $abrirCaixa->email . "', id_usuario='" . $abrirCaixa->idUsuario . "' WHERE id = '" . $abrirCaixa->id . "'";
		
		$conn = new Conexao ();
		$conn->openConnect ();
		
		mysqli_select_db ( $conn->getCon (), $conn->getBD() );
		$resultado = mysqli_query ( $conn->getCon (), $sql );
		
		$conn->closeConnect ();
		
		return true;
		
	}
	
	// deleta pelo id selecionado
	public function deleteId($id) {
		
		$sql = "DELETE FROM abrir_caixa WHERE id = '" . $id . "'";
		
		$conn = new Conexao ();
		$conn->openConnect ();
		
		mysqli_select_db ( $conn->getCon (), $conn->getBD());
		$resultado = mysqli_query ( $conn->getCon (), $sql );
		
		$conn->closeConnect ();
		
		return true;
		
	}
	
	// Retorna a lista como todos os caixa
	public function listaCaixa() {
		
		$sql = sprintf ( "SELECT * FROM abrir_caixa" );
		
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
	
	// Retorna o codigo de acesso para abrir o caixa
	public function listaParaAbrirCaixa($codigoAcesso) {
		
		$conn = new Conexao ();
		$conn->openConnect ();
		
		$mydb = mysqli_select_db ( $conn->getCon (), $conn->getBD());
		$resultado = mysqli_query ( $conn->getCon (), 
		"SELECT * FROM abrir_caixa WHERE codigoAbrircaixa = '" . $codigoAcesso . "'");
		
		$array = array ();
		
		while ( $row = mysqli_fetch_assoc ( $resultado ) ) {
			$array [] = $row;
		}
		
		$conn->closeConnect ();
		return $array;
	}

	// Retorna o nome dos funcionarios
	public function listaFuncionarioPeloNome($recNome) {
	
		$conn = new Conexao ();
		$conn->openConnect ();
	
		$mydb = mysqli_select_db ( $conn->getCon (), $conn->getBD());
		$resultado = mysqli_query ( $conn->getCon (), "SELECT * FROM abrir_caixa WHERE nome LIKE '%" . $recNome . "%'" );
	
		$array = array ();
	
		while ( $row = mysqli_fetch_assoc ( $resultado ) ) {
			$array [] = $row;
		}
	
		$conn->closeConnect ();
		return $array;
	}
	
	// Retorna o usuario para alterar pelo id
	public function listaFuncionarioPeloId($id) {
	
		$conn = new Conexao ();
		$conn->openConnect ();
	
		$mydb = mysqli_select_db ( $conn->getCon (), $conn->getBD());
		$resultado = mysqli_query ( $conn->getCon (), "SELECT * FROM abrir_caixa WHERE id = '" . $id . "'" );
	
		$array = array ();
	
		while ( $row = mysqli_fetch_assoc ( $resultado ) ) {
			$array [] = $row;
		}
	
		$conn->closeConnect ();
		return $array;
	}
	
	//Verificar se esse dados ja estão cadastrado na base de dados
	public function VerificarDados($cpf, $email, $nome, $codigoAbrircaixa){
	
		$sqlCpf    = "SELECT cpf 				FROM usuario WHERE cpf 				= '".$cpf."'";
		$sqlEmail  = "SELECT email            FROM usuario WHERE email 			= '".$email."'";
		$sqlNome   = "SELECT nome             FROM usuario WHERE nome				= '".$nome."'";
		$sqlCodigo = "SELECT codigoAbrircaixa FROM usuario WHERE codigoAbrircaixa = '".$codigoAbrircaixa."'";
	
		$conn = new Conexao();
		$conn->openConnect();
	
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resCpf    = mysqli_query($conn->getCon(), $sqlCpf);
		$resEmail  = mysqli_query($conn->getCon(), $sqlEmail);
		$resNome   = mysqli_query($conn->getCon(), $sqlNome);
		$resCodigo = mysqli_query($conn->getCon(), $sqlCodigo);
	
		$conn->closeConnect ();
	
		$arrayCpf    = array();
		$arrayEmail  = array();
		$arrayNome   = array();
		$arrayCodigo = array();
	
		while ($row = mysqli_fetch_assoc($resCpf)) {
			$arrayCpf[]=$row;
		}
		while ($row = mysqli_fetch_assoc($resEmail)) {
			$arrayEmail[]=$row;
		}
		while ($row = mysqli_fetch_assoc($resNome)) {
			$arrayNome[]=$row;
		}
		while ($row = mysqli_fetch_assoc($resCodigo)) {
			$arrayCodigo[]=$row;
		}
	
		if (isset($arrayCpf) || isset($arrayEmail) && isset($arrayNome) || isset($arrayCodigo)){
			$array = [
					"cpf"    => $arrayCpf,
					"email"  => $arrayEmail,
					"nome"   => $arrayNome,
					"codigo" => $arrayCodigo
			];
			return $array;
		} else {
			return true;
		}
		
	}
	
}
?>