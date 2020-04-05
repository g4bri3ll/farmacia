<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8" />
<link rel="stylesheet" href="CSS/style.css" />
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
<title>Contato da Empresa</title>
<?php header("Content-Type: text/html; charset=ISO-8859-1",true);?>
</head>
<body>
<script src="boot/js/bootstrap.js" type="text/javascript" ></script>
<script src="boot/js/bootstrap.min.js" type="text/javascript" ></script>
<script src="boot/js/npm.js" type="text/javascript" ></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="js/jquery-1.7.1.min.js"><\/script>')</script>

<?php
session_start();

include_once 'Model/DAO/EmpresaDAO.php';

if (empty($_SESSION)){
?>
	<script type="text/javascript">
	alert("FaÃ§a seu login"); window.location="index.php";
	</script>
<?php	
} else {
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


<div class="flex-align"><!-- começa o flex -->
    <div class="container span12 text-center col-md-4 col-md-offset-3" style="margin: 0 auto;float: none;">
        <div class="row">
			
			<div align="center">
			<nav class="navbar navbar-default"><br>
			
			<h3>Contato da empresa</h3>
			
			<?php
				foreach ($array as $list => $valor){
			?>
			<table>
			<tr><td align="right"><font size="4" face="Verdana" color="marron">Nome da empresa :     </font></td><td> <?= $valor['nome'];    ?><br></td></tr>
			
			<tr><td align="right"><font size="4" face="Verdana" color="marron">Endereço da empresa : </font></td><td><?= $valor['endereco'];?><br></td></tr>
			
			<tr><td align="right"><font size="4" face="Verdana" color="marron">Email da empresa :    </font></td><td><?= $valor['email'];   ?><br></td></tr>
			
			<tr><td align="right"><font size="4" face="Verdana" color="marron">Contato da empresa :  </font></td><td><?= $valor['telefone'];?><br></td></tr>
			
			<tr><td align="right"><font size="4" face="Verdana" color="marron">Mensagem da empresa : </font></td><td><?= $valor['msg'];     ?><br></td></tr>
			</table><br><br>
			<?php
				}
			?>
			
			</nav>
			</div>
			
		</div>
	</div>
</div>

<!-- Footer
    ================================================== -->
<footer class="footer">
	<div class="container">
    	<p class="pull-right"><a href="#">Voltar ao topo</a></p>
        <p>Desenhado e construído com todo amor do mundo por <a href="#" target="_blank">@Gabriel</a>.</p>
        <p>Este projeto é uma versão de vendas para farmacias mantido por <a href="#">Gabriel do Nascimento Borges</a>.</p>
        <p>Código licenciado sob <a href="http://www.apache.org/licenses/LICENSE-2.0" target="_blank">Apache License v2.0</a>.</p>
        <p>Esta na versão 1.2 licenciado sob.</p>
        <ul class="footer-links">
        </ul>
	</div>
</footer>

</body>
</html>
<?php
}//Fechar o else que esta verificando se tem alguem logado
?>