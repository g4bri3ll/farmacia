<?php

class CompraFinalDAO {
	
	private $conn = null;
	
	//Cadastrar a ultima Venda
	public function cadastrar(CompraFinal $compraFinal) {

		try {
								
				$sql = "INSERT INTO compra_final (valorCompra, codigoVenda) VALUES 
						('".$compraFinal->valorCompra."', '".$compraFinal->codigoVenda."')";
				
				$conn = new Conexao ();
				$conn->openConnect ();
				
				$mydb = mysqli_select_db ( $conn->getCon (), $conn->getBD());
				$resultado = mysqli_query ( $conn->getCon (), $sql );
				
				$conn->closeConnect ();
				
			} catch ( PDOException $e ) {
				
			}
	}
	
	//Retorna a lista como todos os produto
	public function listaCompraFinal(){
	
		$sql = sprintf("SELECT * FROM compra_final");
	
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
	
	//Lista pelo codigo para imprimirComprovante.php
	public function listaPeloCodigo($codigoVenda){
	
		$conn = new Conexao();
		$conn->openConnect();
	
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultado = mysqli_query($conn->getCon(), 
				"SELECT * FROM compra_final WHERE codigoVenda='".$codigoVenda."'");
	
		$arrayProduto = array();
	
		while ($row = mysqli_fetch_assoc($resultado)) {
			$arrayProduto[]=$row;
		}
	
		$conn->closeConnect ();
		return $arrayProduto;
	
	}
	
}
?>