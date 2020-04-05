<?php

include_once 'Conexao/Conexao.php';

class UsuarioDAO {

	private $conn = null;
	
	public function cadastrar(Usuario $usuario) {
		
			try {
				
				$senha = md5 ( $usuario->senha );
				$comfirmar_senha = md5 ( $usuario->comfirmar_senha );
				
				$sql = "INSERT INTO usuario (nome, endereco, cidade, complemento, login, senha, comfirmar_senha, email, nivel_log, sexo, cep, cpf, telefone) 
				VALUES ('" . $usuario->nome . "', '" . $usuario->endereco . "', '" . $usuario->cidade . "', '" . $usuario->complemento . "', '" . $usuario->login . "', 
						'" . $senha . "', '" . $comfirmar_senha . "', '" . $usuario->email . "','" . $usuario->nivel_log . "','" . $usuario->sexo . "',
								'" . $usuario->cep . "','" . $usuario->cpf . "', '" . $usuario->telefone . "')";
				
				$conn = new Conexao ();
				$conn->openConnect ();
				
				$mydb = mysqli_select_db ( $conn->getCon (), $conn->getBD());
				$resultado = mysqli_query ( $conn->getCon (), $sql );
				
				$conn->closeConnect ();
								
				return true;
				
			} catch ( PDOException $e ) {
				
				echo $e->getMessage();
				return false;
								
			}
			
	}

	//alterar os dados do usuario
	public function alterar(Usuario $usu) {
		$senha = md5 ( $usu->senha );
		$comfirmar_senha = md5 ( $usu->comfirmar_senha );
		
		try {
			
			$sql = "UPDATE usuario SET nome='" . $usu->nome . "', endereco='" . $usu->endereco . "', cidade='" . $usu->cidade . "', 
					complemento='" . $usu->complemento . "', login='" . $usu->login . "', senha='" . $senha . "', 
					comfirmar_senha='" . $comfirmar_senha . "', email='" . $usu->email . "', nivel_log='" . $usu->nivel_log . "', 
					sexo='" . $usu->sexo . "', cep='" . $usu->cep . "', cpf='" . $usu->cpf . "', telefone='" . $usu->telefone . "' WHERE id = '" . $usu->id . "'";
			
			$conn = new Conexao ();
			$conn->openConnect ();
			
			mysqli_select_db ( $conn->getCon (), $conn->getBD());
			$resultado = mysqli_query ( $conn->getCon (), $sql );
			
			$conn->closeConnect ();
			
			return true;
			
		} catch (PDOException $e) {
			
			return false; 
			
		}
		
	}
	//altera a senha do usuario que foi para o email dele
		public function alterarSenhaEnviadaPorEmail($senha, $cpf) {
		$senha = md5 ( $senha );
		$comfirmar_senha = md5 ( $senha );
		
		$sql = "UPDATE usuario SET senha='" . $senha . "',  comfirmar_senha='" . $comfirmar_senha . "' WHERE cpf = '" . $cpf . "'";
		
		$conn = new Conexao ();
		$conn->openConnect ();
		
		mysqli_select_db ( $conn->getCon (), $conn->getBD());
		$resultado = mysqli_query ( $conn->getCon (), $sql );
		
		$conn->closeConnect ();
		
		return true;
		
	}

	//Alterar a senha do usuario selecionada por ele logado
	public function alterarSenhas(Usuario $usu) {
		
		$senha = md5 ( $usu->senhaAtual );
		$comfirmar_senha = md5 ( $usu->comfirmar_senha );
	
		$sql = "UPDATE usuario SET senha='" . $senha . "', comfirmar_senha='" . $comfirmar_senha . "' 
				WHERE senha = '" . md5($usu->senhaVelha) . "'";
	
		$conn = new Conexao ();
		$conn->openConnect ();
	
		mysqli_select_db ( $conn->getCon (), $conn->getBD());
		$resultado = mysqli_query ( $conn->getCon (), $sql );
	
		$conn->closeConnect ();
	
		return true;
	
	}
	
	//deleta pelo id selecionado
	public function deleteId($id) {

		try {
		
			$sql = "DELETE FROM usuario WHERE id = '" . $id . "'";
			
			$conn = new Conexao ();
			$conn->openConnect ();
			
			mysqli_select_db ( $conn->getCon (), $conn->getBD());
			$resultado = mysqli_query ( $conn->getCon (), $sql );
			
			$conn->closeConnect ();
			
			return true;
			
		} catch (PDOException $e){
			return false;
		}
		
	}
	
	//Retorna a lista como todos os usuarios menos a senha e a comfirmar de senha
	public function listaUsuario(){
		
		$sql = sprintf("SELECT nome, endereco, cidade, complemento, login, email, nivel_log, sexo, cep, cpf, telefone,id FROM usuario ORDER BY id DESC");

		$conn = new Conexao();
		$conn->openConnect();
		
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultado = mysqli_query($conn->getCon(), $sql);
		
		//$list = mysqli_fetch_assoc($resultado);

		$arrayUsuarios = array();
		
		while ($row = mysqli_fetch_assoc($resultado)) {
			$arrayUsuarios[]=$row;
		}
		
		$conn->closeConnect ();
		return $arrayUsuarios;
		
	}
	
	//Retorna a para o cadastro se o cpf, nome, login, telefone, $email
	public function ValidarCadastro($cpf, $nome, $login, $telefone, $email){
	
		$sqlNome = "SELECT nome FROM usuario     WHERE nome     LIKE '".$nome."'";
		$sqlLogin = "SELECT login FROM usuario    WHERE login    LIKE '".$login."'";
		$sqlEmail = "SELECT email FROM usuario    WHERE email    LIKE '".$email."'";
		$sqlTelefone = "SELECT telefone FROM usuario WHERE telefone LIKE '".$telefone."'";
		$sqlCpf = "SELECT cpf FROM usuario      WHERE cpf      LIKE '".$cpf."'";
		
		$conn = new Conexao();
		$conn->openConnect();
		
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultNome = mysqli_query($conn->getCon(),     $sqlNome); 
		$resultLogin = mysqli_query($conn->getCon(),    $sqlLogin); 
		$resultEmail = mysqli_query($conn->getCon(),    $sqlEmail); 
		$resultTelefone = mysqli_query($conn->getCon(), $sqlTelefone); 
		$resultCpf = mysqli_query($conn->getCon(),      $sqlCpf);
		
		$conn->closeConnect ();
		
		//Inicia os array e atribuir ao seus valores
		$arrayNome     = array();
		while ($row = mysqli_fetch_assoc($resultNome)) {
			$arrayNome[]=$row;
		}
		
		$arrayLogin    = array();
		while ($row = mysqli_fetch_assoc($resultLogin)) {
			$arrayLogin[]=$row;
		}
		
		$arrayEmail    = array();
		while ($row = mysqli_fetch_assoc($resultEmail)) {
			$arrayEmail[]=$row;
		}
		
		$arrayTelefone = array();
		while ($row = mysqli_fetch_assoc($resultTelefone)) {
			$arrayTelefone[]=$row;
		}
		
		$arrayCpf      = array();
		while ($row = mysqli_fetch_assoc($resultCpf)) {
			$arrayCpf[]=$row;
		}
		
		if (isset($arrayNome) || isset($arrayLogin) || 
				isset($arrayEmail) || isset($arrayTelefone) || 
				isset($arrayCpf)){
		
			$returnArray = [
				"nome"     => $arrayNome,
				"login"    => $arrayLogin,
				"email"    => $arrayEmail,
				"telefone" => $arrayTelefone,
				"cpf"      => $arrayCpf
			];
			
			return $returnArray;
			
		} else { 
			
			return true; 
			
			
		}
		
	}
	
	//Retorna a lista como o usuario pelo nome para a listaUsuario.php
	public function listaUsuarioPeloNome($nome){

		$conn = new Conexao();
		$conn->openConnect();
	
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultado = mysqli_query($conn->getCon(), 
			"SELECT nome, endereco, cidade, complemento, login, email, nivel_log, sexo, 
			cep, cpf, telefone,id FROM usuario WHERE BINARY nome LIKE '%".$nome."%'");
	
		//$list = mysqli_fetch_assoc($resultado);
	
		$arrayUsuarios = array();
	
		while ($row = mysqli_fetch_assoc($resultado)) {
			$arrayUsuarios[]=$row;
		}
	
		$conn->closeConnect ();
		return $arrayUsuarios;
	
	}
	
		//Retorna a lista como todos os email e cpf
	public function listaPeloEmailECpf($cpf, $email){

		$sql = sprintf("SELECT email, cpf, nome FROM usuario WHERE BINARY cpf = '".$cpf."' AND email LIKE '".$email."'");
	
		$conn = new Conexao();
		$conn->openConnect();
	
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultado = mysqli_query($conn->getCon(), $sql);
	
		$conn->closeConnect ();
		
		$arrayUsuarios = array();
	
		while ($row = mysqli_fetch_assoc($resultado)) {
			$arrayUsuarios[]=$row;
		}
		
		return $arrayUsuarios;
	
	}
	
	//Faz a busca pelo id e retorna o nivel_log do usuario
	public function listaUsuarioPeloId($id){
	
		$conn = new Conexao();
		$conn->openConnect();
	
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultado = mysqli_query($conn->getCon(),
				"SELECT nivel_log FROM usuario WHERE id = '".$id."'");
		
		$array = array();
	
		while ($row = mysqli_fetch_array($resultado)) {
			$array[]=$row;
		}
	
		$conn->closeConnect ();
		return $array;
	
	}
	
	//Lista os usuario pelo id para a AlteraUsuario.php
	public function listaUsuarioId($id){
	
		$sql = "SELECT nome, endereco, cidade, complemento, login, email, nivel_log, sexo, 
			cep, cpf, telefone,id FROM usuario WHERE id = '".$id."'";
		
		$conn = new Conexao();
		$conn->openConnect();
	
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultado = mysqli_query($conn->getCon(), $sql);
		
		$conn->closeConnect ();
		
		$array = array();
	
		while ($row = mysqli_fetch_array($resultado)) {
			$array[]=$row;
		}
	
		return $array;
	
	}
	
	//Faz a busca para verificar se o usuario ja esta cadastrado no sistema
	public function VerificaDadosCadastrado($email, $cpf, $nome){
	
		$sqlNome = "SELECT id, nome FROM usuario WHERE nome LIKE '".$nome."'";
		$sqlEmail = "SELECT id, email FROM usuario WHERE email LIKE  '".$email."'";
		$sqlCpf = "SELECT id, cpf FROM usuario WHERE cpf LIKE  '".$cpf."'";
		
		$conn = new Conexao();
		$conn->openConnect();
	
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resNome = mysqli_query($conn->getCon(), $sqlNome);
		$resEmail = mysqli_query($conn->getCon(), $sqlEmail);
		$resCpf = mysqli_query($conn->getCon(), $sqlCpf);
		
		$conn->closeConnect ();
		
		$arrayNome = array();
		while ($row = mysqli_fetch_array($resNome)) {
			$arrayNome[]=$row;
		}
		$arrayEmail = array();
		while ($row = mysqli_fetch_array($resEmail)) {
			$arrayEmail[]=$row;
		}
		$arrayCpf = array();
		while ($row = mysqli_fetch_array($resCpf)) {
			$arrayCpf[]=$row;
		}
		
		if (isset($arrayNome) && isset($arrayEmail) || isset($arrayCpf)){
			$array = [ "nome" => $arrayNome, "email" => $arrayEmail, "cpf" => $arrayCpf ];
			return $array;
		} else {
			return true;
		}
	}
	
	public function autenticar($login, $senha){
		
		$conn = new Conexao();
		//Abrir a conexao
		$conn->openConnect();
		//Seleciona o banco de dados
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		//Montar o sql
		$sql = "SELECT login, nivel_log, id FROM usuario WHERE login LIKE '".$login."' AND senha = '".md5($senha)."'";
		$resultado = mysqli_query($conn->getCon(), $sql);
		$linha = mysqli_fetch_assoc($resultado);
		//se achar algum resultado retorna verdadeiro
		if (mysqli_num_rows($resultado) > 0){
			$_SESSION['login'] = $login;
			$_SESSION['nivel_log'] = $linha['nivel_log'];
			$_SESSION['id'] = $linha['id'];
			
			return true;
			
		} else {
			
			return false;
			
		}
		
		
	}
	
}
?>