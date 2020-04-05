<?php
//A classe que alterar esta pedindo para colocar a conexao ae
include_once 'Conexao/Conexao.php';

class EmpresaDAO {
	
	private $conn = null;
	
	//Cadastrar a empresa
	public function cadastrar(Empresa $empresa) {
		
			try {
								
				$sql = "INSERT INTO empresa (nome, telefone, endereco, cnpj, email, cep, msg) 
				VALUES ('" . $empresa->nome . "', '" . $empresa->telefone . "', '" . $empresa->endereco . "', 
				'" . $empresa->cnpj . "', '" . $empresa->email . "','" . $empresa->cep . "','" . $empresa->msg . "')";
				
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
	
	//alterando os dados da empresa
	public function alterar(Empresa $empresa) {
		
		$sql = "UPDATE empresa SET nome='" . $empresa->nome . "', telefone='" . $empresa->telefone . "', endereco='" . $empresa->endereco . "', 
				cnpj='" . $empresa->cnpj . "', email='" . $empresa->email . "', cep='" . $empresa->cep . "',
				msg='" . $empresa->msg . "'	WHERE id='".$empresa->id."'";
		
		$conn = new Conexao ();
		$conn->openConnect ();
		
		mysqli_select_db ( $conn->getCon (), $conn->getBD());
		$resultado = mysqli_query ( $conn->getCon (), $sql );
		
		$conn->closeConnect ();
		
		return true;
	}
	
	//excluir a empresa
	public function deleteId($id) {
		$sql = "DELETE FROM empresa WHERE id = '" . $id . "'";
		
		$conn = new Conexao ();
		$conn->openConnect ();
		
		mysqli_select_db ( $conn->getCon (), $conn->getBD());
		$resultado = mysqli_query ( $conn->getCon (), $sql );
		
		$conn->closeConnect ();
		
		return true;
		
	}
	
	//lista toda a empresa
	public function lista(){
	
		$sql = sprintf("SELECT * FROM empresa");
	
		$conn = new Conexao();
		$conn->openConnect();
	
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultado = mysqli_query($conn->getCon(), $sql);
	
		$conn->closeConnect ();
		
		$arrayProduto = array();
		
		if (!empty($resultado)){
		
			while ($row = mysqli_fetch_assoc($resultado)) {
				$arrayProduto[]=$row;
			}
			
		}
		
		return $arrayProduto;
	
	}
	
	//lista toda a empresa
	public function listaPeloId($id){
	
		$sql = sprintf("SELECT * FROM empresa WHERE id = '".$id."'");
	
		$conn = new Conexao();
		$conn->openConnect();
	
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultado = mysqli_query($conn->getCon(), $sql);
	
		$arrayProduto = array();
	
		while ($row = mysqli_fetch_assoc($resultado)) {
			$arrayProduto[]=$row;
		}
	
		$conn->closeConnect ();
		return $arrayProduto;
	
	}

}
?>