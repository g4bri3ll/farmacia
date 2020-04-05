<?php 
session_start();

include_once 'Model/DAO/UsuarioDAO.php';
include_once 'Model/Modelo/Usuario.php';
include_once 'Validacoes/valida-cpf.php';
include_once 'Validacoes/valida-email.php';
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
<title>Alteração de Usuario</title>
<?php header("Content-Type: text/html; charset=ISO-8859-1",true);?>
</head>
<body>
<script src="boot/js/bootstrap.js" type="text/javascript" ></script>
<script src="boot/js/bootstrap.min.js" type="text/javascript" ></script>
<script src="boot/js/npm.js" type="text/javascript" ></script>

<?php
if (empty($_SESSION)){
	?> <script type="text/javascript"> alert("Usuario não logado no sistema"); window.location="index.php"; </script> <?php	
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
 
		case 'TEL' :
			if (tam > 2 && tam < 4)
				campo.value = '(' + s.substr(0,2) + ') ' + s.substr(2,tam);
			if (tam >= 7 && tam < 11)
				campo.value = '(' + s.substr(0,2) + ') ' + s.substr(2,4) + '-' + s.substr(6,tam-6);
		break;
 
		case 'CEP' :
			if (tam > 5 && tam < 7)
				campo.value = s.substr(0,5) + '-' + s.substr(5, tam);
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

<?php 
if ($nivel !== "2"){
	?> <script type="text/javascript"> alert('Usuário sem permissão de fazer a alteração!'); window.location="ListaUsuarios.php"</script> <?php
} else {
	
	if (!empty($_POST)) {

		if(empty($_GET['id']) || empty($_POST['nome'])|| empty($_POST['endereco']) || empty($_POST['cep']) ||
		   empty($_POST['telefone']) || empty($_POST['cpf']) || empty($_POST['nivel_log']) || empty($_POST['email']) ||
		   empty($_POST['login']) || empty($_POST['senha']) || empty($_POST['comfirmarSenha'])){
			
		   	?> <div class="alert alert-error"> <font size="3px" color="red"> Campos vazio não permitido! </font> </div> <?php
		   	
		} else {
						
		   	$id = $_GET['id'];
			$nome = $_POST['nome'];
			//Colocar os dados em minusculo
			$nome = strtolower($nome);
			$sexo = $_POST['sexo'];
			if ($sexo === "Informe seu sexo"){
				?> <script type="text/javascript"> alert('Informe o sexo!'); window.location="AlteraUsuario.php?id=" + <?=$id; ?> </script> <?php
			}
			$endereco = $_POST['endereco'];
			$cidade = $_POST['cidade'];
			$complemento = $_POST['complemento'];
			$cep = $_POST['cep'];
			$telefone = $_POST['telefone'];
			$cpf = $_POST['cpf'];
			$nivel_log = $_POST['nivel_log'];
			if ($nivel_log ===  "Informe o nivel de acesso do usuario"){
				?> <script type="text/javascript"> alert('Informe o nivel de acesso do usuario!'); window.location="AlteraUsuario.php?id=" + <?=$id; ?> </script> <?php
			}
			$email = $_POST['email'];
			//Colocar os dados em minusculo
			$email = strtolower($email);
			$login = $_POST['login'];
			//Colocar os dados em minusculo
			$login = strtolower($login);
			$senha = $_POST['senha'];
			$comfirmar_senha = $_POST['comfirmarSenha'];
			
			//Tira o ponto do cep
			$cep = preg_replace('#[^0-9]#', '', $cep);
			//Tira o ponto do telefone
			$telefone = preg_replace('#[^0-9]#', '', $telefone);
				
			$retCPF = valida_cpf($cpf);
			$retEmail = verificar_email($email);
				
			//Tira o ponto do cpf
			$retCPF = preg_replace('#[^0-9]#', '', $retCPF);
			
			if (!$retCPF || !$retEmail){
				?> <script type="text/javascript"> alert('CPF ou email não comferem, tente novamente!'); window.location="AlteraUsuario.php?id=" + <?php echo $id;?> </script> <?php
			}
			
			if ($senha !== $comfirmar_senha){
				?> <script type="text/javascript">	alert('Senhas não comferem!'); window.location="AlteraUsuario.php?id=" + <?php echo $id;?> </script> <?php
			} else {
										
				$usu = new Usuario();
				$usu->id = $id;
				$usu->nome = $nome;
				$usu->sexo = $sexo;
				$usu->nivel_log = $nivel_log;
				$usu->endereco = $endereco;
				$usu->cidade = $cidade;
				$usu->complemento = $complemento;
				$usu->cep = $cep;
				$usu->telefone = $telefone;
				$usu->cpf = $retCPF;
				$usu->email = $email;
				$usu->login = $login;
				$usu->senha = $senha;
				$usu->comfirmar_senha = $comfirmar_senha;
				
				$cad = new UsuarioDAO();
				$resultAlt = $cad->alterar($usu);
				
				if ($resultAlt){
					?> <script type="text/javascript">	alert('Usuario alterado com sucesso!'); window.location="ListaUsuarios.php"; </script> <?php
				} else {
					echo $resultAlt;
					?> <script type="text/javascript">	alert('Ja existe um usuario com esse dados, alem do seu!'); window.location="AlteraUsuario.php?id=" + <?php echo $id;?> </script> <?php
				}
				
			}
						
		}
		
	}
	
}
?>

<fieldset>
<legend>Alterar seu Dados</legend>

<?php
if (!empty($_GET['id'])) {
$id = $_GET['id'];
	$lis = new UsuarioDAO();
	$arrayUsuario = $lis->listaUsuarioId($id);
	foreach ($arrayUsuario as $list => $valores){
?>

<form method="post" action="AlteraUsuario.php?id=<?=$valores["id"]; ?>" >

	<div class="control-group">
	<span><img alt="" src="fotos/nome.jpg"> </span>
	<input type="text" name="nome" value="<?php echo $valores["nome"]; ?>" placeholder="Digite seu nome" maxlength="40" class="input-xxlarge"/>
	<span><img alt="" src="fotos/sexo.jpg"> </span>
	<select name="sexo">
	<option>Informe seu sexo</option>
	<option value="f">F</option>
	<option value="m">M</option>
	</select>
	</div><br>
	<div class="control-group">
	<span><img alt="" src="fotos/cidade.jpg"> </span>
	<input type="text" name="cidade" value="<?=$valores["cidade"]; ?>" placeholder="Digite sua cidade" maxlength="36"/>
	<span><img alt="" src="fotos/endereco.jpg"> </span>
	<input type="text" name="endereco" value="<?=$valores["endereco"]; ?>" placeholder="Digite seu endereco" maxlength="36"/>
	<span><img alt="" src="fotos/complemento.jpg"> </span>
	<input type="text" name="complemento" value="<?=$valores["complemento"]; ?>" placeholder="Complementos" maxlength="36"/>
	</div><br>
	<div class="control-group">
	<span><img alt="" src="fotos/cep.jpg"> </span>
	<input type="text" name="cep" value="<?=$valores["cep"]; ?>" id="cep" maxlength="9" size="8" onKeyPress="return digitos(event, this);" onKeyUp="Mascara('CEP',this,event);" placeholder="Digite seu cep"/>
	<span><img alt="" src="fotos/telefone.jpg"> </span>
	<input name="telefone" type="text" value="<?=$valores["telefone"];?>" id="tel" maxlength="15" size="8" onKeyPress="return digitos(event, this);" onKeyUp="Mascara('TEL',this,event);"  placeholder="Digite seu telefone">
	<span><img alt="" src="fotos/cpf.jpg"> </span>
	<input type="text" name="cpf" value="<?=$valores["cpf"];?>" id="cep" maxlength="14" size="8" onKeyPress="return digitos(event, this);" onKeyUp="Mascara('CPF',this,event);" placeholder="Digite seu cpf" />
	</div><br>
	<div class="control-group">
	<span><img alt="" src="fotos/email.jpg"> </span>
	<input type="email" name="email" value="<?=$valores["email"]; ?>" placeholder="Digite seu email" maxlength="36" class="input-xxlarge" required="required"/>
	</div><br />
	<div class="control-group">
	<?php 
	if ($nivel == 2) {
	?>
	Nivel do login (c), (1) ou (2):
	<select name="nivel_log" class="input-xxlarge">
	<option>Informe o nivel de acesso do usuario</option>
	<option value="1">1</option>
	<option value="2">2</option>
	<option value="c">c</option>
	</select>
	<br />
	<?php 
	}
	?>
	</div><br>
	<div class="control-group">
	<span><img alt="" src="fotos/user.jpg"> </span>
	<input type="text" name="login" value="<?=$valores["login"]; ?>" placeholder="Digite seu login" maxlength="36"/>
	<span><img alt="" src="fotos/senha.jpg"> </span>
	<input type="password" name="senha" placeholder="Digite seu senha" maxlength="36"/>
	<span><img alt="" src="fotos/senha.jpg"> </span>
	<input type="password" name="comfirmarSenha" placeholder="Comfirme sua senha" maxlength="36"/>
	</div><br>
	<input class="btn btn-info"  type="submit" name="alterar" value="alterar dados" />

</form>

<?php
	}
}
?>

<a href="ListaUsuarios.php"  class="btn btn-info">Cancelar AlteraÃ§Ã£o</a>

</fieldset>

</div>

</body>
</html>

<?php
}
?>