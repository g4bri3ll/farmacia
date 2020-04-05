<?php 
include_once 'Validacoes/valida-cpf.php';
include_once 'Validacoes/valida-email.php';
include_once 'Model/DAO/UsuarioDAO.php';
include_once 'Model/Modelo/Usuario.php';
include_once 'PHPMailer/PHPMailerAutoload.php';
include_once 'Validacoes/gera-senhas.php';
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
<title>Altera Senha</title>
<?php header("Content-Type: text/html; charset=ISO-8859-1",true);?>
</head>
<body>
<script src="boot/js/bootstrap.js" type="text/javascript" ></script>
<script src="boot/js/bootstrap.min.js" type="text/javascript" ></script>
<script src="boot/js/npm.js" type="text/javascript" ></script>

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

<nav class="navbar navbar-default">
	<div class="container-fluid">
		<div class="navbar-header">
			<div align="center"> 
<?php
if (!empty($_POST)) {
?> <br><br>	<?php
	if (empty($_POST['cpfRecupera']) || empty($_POST['emailRecupera'])){
		?> <div class="alert alert-error"> <font size="3px" color="red"> Campos vazio n�o permitido </font> </div> <?php
	} else {

		$cpfPost = $_POST ['cpfRecupera'];
		$email = $_POST ['emailRecupera'];
		
		$retCPF = valida_cpf($cpfPost);
		$retEmail = verificar_email($email);
		
		//Tira o ponto do cpf
		$retCPF = preg_replace('#[^0-9]#', '', $retCPF);
		
		if (!$retCPF || !$retEmail){
			?> <div class="alert alert-error"> <font size="3px" color="red"> CPF ou email n�o comferem, tente novamente! </font> </div> <?php
		} else {
		
		$usuDAO = new UsuarioDAO ();
		$array = $usuDAO->listaPeloEmailECpf($retCPF, $email);

		if(empty($array)){
			?> <div class="alert alert-error"> <font size="3px" color="red"> Email e CPF n�o achados, Coloque um CPF e Email ja cadastrado no sistema! </font> </div> <?php
		} else {
				
			foreach ($array as $usuDAO => $valores){
				$forNome = $valores['nome'];
				$forEmail = $valores['email'];
				$forCpf = $valores['cpf'];
			}
				$mail = new PHPMailer();
				$mail->setLanguage('pt');

				//Utilizando o host do gmail para enviou de email
				$host              = 'smtp.gmail.com';

				//Utilizando o hotmail para encio de email
				//$host              = 'smtp.live.com';
				$username   = 'gabrieldonascimentoborges@gmail.com';
				$password    = 'gostomuitodevoce';
				//Altere a porta para 587 e a conexão para ssl
				//465 porta do gmail e essa
				$port               = 465;
				$secure           = 'tls';

				$from             = $username;
				$fromName ='Gabriel do Nascimento';

				$mail= new PHPMailer;
				$mail->isSMTP(); // Define que a mensagem será SMTP
				$mail->Host                       = $host; // Endereço do servidor SMTP
				$mail->SMTPAuth           = true;
				$mail->Username            = $username;
				$mail->Password             = $password;
				$mail->Port                        = $port;
				$mail->SMTPSecure        = $secure;

				$mail->From                      = $from;
				$mail->Fromname           = $fromName;
				$mail->addReplyTo($from, $fromName);

				//quem vai receber o email, e o nome da pessoa que tiver recebendo o email
				$mail->addAddress($forEmail,  $forNome);

				$mail->isHTML(true);
				$mail->CharSet = 'utf-8';
				$mail->WordWrap = 70;

				//Configurando a mensagem
				$mail->Subject = "Enviando email com php mailer";
				//Gera uma nova senha
				$novaSenha = geraSenha(10, true, true, true);
				$mail->Body = "Enviando email com <b>PHPMailler</b> pela aula da <h2> web </h2> e a sua nova senha e :".$novaSenha;
				$mail->AltBody = "Enviando email pela aula da web";

				$send = $mail->Send();

				if($send){
					?> <div class="alert alert-error"> <font size="3px" color="red"> Nova senha enviado para o email: <?php echo $forEmail; ?> </font> </div> <?php
					$senha = $novaSenha;
					$cpf = $valores['cpf'];
					$usuDAO = new UsuarioDAO();
					$result = $usuDAO->alterarSenhaEnviadaPorEmail($senha, $cpf);
					if ($result){
						?> <script type="text/javascript"> alert('Senha alterada com sucesso!'); window.location="index.php"; </script>	<?php
					} else {
						?> <script type="text/javascript"> alert('Ocorreu um erro ao alterar a senha!'); window.location="PaginaInicial.php"; </script>	<?php
					}
					
				} else {
					?> <div class="alert alert-error"> <font size="3px" color="red"> Erro ao enviar : <?php echo $mail->ErrorInfo; ?>  </font> </div> <?php
				}

			}// Se o array de de cpf e email existe. Fecha o else 

		}//Fecha o else se o email e cpf for valido
	
	}//Fecha o else se esta verificando se os campos n�o est�o vazios
	
}//Fecha o if que esta verificando se existe o $_POST
?>

			<h2>Recupere a sua senha aqui!</h2>
				<form action="" method="post">
				<div class="control-group">
					<span><img alt="" src="fotos/cpf.jpg"> </span>
					<input type="text" name="cpfRecupera" placeholder="Digite seu cpf" id="cpf" required="required" maxlength="14" size="8" onKeyPress="return digitos(event, this);" onKeyUp="Mascara('CPF',this,event);"/>
		        </div>
		        <div class="control-group">
					<span><img alt="" src="fotos/email.jpg"> </span>
					<input type="email" name="emailRecupera" class="span6" placeholder="Informe seu Email Cadastrado" maxlength="36" required="required"/>
		        </div>
		        <input type="submit" value="Recuperar Senha" class="btn btn-info span3" />
		        <input type="reset" value="limpa" class="btn btn-info span2" />
				</form>
			</div>
		</div>
	</div>
</nav>

<div align="center"> <a href="index.php" class="btn btn-link">Voltar ao Login</a> </div>

</body>
</html>