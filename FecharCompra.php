<?php
session_start ();

include_once 'Model/DAO/VendasDAO.php';

$cod = $_SESSION ['codigoVenda'];
$venDAO = new VendasDAO ();
$arrayNomeComprador = $venDAO->listaNomeComprador ( $cod );
foreach ( $arrayNomeComprador as $venDAO => $nomeComprador ) {
	$nomeComp = $nomeComprador ['nomeComprador'];
}
if (empty ( $nomeComp )) {
	$nomeComprador = "Venda 1";
	//Instancia a classe VendasDAO
	$venDAO = new VendasDAO();
	$venDAO->alterarNomeComprador($nomeComprador, $cod);
}

unset ( $_SESSION ['codigoVenda'] );
header ( "Location: PaginaInicial.php" );

?>