<?php 
session_start();

include_once 'Model/Modelo/Usuario.php';
include_once 'Model/DAO/EmpresaDAO.php';
include_once 'Model/DAO/UsuarioDAO.php';
?>
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
<title>Altera Senha</title>
<?php header("Content-Type: text/html; charset=ISO-8859-1",true);?>
</head>
<body>
<script src="boot/js/bootstrap.js" type="text/javascript" ></script>
<script src="boot/js/bootstrap.min.js" type="text/javascript" ></script>
<script src="boot/js/npm.js" type="text/javascript" ></script>

<?php
if (empty($_SESSION)){
	?> <script type="text/javascript">	alert("Usuario não logado no sistema");	window.location="PaginaInicial.php"; </script> <?php	
} else {
?>

<div align="center">
<h2>Alteração de Senha</h2><br>

<?php 
if (!empty($_POST)) {
	
	if (empty($_POST ['antigaSenha']) || empty($_POST ['atualSenha']) && empty($_POST ['antigaSenhaComfirmada'])){
		?> <div class="alert alert-error"> <font size="3px" color="red"> Preencha todos os campos! </font> </div> <?php
	} else {
	
		$antigaSenha = $_POST ['antigaSenha'];
		$senhaAtual = $_POST ['atualSenha'];
		$comfirmar_senha = $_POST ['antigaSenhaComfirmada'];
		
		$usu = new Usuario ();
		$usu->senhaVelha = $antigaSenha;
		$usu->senhaAtual = $senhaAtual;
		$usu->comfirmar_senha = $comfirmar_senha;
		
		$cad = new UsuarioDAO ();
		$result = $cad->alterarSenhas($usu);
		
		if ($result){
			?><script type="text/javascript"> alert('Senha alterada com sucesso!'); window.location="PaginaInicial.php"; </script><?php
		} else {
			?><script type="text/javascript"> alert('Ocorreu um erro ao alterar a senha, tente novamente!'); window.location="AlteraSenha.php" </script><?php
		}
		
	}
	
}
?>
  <form action="AlteraSenha.php" method="post">
  
       	<div class="control-group">
		<span><img alt="" src="fotos/senha.jpg"> </span>
        <input type="password" name="antigaSenha" placeholder="Informe a senha atual:">
		
		<span><img alt="" src="fotos/senha.jpg"> </span>
        <input type="password" name="atualSenha" placeholder="Informe a nova senha:">
		
		<span><img alt="" src="fotos/senha.jpg"> </span>
        <input type="password" name="antigaSenhaComfirmada" placeholder="Comfirmer a Nova Senha:">
        </div><br>
       	<div class="control-group">
        <input type="submit" value="Altera Senha" class="btn btn-info span3">
        
        <input type="reset" value="limpa" class="btn btn-info span2">
        </div>

  </form>

<a href="PaginaInicial.php" class="btn btn-info">Volta ao site</a>
</div>

<?php } ?>

</body>
</html>