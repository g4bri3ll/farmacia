<?php

include_once 'Conexao/Conexao.php';

class FornecedorDAO {
	private $conn = null;
	public function cadastrarFornecedor(Fornecedor $fornecedor) {
			
			try {
								
				$sql = "INSERT INTO fornecedor (nome, endereco, cidade, email, sexo, cep, cnpj, telefone) 
				VALUES ('" . $fornecedor->nome . "', '" . $fornecedor->endereco . "', '" . $fornecedor->cidade . "', '" . $fornecedor->email . "',
						'" . $fornecedor->sexo . "','" . $fornecedor->cep . "','" . $fornecedor->cnpj . "', '" . $fornecedor->telefone . "')";
				
				$conn = new Conexao ();
				$conn->openConnect ();
				
				$mydb = mysqli_select_db ( $conn->getCon (), $conn->getBD());
				$resultado = mysqli_query ( $conn->getCon (), $sql );
				
				$conn->closeConnect ();
				
				return true;
				
			} catch ( PDOException $e ) {
				return $e->getMessage();
			}
	}
	
	public function alterarFornecedor(Fornecedor $fornecedor) {
		
		$sql = "UPDATE fornecedor SET nome='" . $fornecedor->nome . "', endereco='" . $fornecedor->endereco . "', cidade='" . $fornecedor->cidade . "', 
				email='" . $fornecedor->email . "', sexo='" . $fornecedor->sexo . "', cep='" . $fornecedor->cep . "', cnpj='" . $fornecedor->cnpj . "', 
						telefone='" . $fornecedor->telefone . "' WHERE id = '" . $fornecedor->id . "'";
		
		$conn = new Conexao ();
		$conn->openConnect ();
		
		mysqli_select_db ( $conn->getCon (), $conn->getBD());
		$resultado = mysqli_query ( $conn->getCon (), $sql );
		
		$conn->closeConnect ();
		
		return true;
	}
	
	public function deleteId($id) {
		$sql = "DELETE FROM fornecedor WHERE id = '" . $id . "'";
		
		$conn = new Conexao ();
		$conn->openConnect ();
		
		mysqli_select_db ( $conn->getCon (), $conn->getBD());
		$resultado = mysqli_query ( $conn->getCon (), $sql );
		
		$conn->closeConnect ();
		
		return true;
	}
	
		//Retorna a lista como todos os fornecedores
	public function listaFornecedores(){
	
		$sql = sprintf("SELECT * FROM fornecedor ORDER BY id DESC");
	
		$conn = new Conexao();
		$conn->openConnect();
	
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultado = mysqli_query($conn->getCon(), $sql);
	
		//$list = mysqli_fetch_assoc($resultado);
	
		$arrayFornecedor = array();
	
		while ($row = mysqli_fetch_assoc($resultado)) {
			$arrayFornecedor[]=$row;
		}
	
		$conn->closeConnect ();
		return $arrayFornecedor;
	
	}

	//Retorna a lista de fornecedores pelo nome
	public function listaFornecedoresPeloNome($recNome){
	
		$sql = "SELECT * FROM fornecedor WHERE nome LIKE '%".$recNome."%'";
		
		$conn = new Conexao();
		$conn->openConnect();
	
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultado = mysqli_query($conn->getCon(), $sql);
	
		$conn->closeConnect ();
	
		$arrayFornecedor = array();
	
		while ($row = mysqli_fetch_assoc($resultado)) {
			$arrayFornecedor[]=$row;
		}
		
		return $arrayFornecedor;
	
	}

	//Retorna a lista de fornecedores pelo id para a classe que altera o fornecedor
	public function listaPeloIdParaAltera($id){
	
		$conn = new Conexao();
		$conn->openConnect();
	
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultado = mysqli_query($conn->getCon(), 
				"SELECT * FROM fornecedor WHERE id='".$id."'");
	
		//$list = mysqli_fetch_assoc($resultado);
	
		$arrayFornecedor = array();
	
		while ($row = mysqli_fetch_assoc($resultado)) {
			$arrayFornecedor[]=$row;
		}
	
		$conn->closeConnect ();
		return $arrayFornecedor;
	
	}

	//Verificar se ja existe esse item no banco de dados
	public function VerificaCadastrado($nome, $endereco, $cnpj, $telefone){
	
		$sqlNome     = "SELECT nome     FROM fornecedor WHERE nome     ='".$nome."'";
		$sqlEndereco = "SELECT endereco FROM fornecedor WHERE endereco ='".$endereco."'";
		$sqlCnpj     = "SELECT cnpj     FROM fornecedor WHERE cnpj     ='".$cnpj."'";
		$sqlTelefone = "SELECT telefone FROM fornecedor WHERE telefone ='".$telefone."'";
		
		$conn = new Conexao();
		$conn->openConnect();
	
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultNome = mysqli_query($conn->getCon(), $sqlNome);
		$resultEndereco = mysqli_query($conn->getCon(), $sqlEndereco);
		$resultCnpj = mysqli_query($conn->getCon(), $sqlCnpj);
		$resultTelefone = mysqli_query($conn->getCon(), $sqlTelefone);
		
		$conn->closeConnect ();
		
		$arrayNome     = array();
		while ($row = mysqli_fetch_assoc($resultNome)) {
			$arrayNome[]=$row;
		}
		$arrayEndereco = array();
		while ($row = mysqli_fetch_assoc($resultEndereco)) {
			$arrayEndereco[]=$row;
		}
		$arrayCnpj     = array();
		while ($row = mysqli_fetch_assoc($resultCnpj)) {
			$arrayCnpj[]=$row;
		}
		$arrayTelefone = array();
		while ($row = mysqli_fetch_assoc($resultTelefone)) {
			$arrayTelefone[]=$row;
		}
	
		if (isset($arrayNome) || isset($arrayEndereco) && isset($arrayCnpj) || isset($arrayTelefone)){
			$array = [
				"nome" => $arrayNome,
				"endereco" => $arrayEndereco,
				"cnpj" => $arrayCnpj,
				"telefone" => $arrayTelefone
			];
			return $array;
		} else { return true; }
		
	}
	
}
?>