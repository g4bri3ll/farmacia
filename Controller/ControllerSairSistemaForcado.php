<?php

include_once 'Model/DAO/SituacaoCaixaDAO.php';

//Receber a situação do caixa, se esta aberto ou fechado
$abertoFechado = new SituacaoCaixaDAO();
$arraySituacao = $abertoFechado->AbertoFechado();

foreach ($arraySituacao as $abertoFechado => $valores){
	$situacao = $valores['aberto_fechado'];
}

	if ($situacao === "Aberto"){
	
		$situacaoCaixa = "Fechado";

		print_r($situacaoCaixa);
		
		$abertoFechado = new SituacaoCaixaDAO();
		$abertoFechado->AlteraCaixaAberto($situacaoCaixa);
	
		session_start();
		session_destroy();
	
		header("Location: ../Index.php");
		
	}

?>
