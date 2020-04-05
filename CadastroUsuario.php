<?php 
session_start();

include_once 'Model/Modelo/Usuario.php';
include_once 'Model/DAO/UsuarioDAO.php';
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
<title>Cadastrado de Usuario</title>
<?php header("Content-Type: text/html; charset=ISO-8859-1",true);?>
</head>
<body>
<script src="boot/js/bootstrap.js" type="text/javascript" ></script>
<script src="boot/js/bootstrap.min.js" type="text/javascript" ></script>
<script src="boot/js/npm.js" type="text/javascript" ></script>
<?php
if (empty($_SESSION)){
?>
	<script type="text/javascript">
	alert("Faça seu login");
	window.location="index.php";
	</script>
<?php	
} else {
	$nivel = $_SESSION['nivel_log'];
		
	if ($nivel == 2 || $nivel == 1){
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

<div class="table-responsive" align="center">

<h2>Cadastro de Usuario</h2><br>

<?php
if (!empty($_POST)){
	
	if (empty($_POST['nome']) || empty($_POST['sexo']) || empty($_POST['endereco']) || 
		empty($_POST['cidade']) || empty($_POST['complemento']) || empty($_POST['cep']) ||
		empty($_POST['telefone']) || empty($_POST['cpf']) || empty($_POST['email']) || 
		empty($_POST['login']) || empty($_POST['senha']) || empty($_POST['comfirmarSenha'])){
		
			?> <div class="alert alert-error"> <font size="3px" color="red"> Campos vazio não permitido </font> </div> <?php
		
	} else {
	
	$nivel = $_SESSION['nivel_log'];
	
	$nome = $_POST['nome'];
	//Colocar os dados em minusculo
	$nome = strtolower($nome);
	$sexo = $_POST['sexo'];
	if ($sexo === "Informe seu sexo"){
		?> <div class="alert alert-error"> <font size="3px" color="red"> Informe o sexo do cadastrado! </font> </div> <?php
	}
	$endereco = $_POST['endereco'];
	$cidade = $_POST['cidade'];
	$complemento = $_POST['complemento'];
	$cep = $_POST['cep'];
	$telefone = $_POST['telefone'];
	$cpf = $_POST['cpf'];
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
		?> <div class="alert alert-error"> <font size="3px" color="red"> CPF ou email não comferem, tente novamente! </font> </div> <?php
	}
	
	if ($nivel === "2"){
		$nivel_log = $_POST['nivel'];
		if ($nivel_log === "Informe o nivel de acesso do usuario"){
			?> <div class="alert alert-error"> <font size="3px" color="red"> Informe o nivel de acesso do usuario! </font> </div> <?php
		}
	} else {
		$nivel_log = c;
	}
	
	if ($senha !== $comfirmar_senha){
		?> <div class="alert alert-error"> <font size="3px" color="red"> A "senha" deve ser a mesma senha de "comfirme sua senha"! </font> </div> <?php
	} else {
	
		$usuarioDAO = new UsuarioDAO();
		$resultado = $usuarioDAO->ValidarCadastro($retCPF, $nome, $login, $telefone, $retEmail);
		
		if (isset($resultado)){
		
			foreach ($resultado['login'] as $usuarioDAO => $valor) {
				$forLogin = $valor['login'];
			}
		
			foreach ($resultado['nome'] as $usuarioDAO => $valor) {
				$forNome = $valor['nome'];
			}
		
			foreach ($resultado['telefone'] as $usuarioDAO => $valor) {
				$forTelefone = $valor['telefone'];
			}
		
			foreach ($resultado['cpf'] as $usuarioDAO => $valor) {
				$forCpf = $valor['cpf'];
			}
		
			foreach ($resultado['email'] as $usuarioDAO => $valor) {
				$forEmail = $valor['email'];
			}
		
		}
		
		if (!isset($forNome) && !isset($forCpf) && !isset($forLogin) &&
				!isset($forTelefone) && !isset($forEmail)){
			
			$usuario = new Usuario();
			$usuario->nome = $nome;
			$usuario->sexo = $sexo;
			$usuario->nivel_log = $nivel_log;
			$usuario->endereco = $endereco;
			$usuario->cidade = $cidade;
			$usuario->complemento = $complemento;
			$usuario->cep = $cep;
			$usuario->telefone = $telefone;
			$usuario->cpf = $retCPF;
			$usuario->email = $retEmail;
			$usuario->login = $login;
			$usuario->senha = $senha;
			$usuario->comfirmar_senha = $comfirmar_senha;
			
			$cad = new UsuarioDAO();
			$result = $cad->cadastrar($usuario);
			
				if ($result){
					?>
					<script type="text/javascript">
					alert('Usuário cadastrado com sucesso!'); window.location="PaginaInicial.php";
					</script>
					<?php
				} else {
					?> <div class="alert alert-error"> <font size="3px" color="red"> Erro ao cadastra o usuario, causa possivel <?php echo $result; ?>  </font> </div> <?php
				}
				
			} else {
				
				if (isset($forNome)) {
					?> <div class="alert alert-error">
					<font size="3px" color="red"> Usuario ja cadastrado com esse nome </font>
					</div> <?php
				}
						
				if (isset($forCpf)) {
					?> <div class="alert alert-error">
					<font size="3px" color="red"> Usuario ja cadastrado com esse cpf </font>
					</div> <?php
				}
						
				if (isset($forLogin)) {
					?> <div class="alert alert-error">
					<font size="3px" color="red"> Usuário ja cadastrado com esse login </font>
					</div> <?php
				}
						
				if (isset($forTelefone)) {
					?> <div class="alert alert-error">
					<font size="3px" color="red"> Usuário ja cadastrado com esse telefone </font>
					</div> <?php
				}
				
				if (isset($forEmail)) {
					?> <div class="alert alert-error">
					<font size="3px" color="red"> Usuário ja cadastrado com esse email </font>
					</div> <?php
				}
				
			}
			
		}

	}
	
}
?>

  <form action="" method="post" id="form" name="form">
	
	<div class="control-group">
	<span><img alt="" src="fotos/nome.jpg"> </span>
	<input type="text" name="nome" class="input-xxlarge" placeholder="Digite seu nome" maxlength="36"/>
	<span><img alt="" src="fotos/sexo.jpg"> </span>
	<select name="sexo">
	<option>Informe seu sexo</option>
	<option value="f">F</option>
	<option value="m">M</option>
	</select>
	</div><br>
	<div class="control-group">
	<span><img alt="" src="fotos/cidade.jpg"> </span>
	<input type="text" name="cidade" class="input-xlarge" placeholder="Digite sua cidade" maxlength="36"/>
	<span><img alt="" src="fotos/endereco.jpg"> </span>
	<input type="text" name="endereco" class="input-xlarge" maxlength="36" placeholder="Digite seu endereco"/>
	<span><img alt="" src="fotos/complemento.jpg"> </span>
	<input type="text" name="complemento" class="input-large" placeholder="Complementos" maxlength="15"/>
	</div><br>
	<div class="control-group">
	<span><img alt="" src="fotos/cep.jpg"> </span>
	<input type="text" name="cep" placeholder="Digite seu cep" id="cep" maxlength="9" size="8" onKeyPress="return digitos(event, this);" onKeyUp="Mascara('CEP',this,event);"/>
	<span><img alt="" src="fotos/telefone.jpg"> </span>
	<input name="telefone" type="tel" id="tel" maxlength="15" size="8" onKeyPress="return digitos(event, this);" onKeyUp="Mascara('TEL',this,event);" placeholder="Digite seu telefone" required="required">
	<span><img alt="" src="fotos/cpf.jpg"> </span>
	<input type="text" name="cpf" placeholder="Digite seu cpf" id="cpf" required="required" maxlength="14" size="8" onKeyPress="return digitos(event, this);" onKeyUp="Mascara('CPF',this,event);"/>
	</div><br>
	<div class="control-group">
	<span><img alt="" src="fotos/email.jpg"> </span>
	<input type="email" name="email" class="input-xxlarge" placeholder="Digite seu email" maxlength="36" required="required"/>
	</div><br>
	<?php 
	if ($nivel == 2) {
	?>
	<div class="control-group">
	Nivel do login (1), (2) ou (c):
	<select name="nivel" class="input-xxlarge">
	<option>Informe o nivel de acesso do usuario</option>
	<option value="1">1</option>
	<option value="2">2</option>
	<option value="c">c</option>
	</select>
	</div><br>
	<?php } ?>
	<div class="control-group">
	<span><img alt="" src="fotos/user.jpg"> </span>
	<input type="text" name="login" placeholder="Digite seu login" maxlength="36"/>
	<span><img alt="" src="fotos/senha.jpg"> </span>
	<input type="password" name="senha" placeholder="Digite sua senha" maxlength="36"/>
	<span><img alt="" src="fotos/senha.jpg"> </span>
	<input type="password" name="comfirmarSenha" placeholder="Comfirme sua senha" maxlength="36"/>
	</div><br>
	<input class="btn btn-info"  type="submit" value="Cadastrar" />

</form>

<a href="PaginaInicial.php"  class="btn btn-info">Cancelar Cadastro</a>

</div>

<?php 
} else {
	
	?>
	<script type="text/javascript">
	alert('Usuário sem permissão de fazer cadastro'); window.location="index.php";
	</script>
	<?php
	
	} 

}
?>

</body>
</html>