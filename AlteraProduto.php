<?php 
session_start();

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
<title>Alteração de Produto</title>
<?php header("Content-Type: text/html; charset=ISO-8859-1",true);?>
</head>
<body>
<script src="boot/js/bootstrap.js" type="text/javascript" ></script>
<script src="boot/js/bootstrap.min.js" type="text/javascript" ></script>
<script src="boot/js/npm.js" type="text/javascript" ></script>

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

<div align="center">
<fieldset> <legend>Alterar dados do produto</legend>
<?php 
if (empty($_POST)) {
	if (empty($_GET['id']) || empty($_POST['nome']) || empty($_POST['marca']) || empty($_POST['codBarra']) || 
		empty($_POST['codigo']) || empty($_POST['valorDesconto']) || empty($_POST['valorProduto']) || empty($_POST['qtda'])) { 
		
			?> <div class="alert alert-error"> <font size="3px" color="red"> Campos vazio não permitido </font>	</div> <?php
			
	} else {

		$id = $_GET['id'];
		$nome = $_POST['nome'];
		//colocar a palavra em minusculo
		$nome = strtolower($nome);
		$marca = $_POST['marca'];
		//colocar a palavra em minusculo
		$marca = strtolower($marca);
		$codBarra = $_POST['codBarra'];
		$codigo = $_POST['codigo'];
		$valorDesconto = $_POST['valorDesconto'];
		$valorProduto = $_POST['valorProduto'];
		$qtda = $_POST['qtda'];
			
		$produto = new Produto();
		$produto->id = $id;
		$produto->nome = $nome;
		$produto->codBarra = $codBarra;
		$produto->codigo = $codigo;
		$produto->valorDesconto = $valorDesconto;
		$produto->valorProduto = $valorProduto;
		$produto->qtda = $qtda;
		$produto->marca = $marca;
		
		$cad = new ProdutoDAO();
		//print_r($produto);
		$result = $cad->alterarProduto($produto);
		
		if ($result){
			?> <script type="text/javascript"> alert('Produto alterado com sucesso!'); window.location="PaginaInicial.php"; </script> <?php
		} else {
			?> <script type="text/javascript"> alert('Aconteceu um erro ao alterar o produto, tente novamente!'); </script> <?php
		}
		
	}
}
?>

<?php
if (empty($_SESSION)){
	?> <script type="text/javascript"> alert("Usuario não logado no sistema"); window.location="index.php"; </script> <?php
} else {
	$nivel = $_SESSION['nivel_log'];
	if ($nivel === "2"){
		$id = $_GET['id'];
		$proDAO = new ProdutoDAO();
		$array = $proDAO->listaProdutoPeloId($id);
		foreach ($array as $proDAO => $linha){
?>
<form method="post" action="Controller/ControllerAlterarProduto.php?id=<?=$linha["id"] ?>" >
	<div class="control-group">
	<span><img alt="" src="fotos/nome.jpg"> </span>
	<input type="text" name="nome" value="<?=$linha["nome"] ?>" placeholder="Digite o nome" maxlength="50" class="span8"/>
	<span><img alt="" src="fotos/marca.jpg"> </span>
	<input type="text" name="marca" value="<?=$linha["marca"] ?>" placeholder="Digite a marca" maxlength="50" />
	</div><br>
	<div class="control-group">
	<span><img alt="" src="fotos/codigo_barra.png"> </span>
	<input type="text" name="codBarra" value="<?=$linha["CodBarra"] ?>" maxlength="50" placeholder="Digite o codigo de barra"/>
	<span><img alt="" src="fotos/codigo_barra.png"> </span>
	<input type="text" name="codigo" value="<?=$linha["Codigo"] ?>" placeholder="Digite o codigo do produto" maxlength="50"/>
	</div><br>
	<div class="control-group">
	<span><img alt="" src="fotos/dinheiro.jpg"> </span>
	<input type="text" name="valorDesconto" value="<?=$linha["ValorDesconto"] ?>" placeholder="Digite o valor com desconto" maxlength="10" onkeypress='return SomenteNumero(event)' onkeydown="FormataValor(this,28,event,2,'.',',');"/>
	<span><img alt="" src="fotos/dinheiro.jpg"> </span>
	<input type="text" name="valorProduto" value="<?=$linha["ValorProduto"] ?>" placeholder="Digite o valor do produto" maxlength="10" onkeypress='return SomenteNumero(event)' onkeydown="FormataValor(this,28,event,2,'.',',');"/>
	<span><img alt="" src="fotos/qtda.jpg"> </span>
	<input type="text" name="qtda" value="<?=$linha["qtda"] ?>" placeholder="Digite a quantidade" maxlength="10" onkeypress='return SomenteNumero(event)'/>
	</div><br><br />
	<input class="btn btn-info"  type="submit" value="alterar dados" />
</form>

<?php } ?>

<a href="ListaProduto.php"  class="btn btn-info">Cancelar Cadastro</a>

<?php } } ?>

</fieldset>
</div>

</body>
</html>