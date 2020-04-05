<?php
session_start();

include_once 'Model/Modelo/Fornecedor.php';
include_once 'Model/DAO/FornecedorDAO.php';
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
<title>Altera��o de Fornecedor</title>
<?php header("Content-Type: text/html; charset=ISO-8859-1",true);?>
</head>
<body>
<script src="boot/js/bootstrap.js" type="text/javascript" ></script>
<script src="boot/js/bootstrap.min.js" type="text/javascript" ></script>
<script src="boot/js/npm.js" type="text/javascript" ></script>

<?php
if (empty($_SESSION)){
?> <script type="text/javascript"> alert ("Usuario n�o logado no sistema!"); window.location="index.php"; </script> <?php
} else {
?>

<script type="text/javascript">
//--->Fun��o para a formata��o dos campos...<---
function Mascara(tipo, campo, teclaPress) {
	if (window.event)
	{
		var tecla = teclaPress.keyCode;
	} else {
		tecla = teclaPress.which;
	}
 
	var s = new String(campo.value);
	// Remove todos os caracteres � seguir: ( ) / - . e espa�o, para tratar a string denovo.
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
 
		case 'CNPJ' :
 
			if (tam > 2 && tam < 6)
				campo.value = s.substr(0,2) + '.' + s.substr(2, tam);
			if (tam >= 6 && tam < 9)
				campo.value = s.substr(0,2) + '.' + s.substr(2,3) + '.' + s.substr(5,tam-5);
			if (tam >= 9 && tam < 13)
				campo.value = s.substr(0,2) + '.' + s.substr(2,3) + '.' + s.substr(5,3) + '/' + s.substr(8,tam-8);
			if (tam >= 13 && tam < 15)
				campo.value = s.substr(0,2) + '.' + s.substr(2,3) + '.' + s.substr(5,3) + '/' + s.substr(8,4)+ '-' + s.substr(12,tam-12);
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

//--->Fun��o para verificar se o valor digitado � n�mero...<---
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
if (!empty($_POST)){
	
	if (empty($_GET['id']) || empty($_POST['nome']) || empty($_POST['sexo']) || empty($_POST['endereco']) || 
		empty($_POST['cidade']) || empty($_POST['cep']) || empty($_POST['telefone']) || empty($_POST['cnpj']) || 
			empty($_POST['email'])){
		
			?> <div class="alert alert-error"> <font size="3px" color="red"> Campos vazio n�o permitido </font>	</div> <?php
			
	} else {
		
		$id = $_GET['id'];
		$nome = $_POST['nome'];
		//colocar a palavra em minusculo
		$nome = strtolower($nome);
		$endereco = $_POST['endereco'];
		//colocar a palavra em minusculo
		$endereco = strtolower($endereco);
		$cidade = $_POST['cidade'];
		//colocar a palavra em minusculo
		$cidade = strtolower($cidade);
		$cep = $_POST['cep'];
		$telefone = $_POST['telefone'];
		$cnpj = $_POST['cnpj'];
		$email = $_POST['email'];
		//colocar a palavra em minusculo
		$email = strtolower($email);
		$sexo = $_POST['sexo'];
		if ($sexo === "Informe seu sexo"){
			?> <script type="text/javascript"> alert('Seleciona o sexo!'); window.location="AlteraFornecedor.php?id=<?php echo $id; ?>"</script> <?php
		} else {
		
			//Tira o ponto do cep
			$cep = preg_replace('#[^0-9]#', '', $cep);
			//Tira o ponto do telefone
			$telefone = preg_replace('#[^0-9]#', '', $telefone);
			//Tira o ponto do cnpj
			$cnpj = preg_replace('#[^0-9]#', '', $cnpj);
			
			$retEmail = verificar_email($email);
			//Classe que verifica se o cnpj existe mesmo
			//$retCnpj = validar_cnpj($cnpj);
			
			if (!$retEmail){
				?><script type="text/javascript">
						alert('CNPJ ou email n�o comferem, tente novamente!'); window.location="AlteraFornecedor.php?id="<?php echo $id; ?>
				</script> <?php
			}
			
			$fornecedor = new Fornecedor();
			$fornecedor->id = $id;
			$fornecedor->nome = $nome;
			$fornecedor->sexo = $sexo;
			$fornecedor->endereco = $endereco;
			$fornecedor->cidade = $cidade;
			$fornecedor->cep = $cep;
			$fornecedor->telefone = $telefone;
			$fornecedor->cnpj = $cnpj;
			$fornecedor->email = $retEmail;
			
			$cad = new FornecedorDAO();
			$resultCad = $cad->alterarFornecedor($fornecedor);
		
			if ($resultCad){
				?><script type="text/javascript">
					alert('Fornecedor alterado com sucesso!'); window.location="PaginaInicial.php";
				</script> <?php
			} else {
				?><script type="text/javascript">
					alert('Ocorreu um erro ao alterar o fornecedor, pode esta duplicador!'); </script> <?php
				echo $resultCad;
			}
				 		
		}
		
	}
	
}
?>

<fieldset>
<legend>Alterar Fornecedor</legend>

<?php
$id = $_GET['id'];
$forDAO = new FornecedorDAO();
$array = $forDAO->listaPeloIdParaAltera($id);
foreach ($array as $forDAO => $linha){
?>

<form method="post" action="AlteraFornecedor.php?id=<?=$linha["id"] ?>" >

	<div class="control-group">
	<span><img alt="" src="fotos/nome.jpg"> </span>
	<input type="text" name="nome" value="<?=$linha["nome"] ?>" class="input-xxlarge" placeholder="Digite seu nome" maxlength="40"/>
	<span><img alt="" src="fotos/sexo.jpg"> </span>
	<select name="sexo">
	<option>Informe seu sexo</option>
	<option value="f">F</option>
	<option value="m">M</option>
	</select>
	</div><br>
	<div class="control-group">
	<span><img alt="" src="fotos/cidade.jpg"> </span>
	<input type="text" name="cidade" class="input-xlarge" value="<?=$linha["cidade"] ?>" placeholder="Digite sua cidade" maxlength="36"/>
	<span><img alt="" src="fotos/endereco.jpg"> </span>
	<input type="text" name="endereco" class="input-xlarge" value="<?=$linha["endereco"] ?>" placeholder="Digite seu endereco" maxlength="36"/>
	</div><br>
	<div class="control-group">
	<span><img alt="" src="fotos/cep.jpg"> </span>
	<input type="text" name="cep" value="<?=$linha["cep"] ?>" placeholder="Digite seu cep" id="cep" maxlength="9" size="8" onKeyPress="return digitos(event, this);" onKeyUp="Mascara('CEP',this,event);"/>
	<span><img alt="" src="fotos/telefone.jpg"> </span>
	<input name="telefone" type="text" value="<?=$linha["telefone"] ?>" id="tel" maxlength="15" size="8" onKeyPress="return digitos(event, this);" onKeyUp="Mascara('TEL',this,event);" placeholder="Digite seu telefone">
	<span><img alt="" src="fotos/cnpj.jpg"> </span>
	<input type="text" name="cnpj" value="<?=$linha["cnpj"] ?>" placeholder="Digite o cnpj" id="cnpj" maxlength="18" size="8" onKeyPress="return digitos(event, this);" onKeyUp="Mascara('CNPJ',this,event);"/>
	</div><br>
	<div class="control-group">
	<span><img alt="" src="fotos/email.jpg"> </span>
	<input type="email" name="email" class="input-xxlarge" value="<?=$linha["email"] ?>" placeholder="Digite seu email" maxlength="36" required="required"/>
	</div><br />
	<input class="btn btn-info"  type="submit" value="alterar dados" />

</form>

<?php } ?>

<a href="ListaFornecedor.php" class="btn btn-info">Cancelar Altera��o</a>

</fieldset>

</div>

<?php } ?>

</body>
</html>