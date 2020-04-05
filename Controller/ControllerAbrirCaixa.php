<?php
session_start();

include_once 'Model/DAO/AbrirCaixaDAO.php';
include_once 'Model/Modelo/SituacaoCaixa.php';
include_once 'Model/DAO/SituacaoCaixaDAO.php';

/*Inicializar a gravaчуo dos dados
 * E faz as devidas verificaчѕes
 * */ 
if (!empty($_POST)){
	
	if (isset($_POST['codigo'])){
		
		if (!empty($_POST['codigo'])){
		
			$codigoAcesso = $_POST['codigo'];
			$idUsuario = $_SESSION['id'];
				
			$abrDAO = new AbrirCaixaDAO();
			//receber o codigo do usuario e o id do usuario na session, para verificar se consta na tabela do banco de dados
			$recCodigo = $abrDAO->listaParaAbrirCaixa($codigoAcesso);
			//se consta na tabela do banco de dados
				
			if (!empty($recCodigo)){
				
				foreach ($recCodigo as $abrDAO => $valores){
					
					//Pegar o id do usuario cadastrado para abrir caixa
					$idUsuarioCaixa = $valores['id_usuario'];
					//Pegar tambem o codigo de acesso para abrir o caixa
					$codigoCaixaAberto = $valores['codigoAbrircaixa'];
					
				}
				
				//Pegando a hora do computador para gravar
				date_default_timezone_set('America/Sao_Paulo');
				$data = date('d/m/y');
				$hora = date('H:i:s');
				
				$situacaoCaixa = new SituacaoCaixa();
				$situacaoCaixa->hora = $hora;
				$situacaoCaixa->data = $data;
				$situacaoCaixa->codigo = $codigoCaixaAberto;
				$situacaoCaixa->idCaixa = $idUsuarioCaixa;
				$situacaoCaixa->aberto_fechado = "Aberto";
				$situacaoCaixa->idUsuario = $idUsuario;
				
				//Receber o id do usuario na session e comprara com o id do usuario vindo do banco de dados
				if ($idUsuario === $idUsuarioCaixa){
					
					$cadSituacaoDAO = new SituacaoCaixaDAO();
					//Cadastrar no banco o usuario que abrir o caixa
					$cadSituacaoDAO->cadastrarParaAbrir($situacaoCaixa);
					
				} else {
					
					
					header("Location: ../Erros/ErrorAbrirCaixaCodigoInvalido.php");
				}
				
			} else {
				
				header("Location: ../Erros/CodigoCaixaNaoEncontrado.php");
				
			}
			
				//usuario nуo cadastrado para abrir o caixa
			} else {
				//se ele tentar abrir o caixa, com o codigo de outra pessoa da erro
				header("Location: ../Erros/ErrorCodigoAbrirCaixaInvalido.php");
				
			}
			
		} else {
			
			header("Location: ../Erros/ErrorCodigoAbrirCaixaVazio.php");

		}
			
} else {
	
	header("Location: ../AbrirCaixa.php");
	//echo "retornara ao abrir caixa";
	
}
?>