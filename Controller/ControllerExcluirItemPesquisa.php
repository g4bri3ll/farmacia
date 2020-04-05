<?php
session_start();

include_once 'ModelDAO/VendasDAO.php';
include_once 'ModelDAO/ValoresVendasDAO.php';
include_once 'ModelDAO/ProdutoDAO.php';
include_once 'ModelModelo/ValoresVendas.php';
include_once 'ModelModelo/Produto.php';

$id = $_GET['id'];

$venDAO = new VendasDAO();
$recListaVenda = $venDAO->listaPeloId($id);
foreach ($recListaVenda as $venDAO => $valores){
	//Pegar a quantidade de produto comprado na compra
	$qtdaComprada = $valores['qtda'];
	$idProduto = $valores['idProduto'];

	//Pegar o valor do valorDesconto, para alterar o valor cancelado pelo usuario
	$valorDesconto = $valores['valorDesconto'];
	// faz a remoчуo do valor de desconto
	$valorDesconto = str_ireplace ( ",", ".", $valorDesconto ); // substitui a virgula por ponto
}


//Receber o ultimo valor inserido para alterar
$venDAO = new ValoresVendasDAO();
$codigoSession = $_SESSION['codigoVenda'];
$recListaVenda = $venDAO->listaValorVendaCodigo($codigoSession);
foreach ($recListaVenda as $venDAO => $valores){
	//Pegar o ultimo valor da compraTotal
	$vendaTotal = $valores['valor_venda'];
	// faz a remoчуo do valor de desconto
	$vendaTotal = str_ireplace ( ",", ".", $vendaTotal ); // substitui a virgula por ponto
}
//receber o valor total do produto comprado
$valorFinalTotal = $vendaTotal - $valorDesconto; 
//Pegar o ultimo valor de toda a compra
$valorFinalTotal = number_format ( $valorFinalTotal, 2, ',', '.' ); // converte de novo para numero com separador de milhares e virgula

//Instacia a classe para pegar o valor total da compra
$valoresVenda = new ValoresVendas();
$valoresVenda->codigo_venda = $codigoSession;
$valoresVenda->valor_venda = $valorFinalTotal;

//chama a classe ValoresVendasDAO(); para salvar os dados no banco de dados
$valoresDAO = new ValoresVendasDAO();
$valoresDAO->alterar($valoresVenda);

/*Aqui e a parte onde a busca pega a quantidade de produtos inserido no banco e
 *Calcular junto com a quantidade que esta sendo excluida
 * */
$prodDAO = new ProdutoDAO();
$listaTodosProduto = $prodDAO->listaQtdaPeloIdProduto($idProduto);
foreach ($listaTodosProduto as $prodDAO =>$todosProduto){
	$qtdaTotalInserida = $todosProduto['qtda'];
}
//Receber a quantidade no banco de dados mais a quantidade de produtos comprados
$qtda = $qtdaTotalInserida + $qtdaComprada;
//Alterar a quantidade de produto excluido
$produto = new Produto();
$produto->id = $idProduto;
$produto->qtda = $qtda;
//Recebe o id da compra mais a qtda para alterar no banco de dados
$prodDAO = new ProdutoDAO();
$prodDAO->alteraQtdaVendas($produto);


//instacia a classe
$venDAO = new VendasDAO();
$venDAO->deleteProdutoItem($id);
//receber o codigo da session
$codSession = $_SESSION['codigoVenda'];
//Pegar o codigo da session e verificar se existe no banco de dados
$venDAO = new VendasDAO();
$lisCodigo = $venDAO->ListaCodigoVendaSession($codSession);
//verificar se existe o codigo ou nуo, no banco de dados
if (!empty($lisCodigo)){
	header("Location: ../PaginaInicial.php");
} else {
	$valorDAO = new ValoresVendasDAO();
	$codigoSession = $_SESSION['codigoVenda'];
	$valorDAO->deleteCodigo($codigoSession);
	unset($_SESSION['codigoVenda']);
	header("Location: ../PaginaInicial.php");
}
?>