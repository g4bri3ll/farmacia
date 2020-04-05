<!doctype html>
<html lang="pt-BR">
<head>
<link rel="stylesheet" href="CSS/Index.css" />
<link rel="stylesheet" href="boot/css/bootstrap-responsive.css"/>
<link rel="stylesheet" href="boot/css/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="boot/css/bootstrap-theme.css" />
<link rel="stylesheet" href="boot/css/bootstrap-theme.css.map"/>
<link rel="stylesheet" href="boot/css/bootstrap-theme.min.css" />
<link rel="stylesheet" href="boot/css/bootstrap.css" />
<link rel="stylesheet" href="boot/css/docs.css" />
<link rel="stylesheet" href="boot/css/bootstrap.css.map"/>
<link rel="stylesheet" href="boot/css/bootstrap.min.css"/>
<link rel="stylesheet" href="CSS/style.css"/>
<title>Controle de Vendas de Produto</title>
<?php header("Content-Type: text/html; charset=ISO-8859-1",true);?>
</head>
<body>
<script src="boot/js/bootstrap.js" type="text/javascript" ></script>
<script src="boot/js/bootstrap.min.js" type="text/javascript" ></script>
<script src="boot/js/npm.js" type="text/javascript" ></script>
<?php
session_start();

include_once '/home/u232560180/public_html/Model/DAO/EmpresaDAO.php';

if (empty($_SESSION)){
	?>
	<script type="text/javascript">
	alert("Usuario sem permissão");
	window.location="../PaginaInicial.php";
	</script>
<?php	
} else {
$nivel = $_SESSION['nivel_log'];
if ($nivel == 2){
?>

<nav class="navbar navbar-fixed-top navbar-inverse">
	<div class="navbar-inner">
		<div class="container">
			<button class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a href="#" class="brand">teste</a>
		<div class="nav-collapse collapse">
			<ul class="nav">
				<li><a href="#"> Link 1 </a></li>
				<li><a href="#"> Link 2 </a></li>
				<li><a href="#"> Link 3 </a></li>
				<li><a href="#"> Link 4 </a></li>
				<li><a href="#"> Link 5 </a></li>
				<li><a href="#"> Link 6 </a></li>
			</ul>
<!-- Se o usuario loga em duas maquinas ele vai pode fecharo caixa ao sair, tem que pegar o mac da mÃ¡quina e grava na session
para quando ele sair verificar se o mesmo usuario logado na mÃ¡quina e que esta fechando o sistema -->
			<a href="VerificarSaidaSistema.php" class="pull-right">
			<input type="image" width="40px" height="35px" src="fotos/sair.jpg" /></a><br><br>
		</div>
	</div>
</div>
</nav>

<header class="jumbotron subhead">
	<div class="container">
	<?php
$lis = new EmpresaDAO();
$array = $lis->lista();
if (!empty($array)){
foreach ($array as $list => $valores){
?>
<h1><?=$valores["nome"] ?></h1>
<p><?=$valores["msg"] ?></p>
<?php
}} else {
?>
<p><font size="30px" color="red">Faça o cadastrado da empresa</font></p>
<?php
}
?>
	
	</div>
</header>

<div align="center">

<br><br><a href="PaginaInicial.php" class="btn btn-info">Voltar ao Site</a><br><br>

<select class="selectpicker span6" onchange="javascript:location.href=this.value" >
   <optgroup label="FunÃ§Ã£o Vendas">
      <option value="#">Vendas</option>
      <option value="ADM/ListaTodasVendas.php">Lista Todas as Vendas</option>
      <option value="ADM/ListaVendasExcluidas.php">Lista Todas as Vendas Excluidas</option>
   </optgroup>
   <optgroup label="FunÃ§Ã£o Empresa">
      <option value="#">Empresa</option>
      <option value="ADM/CadastraEmpresa.php">Cadastra Empresa</option>
      <option value="ADM/ListaEmpresa.php">Lista Empresa</option>
   </optgroup>
</select>

</div>

<!-- Footer
    ================================================== -->
<footer class="footer">
	<div class="container">
    	<p class="pull-right"><a href="#">Voltar ao topo</a></p>
        <p>Desenhado e construído com todo amor do mundo por <a href="#" target="_blank">@Gabriel</a>.</p>
        <p>Este projeto é uma versão de vendas para farmacias mantido por <a href="http://blog.alexandremagno.net">Gabriel do Nascimento Borges</a>.</p>
        <p>Código licenciado sob <a href="http://www.apache.org/licenses/LICENSE-2.0" target="_blank">Xampp License v2.0</a>.</p>
        <p>Esta na versão 1.2 licenciado sob.</p>
        <ul class="footer-links">
        </ul>
	</div>
</footer>


<?php
	}
}
?>
</body>
</html>