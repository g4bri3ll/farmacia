<?php
session_start();

include_once 'Model/DAO/VendasDAO.php';
include_once 'Model/Modelo/CompraFinal.php';
include_once 'Model/DAO/CompraFinalDAO.php';
include_once 'Model/DAO/ValoresVendasDAO.php';

if (!empty($_POST)) {

	if (isset($_POST['dinheiroCliente'])) {

		if (!empty($_POST['dinheiroCliente'])) {

			//Pegar o dinheiro inserido, para calcular com o valor comprado
			$dinheiro = $_POST['dinheiroCliente'];
			
			//Jogar o dinheiro do cliente na session para pegar para imprimir
			$_SESSION['dinheiro_cliente'] = $dinheiro;
			
			$codigoVenda = $_GET['codigo'];
			$lis = new ValoresVendasDAO();
			//Pegar o ultimo valor total da compra cadastrado no banco de dados
			$listaVendas = $lis->listaValorVenda($codigoVenda);
			foreach ($listaVendas as $lis => $valores){
				//Pegar o ultimo valor da venda inserida
				$ultimoValorVendido = $valores['valor_venda'];
			}

					// faz a remoчуo dos ponto e virgulas da variavel
					$ultimoValorVendido = str_ireplace ( ",", ".", $ultimoValorVendido ); // substitui a virgula por ponto
					
					// faz a remoчуo dos ponto e virgulas da variavel
					$dinheiro = str_ireplace ( ",", ".", $dinheiro ); // substitui a virgula por ponto
			
				//*Se o dinheiro dado pelo comprado ao caixa ele faz
				if ($dinheiro >= $ultimoValorVendido){
					
					$troco = $dinheiro - $ultimoValorVendido;
					
					//Pegar o ultimo valor de toda a compra
					$troco = number_format ( $troco, 2, ',', '.' ); // converte de novo para numero com separador de milhares e virgula

					//Jogar o troco do cliente na session para imprimir na pagina ImprimirComprovante.php
					$_SESSION['troco'] = $troco;
					
					//Gravar no banco de dados toda a informaчуo da venda
					$compraFinal = new CompraFinal();
					$compraFinal->valorCompra = $ultimoValorVendido;
					$compraFinal->codigoVenda = $codigoVenda;
					
					$comDAO = new CompraFinalDAO();
					$comDAO->cadastrar($compraFinal);
					
					//Fecha as compra do produtos comprados pelo codigo que estуo abertas no banco de dados
					$venDAO = new VendasDAO();
					$lista = $venDAO->ListaPeloCod($codigoVenda);
					foreach ($lista as $venDAO => $valor){
						$id = $valor['id'];
						$aberta = "fechada";
						$venDAO = new VendasDAO();
						$venDAO->alterar($aberta, $id);
					}
					
					//Recebe o dinheiro com o troco do cliente
					$_SESSION['codigoVenda'] = $codigoVenda;
					header("Location: ../ImprimirComprovante.php");
					
				} else {
					header("Location: ../Erros/DinheiroClienteMenor.php?codigo=$codigoVenda");
				}
				
		} else {
			header("Location: ../Erros/ErroCampoDinheiroVazio.php");
		}
		
	} else {
	header("Location: ../Erros/NaoTemNadaPost.php");
	}
	
} else {
	header("Location: ../Erros/NaoHouveSubmit.php");
}

?>