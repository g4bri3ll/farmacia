<?php

include_once 'Model/DAO/UsuarioDAO.php';
include_once 'Model/DAO/ValoresVendasDAO.php';
include_once 'Model/Modelo/VendasExcluidas.php';
include_once 'Model/Modelo/Produto.php';
include_once 'Model/Modelo/ValoresVendas.php';
include_once 'Model/DAO/VendaExcluidaDAO.php';
include_once 'Model/DAO/VendasDAO.php';
include_once 'Model/DAO/ProdutoDAO.php';

//Recebe o parametro vindo da tela
$id = $_GET['id'];

//Instancia a classe de vendas
$venDAO = new VendasDAO();
$recListaVenda = $venDAO->listaPeloId($id);
foreach ($recListaVenda as $venDAO => $valores){
	$idCompra = $valores['id'];
	$idUsuario = $valores['idUsuario'];
	//Pegar o valor da compra do produto, o unico produto vendido
	$valorProdDesconto = $valores['valorDesconto'];
	$data = $valores['data'];
	$marca = $valores['marca'];
	//Receber o nome do produto que esta sendo cancelado pelo usuario
	$nomeproduto = $valores['nome'];
	
	//Pegar a quantidade de produto comprado na compra
	$qtdaComprada = $valores['qtda'];
	$idProduto = $valores['idProduto'];
	
	//Codigo do produto para excluir
	$codigo = $valores['codigoVenda'];
	
}

//Pegar o codigo do produto, para pegar o valor do produto para alterar no banco de dados
$codigoSession = $codigo;
$venDAO = new ValoresVendasDAO();
$lista = $venDAO->listaValorVendaCodigo($codigoSession);
foreach ($lista as $venDAO => $valores){
	//Pegar o ultimo valor da compraTotal
	$vendaTotal = $valores['valor_venda'];
	// faz a remoção do valor de desconto
	$vendaTotal = str_ireplace ( ",", ".", $vendaTotal ); // substitui a virgula por ponto
}

$valorProdDesconto = str_ireplace ( ",", ".", $valorProdDesconto ); // substitui a virgula por ponto

//receber o valor total do produto comprado
$valorFinalTotal = $vendaTotal - $valorProdDesconto;
//Pegar o ultimo valor de toda a compra
$valorFinalTotal = number_format ( $valorFinalTotal, 2, ',', '.' ); // converte de novo para numero com separador de milhares e virgula

//Instacia a classe para pegar o valor total da compra
$valoresVenda = new ValoresVendas();
$valoresVenda->codigo_venda = $codigoSession;
$valoresVenda->valor_venda = $valorFinalTotal;

//chama a classe ValoresVendasDAO(); para salvar os dados no banco de dados
$valoresDAO = new ValoresVendasDAO();
$valoresDAO->alterarValor($valoresVenda);

$vendasExcluidas = new VendasExcluidas();
$vendasExcluidas->idCompra = $idCompra;
$vendasExcluidas->idUsuario = $idUsuario;
$vendasExcluidas->valorProdDesconto = $valorProdDesconto;
$vendasExcluidas->data = $data;
$vendasExcluidas->marca = $marca;
$vendasExcluidas->nomeproduto = $nomeproduto;

$venExcDAO = new VendaExcluidaDAO();
//Cadastrar no banco de dados as vendas excluidas
$venExcDAO->cadastrarVendasExcluidas($vendasExcluidas);

/*Aqui e a parte onde a busca pega a quantidade de produtos inserido no banco e
 *Calcular junto com a quantidade que esta sendo excluida
 * */
$prodDAO = new ProdutoDAO();
$listaTodosProduto = $prodDAO->listaQtdaPeloIdProduto($idProduto);
foreach ($listaTodosProduto as $prodDAO =>$todosProduto){
	$qtdaTotalInserida = $todosProduto['qtda'];
}

//Receber a quantidade no banco de dados mais a quantidade de produtos comprados echo "<br>";
$qtda = $qtdaTotalInserida + $qtdaComprada;

//Alterar a quantidade de produto excluido
$produto = new Produto();
$produto->id = $idProduto;
$produto->qtda = $qtda;

//Recebe o id da compra mais a qtda para alterar no banco de dados
$prodDAO = new ProdutoDAO();
$prodDAO->alteraQtdaVendas($produto);

//Instacia a classe para alterar pelo id
$venDAO = new VendasDAO();
$venDAO->deleteId($id);

//Pegar o codigo da session e verificar se existe no banco de dados
$venDAO = new VendasDAO();
$lisCodigo = $venDAO->ListaCodigoVendaSession($codigoSession);
//verificar se existe o codigo ou não, no banco de dados
if (!empty($lisCodigo)){
	header ( "Location:../Caixa.php?codigo=$codigoSession" );
} else {
	$valorDAO = new ValoresVendasDAO();
	$valorDAO->deleteCodigo($codigoSession);
	unset($_SESSION['codigoVenda']);
	header("Location: ../PaginaInicial.php");
}

?>