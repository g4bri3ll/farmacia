<?php
session_start ();

include_once 'Model/Modelo/SituacaoCaixa.php';
include_once 'Model/DAO/SituacaoCaixaDAO.php';
include_once 'Model/DAO/endasDAO.php';

// Pegando a hora do computador para gravar
date_default_timezone_set('America/Sao_Paulo');
$data = date ( 'd/m/y' );
$hora = date ( 'H:i:s' );

/*
 * Inicializar a gravaчуo dos dados
 * E faz as devidas verificaчѕes
 */
//PEgar o id da sessao
$id = $_SESSION['id'];

$sitDAO = new SituacaoCaixaDAO ();
//Verificar se tem la no banco de dados esse id registrado
$sitID = $sitDAO->listaUsuarioPeloId($id);
//Pegar o ultimo id do usuario que abrir o caixa, e pegar tambem se ele esta aberto ou fechado
$retorno = $sitDAO->PegarIdParaFecharCaixa();

//Se a consulta for verdadeira
if (count($sitID) > 0) {
	
	//Pegar o valor se ele esta aberto ou fechado
	foreach ($retorno as $sitDAO => $valor){
		$fechado_aberto = $valor['aberto_fechado'];
		//Pegar o id do usuario que abriu o caixa
		$idParaFechar = $valor["id_usuario"];
	}
	
	foreach ( $sitID as $sitDAO => $valores ) {
		
		//Pegar o id do usuario que abrir o caixa, para fechar
		//So atraves desse id que vai saber quem fechou o caixa
		$idUsuarioCaixa = $valores ['idCaixa'];
		//Codigo do usuario cadastrado para abrir o caixa, ele e gerado no cadastrado
		$codigoCaixaAberto = $valores ['codigo'];

	}

	$situacaoCaixa = new SituacaoCaixa ();
	$situacaoCaixa->hora = $hora;
	$situacaoCaixa->data = $data;
	$situacaoCaixa->codigo = $codigoCaixaAberto;
	//Id de quem esta fechando o caixa, esse id foi cadastrado na parte idCaixa na coluna do banco de dados
	//E ele que pode fechar o caixa
	$situacaoCaixa->idCaixa = $idUsuarioCaixa;
	$situacaoCaixa->aberto_fechado = "Fechado";
	$situacaoCaixa->idUsuario = $id;
	
	//Verificar se o id de quem abrir e o mesmo de quem esta fechando
	if ($idParaFechar === $id){
	
		//Verificar se tem compras em abertos ainda
		$lis = new VendasDAO();
		$lisVendaAberta = $lis->listaTodasVendas();
		foreach ($lisVendaAberta as $lis => $valores){
			//verificar se tem venda aberta ainda
			$situacao = $valores['aberta_fechada'];
		}
		if ($situacao === "Aberto"){
			//se o caixa estiver aberto e se for o mesmo usuario que abriu,nуo deixar fechar o caixa
			header ( "Location: ../Erros/ErrorCompraAberta.php");
		} else {
		
		//se ele estiver aberto
		if ($fechado_aberto === "Aberto"){
		
			$cadSituacaoDAO = new SituacaoCaixaDAO ();
			$cadSituacaoDAO->cadastrarParaFechar($situacaoCaixa);
				
		} else {
			
			//Aqui o caixa ja esta fechado, nуo pode fechar
			header ( "Location: ../Erros/ErrorCaixaFechado.php");
			
		}
		
		}
		
	} else {
		
		//Se nуo for o usuario que abriu o caixa ele nуo deixar fechar e redirecionar para essa pagina
		header ( "Location: ../Erros/ErrorSemPermissaoFecharCaixa.php");
		
	}
	
}//fecha o else que verificar se tem alguma compra em aberto
else {
	//se nуo for encontrado o id do usuario ele retorna para pagina inicial
	header ( "Location: ../PaginaInicial.php" );

}
?>