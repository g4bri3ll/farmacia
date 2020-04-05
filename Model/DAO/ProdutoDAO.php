<?php

include_once 'Conexao/Conexao.php';

class ProdutoDAO {
	private $conn = null;
	
	//Cadastrar o produto
	public function cadastrarProduto(Produto $produto) {

		try {
								
			$sql = "INSERT INTO produto (nome, CodBarra, Codigo, ValorDesconto, ValorProduto, qtda, marca) 
			VALUES ('" . $produto->nome . "', '" . $produto->codBarra . "', '" . $produto->codigo . "', '" . $produto->valorDesconto . "',
						'" . $produto->valorProduto . "','" . $produto->qtda . "','" . $produto->marca . "')";
				
			$conn = new Conexao ();
			$conn->openConnect ();
			
			$mydb = mysqli_select_db ( $conn->getCon (), $conn->getBD());
			$resultado = mysqli_query ( $conn->getCon (), $sql );
				
			$conn->closeConnect ();
				
			return true;
				
		} catch ( PDOException $e ) {
			return $e->getMessage();
		}
	}
	
	public function alterarProduto(Produto $produto) {
		
		$sql = "UPDATE produto SET nome='" . $produto->nome . "', CodBarra='" . $produto->codBarra . "', Codigo='" . $produto->codigo . "', 
				ValorDesconto='" . $produto->valorDesconto . "', ValorProduto='" . $produto->valorProduto . "', qtda='" . $produto->qtda . "',
						marca='" . $produto->marca . "'	WHERE id = '" . $produto->id . "'";
		
		$conn = new Conexao ();
		$conn->openConnect ();
		
		mysqli_select_db ( $conn->getCon (), $conn->getBD());
		$resultado = mysqli_query ( $conn->getCon (), $sql );
		
		$conn->closeConnect ();

		return true;
	}
	
	//Alterar a quantidade de produto cancelado
	public function alteraQtdaVendas(Produto $produto) {
	
		try {
				
			$sql = "UPDATE produto SET qtda='".$produto->qtda."' WHERE id='".$produto->id."'";
			
			$conn = new Conexao ();
			$conn->openConnect ();
	
			$mydb = mysqli_select_db ( $conn->getCon (), $conn->getBD());
			$resultado = mysqli_query ( $conn->getCon (), $sql );
	
			$conn->closeConnect ();
			
			return true;
			
		} catch ( PDOException $e ) {
			$e->getMessage();
			return false;
		}
	
	}
	
	//Alterar a quantidade de produto Comprados
	public function alteraQtdaProdutosComprados($id, $qtdAlt) {
	
		try {
				
			$sql = "UPDATE produto SET qtda='".$qtdAlt."' WHERE id='".$id."'";
			
			$conn = new Conexao ();
			$conn->openConnect ();
	
			$mydb = mysqli_select_db ( $conn->getCon (), $conn->getBD());
			$resultado = mysqli_query ( $conn->getCon (), $sql );
	
			$conn->closeConnect ();
			
			return true;
			
		} catch ( PDOException $e ) {
			$e->getMessage();
			return false;
		}
	
	}
	
	public function deleteId($id) {
		$sql = "DELETE FROM produto WHERE id = '" . $id . "'";
		
		$conn = new Conexao ();
		$conn->openConnect ();
		
		mysqli_select_db ( $conn->getCon (), $conn->getBD());
		$resultado = mysqli_query ( $conn->getCon (), $sql );
		
		$conn->closeConnect ();
		
		return true;
	}
	
	//Retorna a lista como todos os produto
	public function listaProduto(){
	
		$sql = "SELECT * FROM produto ORDER BY id DESC";
	
		$conn = new Conexao();
		$conn->openConnect();
	
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultado = mysqli_query($conn->getCon(), $sql);
	
		$arrayProduto = array();
	
		while ($row = mysqli_fetch_assoc($resultado)) {
			$arrayProduto[]=$row;
		}
	
		$conn->closeConnect ();
		return $arrayProduto;
	
	}
	
	//Retorna a lista de produtos pelo nome para a pagina inicial
	public function listaPeloNome($nome){
	
		$conn = new Conexao();
		$conn->openConnect();
	
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultado = mysqli_query($conn->getCon(),
				"SELECT * FROM produto WHERE BINARY nome LIKE '%".$nome."%' LIMIT 4");
	
		//$list = mysqli_fetch_assoc($resultado);
	
		$arrayProduto = array();
	
		while ($row = mysqli_fetch_assoc($resultado)) {
			$arrayProduto[]=$row;
		}
	
		$conn->closeConnect ();
		return $arrayProduto;
	
	}
	
	//Retorna a lista de produtos encontrados se esta repetindo ou não para o cadastro de produto php
	public function ValidarArray($nome, $codBarra){
	
		$sqlNome     = "SELECT nome FROM produto WHERE nome LIKE '".$nome."'";
		$sqlCodBarra = "SELECT CodBarra FROM produto WHERE CodBarra LIKE '".$codBarra."'";
		
		$conn = new Conexao();
		$conn->openConnect();
	
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultNome = mysqli_query($conn->getCon(), $sqlNome);
		$resulCodBarra = mysqli_query($conn->getCon(), $sqlCodBarra);
	
		$conn->closeConnect ();
		
		$arrayNome = array();
		while ($row = mysqli_fetch_assoc($resultNome)) {
			$arrayNome[]=$row;
		}
	
		$arrayCodBarra = array();
		while ($row = mysqli_fetch_assoc($resulCodBarra)) {
			$arrayCodBarra[]=$row;
		}
		
		if (isset($resulCodBarra) || isset($resultNome)){
			
			$returnArray = [
				"nome" => $arrayNome,
				"codigo_barra" => $arrayCodBarra
			];
			
			return $returnArray;
			
		} else {
			
			return true;
			
		}
		
	}
	
	//retorna a quantidade de produto cadastrado no banco de dados
	public function listaQtdaPeloIdProduto($idProduto){
	
		$conn = new Conexao();
		$conn->openConnect();
	
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultado = mysqli_query($conn->getCon(), 
				"SELECT qtda FROM produto WHERE id = '".$idProduto."'");
	
		//$list = mysqli_fetch_assoc($resultado);
	
		$arrayProduto = array();
	
		while ($row = mysqli_fetch_assoc($resultado)) {
			$arrayProduto[]=$row;
		}
	
		$conn->closeConnect ();
		return $arrayProduto;
	
	}
	
	//Retorna a lista de produtos pelo nome na ListaProduto.php
	public function listaProdutoPeloNome($recNome){
	
		$conn = new Conexao();
		$conn->openConnect();
	
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultado = mysqli_query($conn->getCon(), 
				"SELECT * FROM produto WHERE BINARY nome LIKE '%".$recNome."%'");
	
		//$list = mysqli_fetch_assoc($resultado);
	
		$arrayProduto = array();
	
		while ($row = mysqli_fetch_assoc($resultado)) {
			$arrayProduto[]=$row;
		}
	
		$conn->closeConnect ();
		return $arrayProduto;
	
	}
	
	//Retorna a lista como todos os produto do tipo do codigo pesquisado
	public function listaProdutoPeloId($id){
		
		$conn = new Conexao();
		$conn->openConnect();
	
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultado = mysqli_query($conn->getCon(), 
				"SELECT * FROM produto WHERE id = '".$id."'");
	
		$arrayProduto = array();
	
		while ($row = mysqli_fetch_array($resultado)) {
			$arrayProduto[]=$row;
		}

		$conn->closeConnect ();
		return $arrayProduto;
	
	}
	
}
?>