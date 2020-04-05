<?php

include_once 'Conexao/Conexao.php';

class ValoresVendasDAO{
	
	private $conn = null;
	
	public function cadastrar(ValoresVendas $valoresVendas) {
	
		try {
				
			$sql = "INSERT INTO valores_venda (valor_venda, codigo_venda) VALUES 
					('" . $valoresVendas->valor_venda . "', '" . $valoresVendas->codigo_venda . "')";
				
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
	
	// alterar o valor da ultima da compra total do usuario para a tela de ControllerExcluirItemComprado.php
	public function alterarValor(ValoresVendas $valoresVenda) {
	
		$sql = "UPDATE valores_venda SET valor_venda='" . $valoresVenda->valor_venda . "'
				WHERE codigo_venda = '" . $valoresVenda->codigo_venda . "'";
	
		$conn = new Conexao ();
		$conn->openConnect ();
	
		mysqli_select_db ( $conn->getCon (), $conn->getBD());
		$resultado = mysqli_query ( $conn->getCon (), $sql );
	
		$conn->closeConnect ();

	}
	
	// alterar o valor da ultima da compra total do usuario
	public function alterar(ValoresVendas $valoresVenda) {
	
		$sql = "UPDATE valores_venda SET valor_venda='" . $valoresVenda->valor_venda . "' 
				WHERE codigo_venda = '" . $valoresVenda->codigo_venda . "'";
	
		$conn = new Conexao ();
		$conn->openConnect ();
	
		mysqli_select_db ( $conn->getCon (), $conn->getBD());
		$resultado = mysqli_query ( $conn->getCon (), $sql );
	
		$conn->closeConnect ();
	
		header ( "Location:../PaginaInicial.php" );
	}
	
	// deleta pelo codigo da session selecionado
	public function deleteCodigo($codigoSession) {
	
		$sql = "DELETE FROM valores_venda WHERE codigo_venda = '" . $codigoSession . "'";
	
		$conn = new Conexao ();
		$conn->openConnect ();
	
		mysqli_select_db ( $conn->getCon (), $conn->getBD());
		$resultado = mysqli_query ( $conn->getCon (), $sql );
	
		$conn->closeConnect ();
	
	}
	
	//Lista para o ControllerEfetuar Compra
	public function listaValorDaVenda(){
	
		$sql = sprintf("SELECT * FROM valores_venda");
	
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
	
	//Lista para a RecebeCodigoListaCompra.php pelo codigo e tambem ControllerFinalizarCompra.php
	public function listaValorVenda($codigoVenda){
	
		$conn = new Conexao();
		$conn->openConnect();
	
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultado = mysqli_query($conn->getCon(),
				"SELECT * FROM valores_venda WHERE codigo_venda LIKE '".$codigoVenda."'");
	
		$arrayProduto = array();
	
		while ($row = mysqli_fetch_assoc($resultado)) {
			$arrayProduto[]=$row;
		}
	
		$conn->closeConnect ();
		return $arrayProduto;
	
	}
	
	//Lista para a paginaInicial.php pelo codigo
	public function listaValorVendaCodigo($codigoSession){
	
		$conn = new Conexao();
		$conn->openConnect();
	
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultado = mysqli_query($conn->getCon(), 
		"SELECT * FROM valores_venda WHERE codigo_venda LIKE '".$codigoSession."'");
	
		$arrayProduto = array();
	
		while ($row = mysqli_fetch_assoc($resultado)) {
			$arrayProduto[]=$row;
		}
	
		$conn->closeConnect ();
		return $arrayProduto;
	
	}
}