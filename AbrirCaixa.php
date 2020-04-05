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
<link rel="stylesheet" href="boot/css/bootstrap.css.map"/>
<link rel="stylesheet" href="boot/css/bootstrap.min.css"/>
<link rel="stylesheet" href="CSS/style.css"/>
<script src="js/CheckBox.js"> </script>
<title>Codigo para abrir Caixa</title>
<?php header("Content-Type: text/html; charset=ISO-8859-1",true);?>
</head>
<body>
<script src="boot/js/bootstrap.js" type="text/javascript" ></script>
<script src="boot/js/bootstrap.min.js" type="text/javascript" ></script>
<script src="boot/js/npm.js" type="text/javascript" ></script>

<?php
session_start();

include_once '/home/u232560180/public_html/Model/DAO/AbrirCaixaDAO.php';

if (!empty($_SESSION)){
	if (!isset($_SESSION['login'])){
		header("Location: index.php");
	} else {

		$nivel = $_SESSION['nivel_log'];
		if ($nivel === "c"){
?>
<div align="center">

  <form action="Controller/ControllerAbrirCaixa.php" method="post">
       	<div class="control-group">
		<span><img alt="" src="fotos/codigo_acesso.jpg"> </span>
        <input type="password" name="codigo" placeholder="Informe o codigo de acesso:">
        </div>
       	<div class="control-group">
       <input type="submit" value="Enviar Codigo" class="btn btn-info">
       <input type="reset" value="limpa" class="btn btn-info">
       </div>
  </form>

<a href="PaginaInicial.php" class="btn btn-info">Volta ao site</a>

</div>
<?php
		} else {
?>
<script type="text/javascript">
alert("Usuario sem autorização para abrir caixa");
window.location="PaginaInicial.php";
</script>

</body>
</html>
<?php
		}
	} 
}
?>