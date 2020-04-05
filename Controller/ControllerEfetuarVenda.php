<?php
session_start();

include_once 'Model/DAO/ProdutoDAO.php';
include_once 'Model/Modelo/Vendas.php';
include_once 'Model/DAO/VendasDAO.php';
include_once 'Model/DAO/ValoresVendasDAO.php';
include_once 'Model/Modelo/ValoresVendas.php';
include_once 'Validacoes/gera-senhas.php';

if (!empty($_POST)){

	if (isset($_POST ['qtda'])){
		
		if (!empty($_POST ['qtda'])){
			
		$valorTotal = "0,00";
		$qtda = $_POST['qtda'];
		//pegar o id do produto que esta sendo vendido
		$idItem = end(explode('|',$_POST['item']));
		
		if (!empty($idItem)){
		
		//Pegar o id do usuario logado
		$idSession = $_SESSION["id"];

		//Pegando a hora do computador para gravar
		date_default_timezone_set('America/Sao_Paulo');
		$data = date('d/m/y');
		
		$lis = new ProdutoDAO();
		$resultado = $lis->listaProdutoPeloId($idItem);
		
		if ($resultado) {
			
			foreach ( $resultado as $lis => $linha ) {
				$idProduto          = $linha['id']; 
				$qtdaProdutoEstoque = $linha ['qtda'];
				$codigoLista        = $linha ['Codigo'];
				$nome               = $linha ['nome'];
				$marca              = $linha ['marca'];
				$valorProd          = $linha ['ValorProduto'];
				$valorDesc          = $linha ['ValorDesconto'];
				// faz a remoчуo do valor de desconto
				$valorDesc = str_ireplace ( ",", ".", $valorDesc ); // substitui a virgula por ponto
				
				//ValorDesc receber o valor do produto com desconto e mutiplicar pela quantidade comprada
				$valorDesc = $valorDesc * $qtda;
				
			}
				
			if ($qtdaProdutoEstoque >=  $qtda) {
			
				$qtdAlt = $qtdaProdutoEstoque - $qtda;
				//Altera a quantidade de produto comprados
				$prodDAO = new ProdutoDAO();
				//Receber a qtda de produto comprados e no banco de dados e subtrair e colocar nessa variavel ae $qtdAlt 
				$prodDAO->alteraQtdaProdutosComprados($idItem, $qtdAlt);
				
				//Verificar se tem algum codigo na sessao, senуo ele colocar um
				if (empty($_SESSION['codigoVenda'])){
					//Codigo da venda para gravar no banco de dados
					$novoCodigo = geraSenha(15, true, true, true);
					$_SESSION['codigoVenda'] = $novoCodigo;
				}
				
				//Instancia a classe ValoresVendasDAO();
				$venTotalDAO = new ValoresVendasDAO();
				$codigoSession = $_SESSION['codigoVenda'];
				//receber o ultimo valorTotal cadastrado no banco de dados
				$ultimoValorTotalVenda = $venTotalDAO->listaValorVendaCodigo($codigoSession);
				foreach ($ultimoValorTotalVenda as $venDAO => $valores){
					 $valor = $valores['valor_venda'];
					 // faz a remoчуo da virgula na variavel
					$valor = str_ireplace ( ",", ".", $valor ); // substitui a virgula por ponto
					 $valorSomaTotal = $valor + $valorDesc;
					 //Pegar o ultimo valor de toda a compra
					 $valorSomaTotal = number_format ( $valorSomaTotal, 2, ',', '.' ); // converte de novo para numero com separador de milhares e virgula
				}
				
				if (empty($valorSomaTotal)){
					$valorSomaTotal = $valorDesc;
				} 
				
				//Receber o nome do comprador
				$nomeComprador = $_POST['nomeComprador'];
				
				$vendas = new Vendas();
				$vendas->nome = $nome;
				//Nome do cliente que esta comprado o produto
				$vendas->nomeComprador = $nomeComprador;
				$vendas->aberto_fechado = "Aberta";
				$vendas->marca = $marca;
				//Salvar e o codigo de barra da unidade e nуo do produto
				$vendas->codBarra = $codigoLista;
				$vendas->valorDesconto = $valorDesc;
				$vendas->valorProduto = $valorProd;
				//qtda de vendas feitas
				$vendas->qtda = $qtda;
				//id do produto que esta vindo no array
				$vendas->idProduto = $idItem;
				//id do usuario que esta na session
				$vendas->idUsuario = $idSession;
				//valor que foi vendido o produto
				$vendas->data = $data;
				//receber o codigo da session
				$vendas->codigoVenda = $_SESSION['codigoVenda'];
					
				//Instancia a classe VendasDAO
				$venDAO = new VendasDAO();
				$venDAO->cadastrarVendas($vendas);
				
				//chama a classe ValoresVendasDAO();, para verificar se tem algum codigo cadastrado no banco de dados
				$valoresDAO = new ValoresVendasDAO();
				$array = $valoresDAO->listaValorDaVenda();
				foreach ($array as $valoresDAO => $valoresVendaDAO){
					$codigoValorTotal = $valoresVendaDAO['codigo_venda'];
				}
				
				if ($codigoValorTotal === $_SESSION['codigoVenda']){
					
					//Instacia a classe para pegar o valor total da compra
					$valoresVenda = new ValoresVendas();
					$valoresVenda->codigo_venda = $_SESSION['codigoVenda'];
					$valoresVenda->valor_venda = $valorSomaTotal;
						
					//chama a classe ValoresVendasDAO(); para salvar os dados no banco de dados
					$valoresDAO = new ValoresVendasDAO();
					$valoresDAO->alterar($valoresVenda);
					
				} else {
					
					//Instacia a classe para pegar o valor total da compra
					$valoresVendas = new ValoresVendas();
					$valoresVendas->codigo_venda = $_SESSION['codigoVenda'];
					$valoresVendas->valor_venda = $valorSomaTotal;
					
					//chama a classe ValoresVendasDAO(); para salvar os dados no banco de dados
					$valoresDAO = new ValoresVendasDAO();
					$valoresDAO->cadastrar($valoresVendas);
						
				}
				
				
				
			} else {
				header("Location: ../Erros/ErrorProdutoEstoqueVazio.php");
			} 
			
		} else {
			header("Location: ../Erros/ErrorCodigoBarraNaoEncontrado.php");
		}

	} //Fecha o if que esta verificando se o produto foi selecionado ou nуo
	else {
			header("Location: ../Erros/ErrorSelecionarProduto.php");
	}
	
	}//fecha o if que verificar se o campo qtda esta vazio
	
		else {
			header("Location: ../Erros/CampoQtdaVazioEfetuarVenda.php");
		}
	}//
	else {
		header("Location: ../Erros/NaoTemNadaPost.php");
	}
		
} else {
	header("Location: ../Erros/NaoHouveSubmit.php");
}
	

?>