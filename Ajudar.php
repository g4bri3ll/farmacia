<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="CSS/style.css" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="CSS/bootstrap.min.css">
  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
</head>
<?php header("Content-Type: text/html; charset=ISO-8859-1",true);?>
<body>

<div class="container">
<h2>Pagina de Ajudar ao Usuario do Site</h2>

<a href="PaginaInicial.php" data-role="button">Retorna a Pagina Inicial</a>

  <div class="panel-group" id="accordion">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">Sobre a Pagina Inicial</a>
        </h4>
      </div>
      <div id="collapse1" class="panel-collapse collapse in">
        <div class="panel-body"><ul data-role="listview" data-inset="true" data-filter="true">
			<li data-role="list-divider">Bot�o POWER</li>
			<li><p> Esse bot�o sair do sistema, ele fica localizado do lado direito da tela no canto superior</p></li>
			<li data-role="list-divider">Bot�o HOME</li>
			<li><p> Esse bot�o ele dar um refresh no site, voltando para ele mesmo</p></li>
			<li data-role="list-divider">Bot�o AJUDAR</li>
			<li><p> Esse bot�o ele redirecionar para a pagina onde esta, contendo toda a informa��o do site</p></li>
			<li data-role="list-divider">Bot�o ALTERAR A SENHA</li>
			<li><p> Esse bot�o ele ecncaminhar o usuario logado no sistema para fazer a troca da senha cadastrada no site</p></li>
			<li data-role="list-divider">Bot�o CONTATO</li>
			<li><p> Esse bot�o ele leva para a pagina de contato do site, contato com o pessoal da loja, endere�o, cep, e mais</p></li>
			<li data-role="list-divider">campo de Informe o nome do produto</li>
			<li><p> Esse campo faz uma buscar no banco de dados para ver se tem algum produto cadastrado referente ao usuario que 
			escreveu o nome, se tiver o nome do produto cadastrado ele retorna, se n�o ele escrever uma mensagem de de error
			falando que n�o encontrou nenhum produto no banco de dados</p></li>
			</ul>
		</div>
      </div>
    </div>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">Sobre a Pagina Abrir Caixa</a>
        </h4>
      </div>
      <div id="collapse2" class="panel-collapse collapse">
        <div class="panel-body"><p> A pagina abrir e onde o usuario colocara a sua senha do caixa que foi cadastrado para a sua fun��o</p></div>
      </div>
    </div>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">Sobre a Pagina Alterar a Senha</a>
        </h4>
      </div>
      <div id="collapse3" class="panel-collapse collapse">
        <div class="panel-body"><p> Essa pagina voc� pode alterar a senha, a parte de reset ele limpa todos os campos
e parte de retorna ao site ele voltar a index, e o botton de troca a senha, e onde
validar os campos para verificar se e voce mesmo que esta querendo troca a senha</p></div>
      </div>
    </div>
        <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse4">Sobre a Pagina Contato</a>
        </h4>
      </div>
      <div id="collapse2" class="panel-collapse collapse">
        <div class="panel-body"><p> A pagina onde esta os dados da empresa para pode entrar em contato se quiser. </p></div>
      </div>
    </div>
        <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse5">Sobre a Pagina Cadastro de Usuario</a>
        </h4>
      </div>
      <div id="collapse2" class="panel-collapse collapse">
        <div class="panel-body"><p> A pagina abrir e onde o usuario colocara a sua senha do caixa que foi cadastrado para a sua fun��o</p></div>
      </div>
    </div>
        <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse6">Sobre a Pagina Fornecedor</a>
        </h4>
      </div>
      <div id="collapse2" class="panel-collapse collapse">
        <div class="panel-body"><p> Onde o dono da loja vai cadastrar todos os seus Fornecedores </p></div>
      </div>
    </div>
        <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse7">Abrir Caixa</a>
        </h4>
      </div>
      <div id="collapse2" class="panel-collapse collapse">
        <div class="panel-body"><p> Lista todos os seus fornecedores cadastrado no sistema, para vender remedios </p></div>
      </div>
    </div>
    
  </div> 
</div>
    
</body>
</html>