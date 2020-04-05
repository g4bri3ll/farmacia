<?php 
session_start();

include_once 'Model/Modelo/Produto.php';
include_once 'Model/DAO/ProdutoDAO.php';
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
<title>Cadastrado de Produto</title>
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
	alert("Usuario sem permissão");
	window.location="index.php";
	</script>
<?php	
} else {
	$nivel = $_SESSION['nivel_log'];
		
	if ($nivel == 2){
?>

<script language='JavaScript' type="text/javascript">
function SomenteNumero(e){
    var tecla=(window.event)?event.keyCode:e.which;   
    if((tecla>47 && tecla<58)) return true;
    else{
    	if (tecla==8 || tecla==0) return true;
	else  return false;
    }
}
</script>

<script type="text/javascript">
// retira caracteres invalidos da string
function LimpaValor(valor, validos, tammax) {
var result = "";
var aux;
for (var i=0; i < valor.length; i++) {
	aux = validos.indexOf(valor.substring(i, i+1));
	if (aux>=0) {
		if ( result.length < tammax - 1 ) {
			result += aux;
		}
	}
}
return result;
}

function FormataValor(campo,tammax,teclapres,decimal,ptmilhar,ptdecimal) {
var tecla = teclapres.keyCode;
	vr = LimpaValor(campo.value,"0123456789",tammax);
	tam = vr.length;
	dec = decimal;
	if (tam < tammax && tecla != 8){ tam = vr.length + 1 ; }
	if (tecla == 8 ) { tam = tam - 1 ; }
	if ( tecla == 8 || tecla >= 48 && tecla <= 57 || tecla >= 96 && tecla <= 105 ) {
		if ( tam <= dec ) { campo.value = vr ; }
		else if ( (tam > dec) && (tam <= dec + 3) ){
			//alert(tam);
			campo.value = vr.substr( 0, tam - dec ) + ptdecimal + vr.substr( tam - dec, tam ) ; 
		} else if  ( (tam >= dec + 4) && (tam <= dec + 6) ){
			campo.value = vr.substr( 0, tam - 3 - dec ) + ptmilhar + vr.substr( tam - 3 - dec , 3 ) + ptdecimal + vr.substr( tam - dec , 12 ) ; 
		} else if  ( (tam >= dec + 7) && (tam <= dec + 9) ){
			campo.value = vr.substr( 0, tam - 6 - dec ) + ptmilhar + vr.substr( tam - 6 - dec , 3 ) + ptmilhar + vr.substr( tam - 3 - dec , 3 ) + ptdecimal + vr.substr( tam - dec , 12 ) ; 
		} else if  ( (tam >= dec + 10) && (tam <= dec + 12) ){
			campo.value = vr.substr( 0, tam - 9 - dec ) + ptmilhar + vr.substr( tam - 9 - dec , 3 ) + ptmilhar + vr.substr( tam - 6 - dec , 3 ) + ptmilhar + vr.substr( tam - 3 - dec , 3 ) + ptdecimal + vr.substr( tam - dec , 12 ) ; 
		} else if  ( (tam >= dec + 13) && (tam <= dec + 15) ){
			campo.value = vr.substr( 0, tam - 12 - dec ) + ptmilhar + vr.substr( tam - 12 - dec , 3 ) + ptmilhar + vr.substr( tam - 9 - dec , 3 ) + ptmilhar + vr.substr( tam - 6 - dec , 3 ) + ptmilhar + vr.substr( tam - 3 - dec , 3 ) + ptdecimal + vr.substr( tam - dec , 12 ) ; 
		} else if  ( (tam >= dec + 16) && (tam <= dec + 18) ){
			campo.value = vr.substr( 0, tam - 15 - dec ) + ptmilhar + vr.substr( tam - 15 - dec , 3 ) + ptmilhar + vr.substr( tam - 12 - dec , 3 ) + ptmilhar + vr.substr( tam - 9 - dec , 3 ) + ptmilhar + vr.substr( tam - 6 - dec , 3 ) + ptmilhar + vr.substr( tam - 3 - dec , 3 ) + ptdecimal + vr.substr( tam - dec , 12 ) ; 
		} else if  ( (tam >= dec + 19) && (tam <= dec + 21) ){
			campo.value = vr.substr( 0, tam - 18 - dec ) + ptmilhar + vr.substr( tam - 18 - dec , 3 ) + ptmilhar + vr.substr( tam - 15 - dec , 3 ) + ptmilhar + vr.substr( tam - 12 - dec , 3 ) + ptmilhar + vr.substr( tam - 9 - dec , 3 ) + ptmilhar + vr.substr( tam - 6 - dec , 3 ) + ptmilhar + vr.substr( tam - 3 - dec , 3 ) + ptdecimal + vr.substr( tam - dec , 12 ) ; 
		} else if  ( (tam >= dec + 22) && (tam <= dec + 24) ){
			campo.value = vr.substr( 0, tam - 21 - dec ) + ptmilhar + vr.substr( tam - 21 - dec , 3 ) + ptmilhar + vr.substr( tam - 18 - dec , 3 ) + ptmilhar + vr.substr( tam - 15 - dec , 3 ) + ptmilhar + vr.substr( tam - 12 - dec , 3 ) + ptmilhar + vr.substr( tam - 9 - dec , 3 ) + ptmilhar + vr.substr( tam - 6 - dec , 3 ) + ptmilhar + vr.substr( tam - 3 - dec , 3 ) + ptdecimal + vr.substr( tam - dec , 12 ) ; 
		} else {
			campo.value = vr.substr( 0, tam - 24 - dec ) + ptmilhar + vr.substr( tam - 24 - dec , 3 ) + ptmilhar + vr.substr( tam - 21 - dec , 3 ) + ptmilhar + vr.substr( tam - 18 - dec , 3 ) + ptmilhar + vr.substr( tam - 15 - dec , 3 ) + ptmilhar + vr.substr( tam - 12 - dec , 3 ) + ptmilhar + vr.substr( tam - 9 - dec , 3 ) + ptmilhar + vr.substr( tam - 6 - dec , 3 ) + ptmilhar + vr.substr( tam - 3 - dec , 3 ) + ptdecimal + vr.substr( tam - dec , 12 ) ; 
		}
	}
}

</script>

<div class="table-responsive" align="center">
<h2>Cadastro de Produto</h2><br>

<?php 
if (!empty($_POST)){
	
	if (empty($_POST['nome']) && empty($_POST['codBarra']) && empty($_POST['codigo']) &&
			empty($_POST['valorDesconto']) && empty($_POST['valorProduto']) && empty($_POST['qtda']) && 
			empty($_POST['marca'])){
				
			?> <div class="alert alert-error"> <font size="3px" color="red"> Campos vazio não permitido </font> </div> <?php
				
	} else {
	
		$nome = $_POST['nome'];
		//colocar a palavra em minusculo
		$nome = strtolower($nome);
		$codBarra = $_POST['codBarra'];
		$codigo = $_POST['codigo'];
		$valorDesconto = $_POST['valorDesconto'];
		$valorProduto = $_POST['valorProduto'];
		$qtda = $_POST['qtda'];
		$marca = $_POST['marca'];
		//colocar a palavra em minusculo
		$marca = strtolower($marca);
		
		$cad = new ProdutoDAO();
		$result = $cad->ValidarArray($nome, $codBarra);
		
		//se existir o resultado
		if (isset($result['nome'])){
			foreach ($result['nome'] as $cad => $valor){
				$resNome = $valor['nome'];
			}
		} 
		if ($result['codigo_barra']) {	
			foreach ($result['codigo_barra'] as $cad => $valor){
				$resCodBarra = $valor['CodBarra'];
			}
		}
		
		if (isset($resNome)) {
			?> <div class="alert alert-error">
				<font size="3px" color="red"> Produto ja cadastrado com esse nome! </font>
			</div> <?php
		} else if (isset($resCodBarra)) {
			?> <div class="alert alert-error">
				<font size="3px" color="red"> Codigo de barra ja cadastrado! </font>
			</div> <?php
		} else {
		
			$produto = new Produto();
			$produto->nome = $nome;
			$produto->codBarra = $codBarra;
			$produto->codigo = $codigo;
			$produto->valorDesconto = $valorDesconto;
			$produto->valorProduto = $valorProduto;
			$produto->qtda = $qtda;
			$produto->marca = $marca;
		
			$cad = new ProdutoDAO();
			$resultadoCad = $cad->cadastrarProduto($produto);
			
			if ($resultadoCad == true){
				
				?> <script type="text/javascript"> alert('Produto cadastrado com sucesso!'); window.location="PaginaInicial.php"; </script> <?php
				
			} else {
				
				?> <script type="text/javascript"> alert('Aconteceu um erro ao cadastrar o produto, tente novamente!'); </script> <?php
				
			}
			
		}
	
	}
	
}	
?>

<form action="" method="post" >
	<div class="control-group">
	<span><img alt="" src="fotos/nome.jpg"> </span>
	<input type="text" name="nome" class="input-xxlarge" placeholder="Digite o nome do produto" maxlength="50" />
	<span><img alt="" src="fotos/marca.jpg"> </span>
	<input type="text" name="marca" class="input-large" placeholder="Digite a marca do produto" maxlength="50" />
	</div><br>
	<div class="control-group">
	<span><img alt="" src="fotos/codigo_barra.png"> </span>
	<input type="text" name="codBarra" maxlength="50" placeholder="Digite o codigo de barra"/>
	<span><img alt="" src="fotos/codigo_barra.png"> </span>
	<input type="text" name="codigo" placeholder="Digite o codigo do produto" maxlength="40"/>
	</div><br>
	<div class="control-group">
	<span><img alt="" src="fotos/dinheiro.jpg"> </span>
	<input type="text" name="valorDesconto" onkeypress='return SomenteNumero(event)' placeholder="Digite o valor do desconto" maxlength="10" onkeydown="FormataValor(this,28,event,2,'.',',');"/>
	<span><img alt="" src="fotos/dinheiro.jpg"> </span>
	<input type="text" name="valorProduto" onkeypress='return SomenteNumero(event)' placeholder="Digite o valor do produto" maxlength="10" onkeydown="FormataValor(this,28,event,2,'.',',');"/>
	<span><img alt="" src="fotos/qtda.jpg"> </span>
	<input type="text" name="qtda" class="input-large" onkeypress='return SomenteNumero(event)' placeholder="Digite a quantidade do produto" maxlength="10" />
	</div><br>
	<input class="btn btn-info" type="submit" value="Cadastrar" />
</form>

<a href="PaginaInicial.php"  class="btn btn-info">Cancelar Cadastro</a>

</div>

<?php 
} else {
header("Location: PaginaInicial.php"); 
} }
?>

</body>
</html>