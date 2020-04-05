<?php
session_start();

include_once 'Model/DAO/SituacaoCaixaDAO.php';

//Receber a situação do caixa, se esta aberto ou fechado
$abertoFechado = new SituacaoCaixaDAO();
$array = $abertoFechado->AbertoFechado();

//Receber o id do usuario que abriu o caixa
foreach ($array as $abertoFechado => $valores){
	$situacao = $valores['aberto_fechado'];
	$id       = $valores['id'];
}

$nivel = $_SESSION['nivel_log'];
//Verificar se o id da session e o mesmo que abriu o caixa
if ($nivel !== "c"){
	header("Location: Controller/ControllerSairSistema.php");
} else {
?>
<html>
<body>

<script type="text/javascript">

var verificarCaixa = "<?php echo $situacao; ?>";
if(verificarCaixa === "Aberto"){
	if (confirm("O caixa esta aberto ainda, tem certeza que deseja fechar?")){
		window.location="Controller/ControllerSairSistemaForcado.php";
	} else {
		window.location="PaginaInicial.php";
	}
} else{
	window.location="Controller/ControllerSairSistema.php";
}

</script>

</body>
</html>
<?php 
}
?>