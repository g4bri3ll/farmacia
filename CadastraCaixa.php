<?php 
session_start();

include_once 'Model/DAO/UsuarioDAO.php';
include_once 'Model/Modelo/AbrirCaixa.php';
include_once 'Model/DAO/AbrirCaixaDAO.php';
include_once 'Validacoes/gera-senhas.php';
include_once 'Validacoes/valida-cpf.php';
include_once 'Validacoes/valida-email.php';
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
<title>Cadastrado de Caixa</title>
<?php header("Content-Type: text/html; charset=ISO-8859-1",true);?>
</head>
<body>
<script src="boot/js/bootstrap.js" type="text/javascript" ></script>
<script src="boot/js/bootstrap.min.js" type="text/javascript" ></script>
<script src="boot/js/npm.js" type="text/javascript" ></script>
<div align="center">
<?php
if (empty($_SESSION)){
	?> <div class="alert alert-error">
		<font size="3px" color="red"> <a href="index.php"> Voltar a index </a> </font>
	</div> <?php
} else {
	$nivel = $_SESSION['nivel_log'];
	if ($nivel === "2" || $nivel === "1"){
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

<?php 
//Codigo para abrir o caixa
$novoCodigo = geraSenha(4, true, true, true);
if (!empty($_POST)){
	
	if (empty($_POST['nome']) || empty($_POST['cpf']) && 
		empty($_POST['email']) || empty($_POST['codigoAbrircaixa'])){
			?> <div class="alert alert-error">
				<font size="3px" color="red"> Campos vazio não permitido! </font>
			</div> <?php
	} else {
	
		$nome = $_POST['nome'];
		//Colocar os dados em minusculo
		$nome = strtolower($nome);
		$recCpf = $_POST['cpf'];
		$recEmail = $_POST['email'];
		//Colocar os dados em minusculo
		$recEmail = strtolower($recEmail);
		$codigoAbrircaixa = $_POST['codigoAbrircaixa'];
	
		$cpf = valida_cpf($recCpf);
		$email = verificar_email($recEmail);
		
		//Tira o ponto do cpf
		$cpf = preg_replace('#[^0-9]#', '', $cpf);
		
		if (!$cpf || !$email){
			?><script type="text/javascript">
				alert('CPF ou email não e valido, tente novamente!'); window.location="CadastraCaixa.php";
			</script><?php
		}
		
		//Verificar se existe o usuario ja no sistema cadastrado
 		$usuDAO = new UsuarioDAO();
 		$resultVerifica = $usuDAO->VerificaDadosCadastrado($email, $cpf, $nome);
 		//Verifica se o array esta vazio ou não
		$vN = count($resultVerifica['nome']);
		$vE = count($resultVerifica['email']);
		$vC = count($resultVerifica['cpf']);
		
		//Se existir
		if ($vN > 0){
			foreach ($resultVerifica['nome'] as $usuDAO => $valor){
				$id = $valor['id'];
			}
		} else if ($vE > 0) {
			foreach ($resultVerifica['email'] as $usuDAO => $valor){
				$id = $valor['id'];
			}
		} else if ($vC > 0) {
			foreach ($resultVerifica['cpf'] as $usuDAO => $valor){
				$id = $valor['id'];
			}
		}
		
		if ($vN === 0){
			?><script type="text/javascript">
  				if (confirm("Usuario não cadastrado no sistema, deseja cadastra-lo!")) {
  					window.location="CadastroUsuario.php"
  				} else { window.location="CadastraCaixa.php" }
			</script><?php
 		} else if ($vE === 0){
			?><script type="text/javascript">
  				if (confirm("Usuario não cadastrado no sistema, deseja cadastra-lo!")) {
  					window.location="CadastroUsuario.php"
  				} else { window.location="CadastraCaixa.php" }
			</script><?php
 		} else if ($vC === 0){
			?><script type="text/javascript">
  				if (confirm("Usuario não cadastrado no sistema, deseja cadastra-lo!")) {
  					window.location="CadastroUsuario.php"
  				} else { window.location="CadastraCaixa.php" }
			</script><?php
 		} else {
			
			$caiDAO = new AbrirCaixaDAO();
			//Verificar se os dados ja existe no banco de dados
			$verificar = $caiDAO->VerificarDados($cpf, $email, $nome, $codigoAbrircaixa);
			$vCC = $verificar['cpf'];
			$vCE = $verificar['email'];
			$vCN = $verificar['nome'];
			$VCCO = $verificar['codigo'];
			
			if ($vCC > 0) {
				foreach ($verificar['cpf'] as $caiDAO => $valor){
					$forCpf = $valor['cpf'];
				}
			}
			if ($vCE > 0) {
				foreach ($verificar['email'] as $caiDAO => $valor){
					$forEmail = $valor['email'];
				}
			}
			if ($vCN > 0) {
				foreach ($verificar['nome'] as $caiDAO => $valor){
					$forNome = $valor['nome'];
				}
			}
			if ($VCCO > 0) {
				foreach ($verificar['codigo'] as $caiDAO => $valor){
					$forCodigoCaixa = $valor['codigoAbrircaixa'];
				}
			}
			
			if (!isset($forCpf) && !isset($forEmail) || !isset($forNome) && !isset($forCodigoCaixa)){
			
				$abrirCaixa = new AbrirCaixa();
				$abrirCaixa->codigoAbrircaixa = $codigoAbrircaixa;
				$abrirCaixa->nome = $nome;
				$abrirCaixa->cpf = $cpf;
				$abrirCaixa->email = $email;
				$abrirCaixa->idUsuario = $id;
			
				$cad = new AbrirCaixaDAO();
				$resultCad = $cad->cadastrar($abrirCaixa);
				
				if ($resultCad) {
				?><script type="text/javascript">
					alert('Caixa cadastrado com sucesso!'); window.location="PaginaInicial.php";
				</script><?php
				} else {
				?><script type="text/javascript">
					alert('Ocorreu um erro ao cadastrar o caixa, pode esta duplicado!'); window.location="CadastraCaixa.php";
				</script><?php
				}
			} else {
				
				if (isset($forNome)) {
					?> <div class="alert alert-error">
					<font size="3px" color="red"> Caixa ja cadastrado com esse nome </font>
					</div> <?php
				}
						
				if (isset($forCpf)) {
					?> <div class="alert alert-error">
					<font size="3px" color="red"> Caixa ja cadastrado com esse cpf </font>
					</div> <?php
				}
						
				if (isset($forCodigoCaixa)) {
					?> <div class="alert alert-error">
					<font size="3px" color="red"> Caixa ja cadastrado com esse codigo </font>
					</div> <?php
				}
				
				if (isset($forEmail)) {
					?> <div class="alert alert-error">
					<font size="3px" color="red"> Caixa ja cadastrado com esse email </font>
					</div> <?php
				}
					
			}
			
		}
		
	}
	
}
?>

<h2>Cadastro de funcionario para acessar o caixa</h2>

<form action="" method="post">
Codigo Para Abrir o Caixa: 
<input type="text" name="codigoAbrircaixa" value="<?php echo $novoCodigo; ?>" readonly>
<br /><br />
<span><img alt="" src="fotos/nome.jpg"> </span>
<input type="text" name="nome" class="span8" placeholder="Digite seu nome"/>
<br /><br />
<span><img alt="" src="fotos/cpf.jpg"> </span>
<input type="text" name="cpf" id="cep" maxlength="14" size="8" onKeyPress="return digitos(event, this);" onKeyUp="Mascara('CPF',this,event);" placeholder="Digite seu cpf" />
<br /><br />
<span><img alt="" src="fotos/email.jpg"> </span>
<input type="email" name="email" class="span8" placeholder="Digite seu email" maxlength="50" required="required"/>
<br /><br />
<input class="btn btn-info span4" type="submit" value="Cadastrar" />

</form>

<a href="PaginaInicial.php"  class="btn btn-info">Cancelar Cadastro</a>

</div>

<?php 
} else {
?>
<script type="text/javascript">
alert("Usuário sem privilegio para acessar essa pagina");
window.location="PaginaInicial.php";
</script>
<?php 
} }
?>

</body>
</html>