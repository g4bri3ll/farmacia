<!doctype html>
<html lang="pt-BR">
<head>
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
<script src="js/CheckBox.js"> </script>
<title>Pagina Inicial</title>
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

include_once 'Model/DAO/ValoresVendasDAO.php';
include_once 'Model/DAO/SituacaoCaixaDAO.php';
include_once 'Model/DAO/ProdutoDAO.php';
include_once 'Model/DAO/VendasDAO.php';
include_once 'Model/DAO/EmpresaDAO.php';


if (empty($_SESSION)){
?>
	<script type="text/javascript">
	alert("Faça seu login");
	window.location="index.php";
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

<div class="container">
	<div class="row">
		<aside class="span4 bs-docs-sidebar">
			<ul class="nav nav-list bs-docs-sidenav">
				<li><a href="PaginaInicial.php" class="btn"> <i class="icon-chevron-right"></i> HOME</a></li>
				<li><a href="AlteraSenha.php" class="btn">   <i class="icon-chevron-right"></i> ALTERAR A SENHA</a></li>
				<li><a href="Ajudar.php" class="btn">		 <i class="icon-chevron-right"></i> AJUDAR</a></li>
				<li><a href="contato.php" class="btn">				 <i class="icon-chevron-right"></i> CONTATO </a></li>
			</ul>
		</aside>
		
		<div class="span8">
<!-- Colocando imagens de icons com bootstrap e: class="icon-music" class="icon-home" class="icon-phone"-->
<section id="btn-dropdown">
<div align="center">
<?php
$nivel = $_SESSION['nivel_log'];
//print_r($nivel);
if ($nivel == 2){
?>
<header>
<h1>Controle Administrador</h1>
</header>
<br>

<select class="selectpicker span4" onchange="javascript:location.href=this.value">
   <optgroup label="Função Funcionarios">
      <option value="#">Funcionario</option>
      <option value="CadastroUsuario.php">Cadastro de Funcionario</option>
      <option value="ListaUsuarios.php">Lista Funcionario</option>
   </optgroup>
   <optgroup label="Função Fornecedor">
      <option value="#">Fornecedor</option>
      <option value="CadastroFornecedor.php">Cadastro de Fornecedor</option>
      <option value="ListaFornecedor.php">Lista Fornecedor</option>
   </optgroup>
   <optgroup label="Função Produto">
      <option value="#">Produto</option>
      <option value="CadastroProduto.php">Cadastro de Produto</option>
      <option value="ListaProduto.php">Lista Produto</option>
   </optgroup>
   <optgroup label="Função Caixa">
      <option value="#">Caixa</option>
      <option value="CadastraCaixa.php">Cadastro de Caixa</option>
      <option value="ListaUsuarioCaixa.php">Lista de Cadastro do Caixa</option>
   </optgroup>
   <optgroup label="Função de Controle">
      <option value="#">Controle</option>
      <option value="Controle.php">Controle do ADM</option>
   </optgroup>
</select>
<?php
} elseif ($nivel == 1){
?>
<header>
<h1>Controle Gerais</h1>
</header>
<br>

<select class="form-control span4" onchange="javascript:location.href=this.value">
   <optgroup label="Função Funcionarios">
      <option value="#">Funcionario</option>
      <option value="CadastroUsuario.php">Cadastro de Funcionario</option>
   </optgroup>
   <optgroup label="Função Caixa">
      <option value="#">Caixa</option>
      <option value="CadastraCaixa.php">Cadastro de Caixa</option>
   </optgroup>
</select>
<?php
}
?>


<!-- Atribuir ao usuario do caixa, para ele abrir o fechar ao acessar o sistema -->
<?php
if ($nivel === "c"){
?>
<header>
<h1>Caixa</h1>
</header>
<br>

<!-- Abrindo o caixa aparece esse aqui -->
<?php
$verificarCaixa = "Fechado";
$bool           = "Fechado";
$situacao = new SituacaoCaixaDAO();
$ab_fc = $situacao->AbertoFechado();
	foreach ($ab_fc as $situacao => $valor){
		$bool = $valor['aberto_fechado'];
		$id = $valor['id'];
	}
if ($bool === $verificarCaixa){
?>
<a href="AbrirCaixa.php" class="btn btn-info" role="button">Abrir Caixa</a><br><br>
<?php
} else {
?>
<!-- Usuario esta fechando o caixa aqui -->
<a href="FecharCaixa.php" class="btn btn-info" role="button">Fechar Caixa</a><br><br>

<!-- Essa tabela aqui, e para lista todas as vendas feitas pelo funcionarios, ela vai colocando aqui -->
<?php
	$venDAO = new VendasDAO();
	$venAbertas = $venDAO->ListaVendasAberta();
	foreach ($venAbertas as $venDAO => $val){
		$codigo = $val['codigoVenda'];
		$nome = $val['nomeComprador'];
	}
if (!empty($codigo)){
?>	
<!-- Receber o codigo escolhido para lista na tabela abaixo -->
	<a href="Caixa.php?codigo=<?php echo $codigo?>" class="btn span6">
	 <?php echo $nome; ?>
	</a>
<?php  
}
?>

<?php 
}//Fechar o else que esta verificando se o caixa esta aberto
}//fecha o if que esta verificando se o caixa esta logado no sistema
?>


			</div><!-- Fecha a div que esta centralizando -->
			</section>
		</div><!-- Fecha a div do span 8 -->
	</div><!-- Fecha a div do row -->
</div><!-- Fechar a div do container -->


<br><br>
<div class="flex-align"><!-- começa o flex -->
    <div class="container span12 text-center col-md-4 col-md-offset-3" style="margin: 0 auto;float: none;">
        <div class="row">
<!-- Nome para lista o produto na tela -->
<?php if ($nivel !== "c") {?>
<br> 
<div align="center">
<nav class="navbar navbar-default"><br>
<form action="" method="post">
<div class="control-group success">
<h2>Informe o Nome do produto</h2>
<div class="controls">
<input type="text" name="nome" id="inputSuccess" class="input-xxlarge" placeholder="Informe o nome do produto">
<span class="add-on"><i class="icon-search"></i></span>
</div>
</div>
<input type="submit" value="Verificar" class="btn btn-info btn-large">
</form>
<br></nav>
<?php }?>


<!-- Receber a pesquisar do funcionario, para lista na tela, faz uma tabela com todos os valores buscado por ele -->
<?php 
$lis = new ProdutoDAO();
//Verificar se nÃ£o houve submit
if (empty($_POST)){} 
else {
	//Verificar se esta variavel esta vazia, se tiver ela faz
	if (empty($_POST['nome'])){}
	else{
$nome = $_POST['nome'];
$listaVendas = $lis->listaPeloNome($nome);
if (!empty($listaVendas)){
?>

<!-- Esse botÃ£o pegar o codigo do produto, e vai no banco de dados e pegar todos os id do codigo referente
E excluir de um por um fazendo um while -->
<a href="PaginaInicial.php" class="btn btn-info">Cancelar Pesquisar</a><br><br>

<!-- Enviar toda a compra para a tela de  -->
<form action="Controller/ControllerEfetuarVenda.php" method="post">

<?php
if (!empty($_SESSION['codigoVenda'])){
$cod = $_SESSION['codigoVenda'];	
$venDAO = new VendasDAO();
$arrayNomeComprador = $venDAO->listaNomeComprador($cod);
	foreach ($arrayNomeComprador as $venDAO => $nomeComprador){
		$nomeComp = $nomeComprador['nomeComprador'];
	}
	if (empty($nomeComp)) {
?>
<font size="5" color="red"> Atenção: Informe o nome do Comprador </font><br>
<input type="text" name="nomeComprador" class="span6" placeholder="Informe o nome do Comprador">
<?php
	}
} else {
?>
<font size="5" color="red"> Atenção: Informe o nome do Comprador </font><br>
<input type="text" name="nomeComprador" class="span6" placeholder="Informe o nome do Comprador">
<?php }?>

<table border="1">
<tr align="center">
<td>Item</td>
<td>Nome do Produto</td>
<td>Marca do Produto</td>
<td>Valor do Produto</td>
<td>Valor Desconto</td>
<td>Qtda Produto</td>
</tr>

<?php 
foreach ($listaVendas as $lis => $valores){
?>
<tr align="center">
<td><input type="radio" name="item" value="<?php echo $valores['id'];?>"> </td>
<td><?php echo $valores['nome'];?>           </td>
<td><?php echo $valores['marca']; ?>         </td>
<td><?php echo $valores['ValorProduto']; ?>  </td>
<td><?php echo $valores['ValorDesconto']; ?> </td>
<td>
<select name="qtda">
	<option value="1">1</option>
	<option value="2">2</option>
	<option value="3">3</option>
	<option value="4">4</option>
	<option value="5">5</option>
	<option value="6">6</option>
	<option value="7">7</option>
	<option value="8">8</option>
	<option value="9">9</option>
	<option value="10">10</option>
	<option value="11">11</option>
	<option value="12">12</option>
	<option value="13">13</option>
	<option value="14">14</option>
	<option value="15">15</option>
</select>
</td>
</tr>
<?php 
}//Fechar o foreach da lista 
?>

</table> <br>

<input type="submit" value="  Envia  " class="btn btn-info">

</form>

<?php 
}//fecha o if que esta verificando se tem alguma coisa na lista 
else {
?>
	<div class="alert alert-danger" role="alert"><br>
	<p><font size="20px" color="red"> Item nao encontrado </font></p>
	</div>
	<?php 
		}
	}//fecha o else que verificar se ouver algum nome escrito para buscar e lista na tela 
}
?>

<!-- Lista para o vendedor, as compras efetuada do cliente na tela -->
<?php 
if (empty($_SESSION['codigoVenda'])){
	//Aqui receber o codigo vazio e nÃ£o faz nada
} else {
?>
<table border="1">
<tr align="center">
<td>Codigo do Produto</td>
<td>Nome do Produto</td>
<td>Marca do Produto</td>
<td>Valor do Produto</td>
<td>Valor Desconto</td>
<td>Qtda Produto</td>
<td>Excluir Item</td>
</tr>

<?php
$codigoSession = $_SESSION['codigoVenda'];
//Pegar o valor da compra para lista na tela
$lisValorDAO = new ValoresVendasDAO();
$listaValorTotal = $lisValorDAO->listaValorVendaCodigo($codigoSession);
foreach ($listaValorTotal as $lisValorDAO => $valorCompra){
	$totalCompra = $valorCompra['valor_venda'];
}
$lis = new VendasDAO();
$listaVendas = $lis->listaVendasPeloCodigo($codigoSession);
foreach ($listaVendas as $lis => $valores){
?>
<tr align="center">
<td><?php echo $valores['codBarra'];  ?> </td>
<td><?php echo $valores['nome'];      ?> </td>
<td><?php echo $valores['marca'];     ?> </td>
<td><?php echo $valores['valorProduto']; ?> </td>
<td><?php echo $valores['valorDesconto']; ?> </td>
<td><?php echo $valores['qtda'];      ?> </td>
<td><a href="ExcluirItemPesquisar.php?id=<?php echo $valores['id'];?>">
<input type="image" src="fotos/excluir.jpg"  height="35px" width="20px" name="excluirItem"></a></td>
</tr>
<?php }?>
</table> <br>
<?php if (empty($totalCompra)) {
} else {?>
<p> <font>A compra do produto esta: <?php echo $totalCompra; ?></font> </p>
<a href="FecharCompra.php" class="btn btn-info"> fechar venda </a>
<?php 
}//fecha o else que esta verificando se o campo $totalCompra esta vazio
}//fecha o if se estiver o codigo do produto na session
?>

			</div> <!-- Div que esta centralizando o conteudo do site -->
		</div><!-- Fecha o row -->
	</div><!-- Fecha o conteriner -->
</div><!-- fecha o flex align -->


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