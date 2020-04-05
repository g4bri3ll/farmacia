<?php

class VendaExcluidaDAO {
	
	//Cadastrar o produto
	public function cadastrarVendasExcluidas(VendasExcluidas $vendasExcluidas) {

		try {				
	
			$sql = "INSERT INTO vendas_excluidas (idCompra, idUsuario, valorProdDesconto, data, marca, nomeProduto)
				VALUES ('" . $vendasExcluidas->idCompra . "', '" . $vendasExcluidas->idUsuario . "', '" . $vendasExcluidas->valorProdDesconto . "',
				'" . $vendasExcluidas->data . "', '" . $vendasExcluidas->marca . "', '" . $vendasExcluidas->nomeproduto . "')";
			
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
	
	//Cadastrar todos os produto excluido na tela principal
	public function cadastrarTodaVendasExcluidas(VendasExcluidas $vendasExcluidas) {

		try {				
	
			$sql = "INSERT INTO vendas_excluidas (idCompra, idUsuario, valorProdDesconto, data, marca, nomeProduto)
				VALUES ('" . $vendasExcluidas->idCompra . "', '" . $vendasExcluidas->idUsuario . "', '" . $vendasExcluidas->valorProdDesconto . "',
				'" . $vendasExcluidas->data . "', '" . $vendasExcluidas->marca . "', '" . $vendasExcluidas->nomeproduto . "')";
			
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
	
	//deleta a compra cancelada pelo usuario
	public function deleteId($id) {
		
		$sql = "DELETE FROM vendas_excluidas WHERE id = '" . $id . "'";
	
		$conn = new Conexao ();
		$conn->openConnect ();
	
		mysqli_select_db ( $conn->getCon (), $conn->getBD());
		$resultado = mysqli_query ( $conn->getCon (), $sql );
	
		header ( "Location:../PaginaInicial.php" );
	
		return true;
	}
	
	//lista todas as vendas para a classe ListaVendasEcluidas
	public function listaTodasVendasExcluidas(){
	
		$conn = new Conexao();
		$conn->openConnect();
	
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultado = mysqli_query($conn->getCon(),
				"SELECT * FROM vendas_excluidas ORDER BY id DESC");
	
		$arrayVendas = array();
	
		while ($row = mysqli_fetch_assoc($resultado)) {
			$arrayVendas[]=$row;
		}
	
		$conn->closeConnect ();
		return $arrayVendas;
	
	}
	
	//lista todas as vendas
	public function listaVendasExcluidas(){
	
		$conn = new Conexao();
		$conn->openConnect();
	
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultado = mysqli_query($conn->getCon(),
				"SELECT * FROM vendas_excluidas");
	
		$arrayVendas = array();
	
		while ($row = mysqli_fetch_assoc($resultado)) {
			$arrayVendas[]=$row;
		}
	
		$conn->closeConnect ();
		return $arrayVendas;
	
	}
	
}
?>