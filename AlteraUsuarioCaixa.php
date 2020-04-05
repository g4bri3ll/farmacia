<?php 
session_start();

include_once 'Model/DAO/AbrirCaixaDAO.php';
include_once 'Model/DAO/UsuarioDAO.php';
include_once 'Model/Modelo/AbrirCaixa.php';
include_once 'Model/DAO/AbrirCaixaDAO.php';
include_once 'Validacoes/valida-email.php';
include_once 'Validacoes/valida-cpf.php';
?>
<!doctype html>
<html lang="pt-BR">
<head>
<link rel="stylesheet" href="boot/css/bootstrap-responsive.css"/>
<link rel="stylesheet" href="boot/css/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="boot/css/bootstrap-theme.css" />
<link rel="stylesheet" href="boot/css/bootstrap-theme.css.map"/>
<link rel="stylesheet" href="boot/css/bootstrap-theme.min.css" />
<link rel="stylesheet" href="boot/css/bootstrap.css" />
<link rel="stylesheet" href="boot/css/bootstrap.css.map"/>
<link rel="stylesheet" href="boot/css/bootstrap.min.css"/>
<link rel="stylesheet" href="CSS/style.css"/>
<title>Alteração de Usuario para o Caixa</title>
<?php header("Content-Type: text/html; charset=ISO-8859-1",true);?>
</head>
<body>
<script src="boot/js/bootstrap.js" type="text/javascript" ></script>
<script src="boot/js/bootstrap.min.js" type="text/javascript" ></script>
<script src="boot/js/npm.js" type="text/javascript" ></script>

<?php

if (empty($_SESSION)){
?> <script type="text/javascript"> alert("Usuario não logado no sistema"); window.location="Index.php";	</script> <?php	
} else {
	$nivel = $_SESSION['nivel_log'];
?>

<script type="text/javascript">
//--->Função para a formatação dos campos...<---
function Mascara(tipo, campo, teclaPress) {
	if (window.event)
	{
		var tecla = teclaPress.keyCode;
	} else {
		tecla = teclaPress.which;
	}
 
	var s = new String(campo.value);
	// Remove todos os caracteres à seguir: ( ) / - . e espaço, para tratar a string denovo.
	s = s.replace(/(\.|\(|\)|\/|\-| )+/g,'');
 
	tam = s.length + 1;
 
	if ( tecla != 9 && tecla != 8 ) {
		switch (tipo)
		{
		case 'CPF' :
			if (tam > 3 && tam < 7)
				campo.value = s.substr(0,3) + '.' + s.substr(3, tam);
			if (tam >= 7 && tam < 10)
				campo.value = s.substr(0,3) + '.' + s.substr(3,3) + '.' + s.substr(6,tam-6);
			if (tam >= 10 && tam < 12)
				campo.value = s.substr(0,3) + '.' + s.substr(3,3) + '.' + s.substr(6,3) + '-' + s.substr(9,tam-9);
		break;
 
		}
	}
}

//--->Função para verificar se o valor digitado é número...<---
function digitos(event){
	if (window.event) {
		// IE
		key = event.keyCode;
	} else if ( event.which ) {
		// netscape
		key = event.which;
	}
	if ( key != 8 || key != 13 || key < 48 || key > 57 )
		return ( ( ( key > 47 ) && ( key < 58 ) ) || ( key == 8 ) || ( key == 13 ) );
	return true;
}
</script>

<div align="center">

<fieldset>
<legend>Alterar os Dados do funcionarios do caixa</legend>

<?php 
if (!empty($_POST)) {

	if (empty($_GET['id']) || empty($_POST['nome']) || empty($_POST['cpf']) || empty($_POST['email'])){
		?> <div class="alert alert-error"> <font size="3px" color="red"> Campos vazio não permitido! </font> </div> <?php
	} else {
	
		$id = $_GET['id'];
		$nome = $_POST['nome'];
		//Colocar os dados em minusculo
		$nome = strtolower($nome);
		$recCpf = $_POST['cpf'];
		$recEmail = $_POST['email'];
		//Colocar os dados em minusculo
		$recEmail = strtolower($recEmail);
		
		$cpf = valida_cpf($recCpf);
		$email = verificar_email($recEmail);
		
		//Tira o ponto do cpf
		$cpf = preg_replace('#[^0-9]#', '', $cpf);
		
		if (!$cpf || !$email){
			?><script type="text/javascript"> alert('CPF ou email não e valido, tente novamente!'); window.location="AlteraUsuarioCaixa.php?id=" + <?php echo $id; ?> </script><?php
		} else {
		
			$abrirCaixa = new AbrirCaixa();
			$abrirCaixa->id = $id;
			$abrirCaixa->nome = $nome;
			$abrirCaixa->cpf = $cpf;
			$abrirCaixa->email = $email;
			$abrirCaixa->idUsuario = $_SESSION['id'];
			
			$cad = new AbrirCaixaDAO();
			$resultAlt = $cad->alterar($abrirCaixa);
			
			if ($resultAlt){
				?><script type="text/javascript"> alert('Caixa alterado com sucesso!'); window.location="PaginaInicial.php"; </script><?php
			} else {
				?><script type="text/javascript"> alert('Ocorreu um erro ao alterar o caixa, tente novamente!'); window.location="AlteraUsuarioCaixa.php?id=" + <?php echo $id; ?> </script><?php
			}
			
		}

	}
	
}
?>

<?php
$id = $_GET['id'];
$lis = new AbrirCaixaDAO();
$array = $lis->listaFuncionarioPeloId($id);
foreach ($array as $list => $valores){
?>

<form method="post" action="AlteraUsuarioCaixa.php?id=<?=$valores["id"] ?>" >

Codigo: <font size="5px" color="blue"> <?=$valores["codigoAbrircaixa"] ?> </font>
<br /><br />
<span><img alt="" src="fotos/nome.jpg"> </span>
<input type="text" name="nome" value="<?=$valores["nome"] ?>" class="span8" placeholder="Digite seu nome"/>
<br /><br />
<span><img alt="" src="fotos/cpf.jpg"> </span>
<input type="text" name="cpf" placeholder="Digite seu cpf" value="<?=$valores["cpf"]?>" id="cep" maxlength="14" size="8" onKeyPress="return digitos(event, this);" onKeyUp="Mascara('CPF',this,event);" />
<br /><br />
<span><img alt="" src="fotos/email.jpg"> </span>
<input type="email" name="email" value="<?=$valores["email"] ?>" class="span8" placeholder="Digite seu email"/>
<br /><br />
<input class="btn btn-info"  type="submit" value="alterar dados" />
	
</form>

<?php } ?>

<a href="ListaUsuarioCaixa.php"  class="btn btn-info">Cancelar Alteração</a>

</fieldset>

</div>

</body>
</html>

<?php
}
?>