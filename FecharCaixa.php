<?php
session_start();

include_once 'Model/DAO/VendasDAO.php';

//Receber a todas as vendas em aberto ainda
$venDAO = new VendasDAO();
$array = $venDAO->listaVendasAbertasParaFechar();

//Receber o id do usuario que abriu o caixa
foreach ($array as $venDAO => $valores){
	$situacao = $valores['aberta_fechada'];
}
?>
<html>
<body>

<?php 
if($situacao === "Aberta"){
?>
<script type="text/javascript">
if (confirm("Existe compra em aberto ainda, deseja sair assim mesmo?")){
	window.location="Controller/ControllerFechaCaixa.php";
} else {
	window.location="PaginaInicial.php";
}
</script>
<?php 
} else {
	header("Location: Controller/ControllerFechaCaixa.php");
}
?>
 
</body>
</html>