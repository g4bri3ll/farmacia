<?php
session_start();

$codigoProdutos = $_SESSION['codigoVenda'];

$venDAO = new VendasDAO();
$array = $venDAO->CancelarTodaCompra($codigoProdutos);
foreach ($array as $venDAO => $valores){
	
 	$desconto     = $valores['valorDesconto'];
	$data         = $valores['data'];
	$marca        = $valores['marca'];
	$nome         = $valores['nome'];
	$idUsu        = $valores['idUsuario'];
	$id           = $valores['id'];
	$qtdaExcluida = $valores['qtda'];
	$idProduto    = $valores['idProduto'];
	
	$vendasExcluidas = new VendasExcluidas();
	$vendasExcluidas->idCompra = $id;
	$vendasExcluidas->idUsuario = $idUsu;
	$vendasExcluidas->valorProdDesconto = $desconto;
	$vendasExcluidas->data = $data;
	$vendasExcluidas->marca = $marca;
	$vendasExcluidas->nomeproduto = $nome;
	
	$venExcDAO = new VendaExcluidaDAO();
	//Cadastrar no banco de dados as vendas excluidas
	$venExcDAO->cadastrarTodaVendasExcluidas($vendasExcluidas);
	
	$prodDAO = new ProdutoDAO();
	$listaTodosProduto = $prodDAO->listaQtdaPeloIdProduto($idProduto);
	foreach ($listaTodosProduto as $prodDAO =>$todosProduto){
		$qtdaTotalInserida = $todosProduto['qtda'];
	}
	
	//Receber a quantidade no banco de dados mais a quantidade de produtos comprados echo "<br>";
	$qtda = $qtdaTotalInserida + $qtdaExcluida;
	
	//Alterar a quantidade de produto excluido
	$produto = new Produto();
	$produto->id = $idProduto;
	$produto->qtda = $qtda;
	
	//Recebe o id da compra mais a qtda para alterar no banco de dados
	$prodDAO = new ProdutoDAO();
	$prodDAO->alteraQtdaVendas($produto);
	
	$venDAO = new VendasDAO();
	$venDAO->deletePeloId($id);
	
}

header("Location: ../PaginaInicial.php");

?>