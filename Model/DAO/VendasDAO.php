<?php

include_once 'Conexao/Conexao.php';

class VendasDAO {
	
	//Cadastrar o produto
	public function cadastrarVendas(Vendas $vendas) {

		try {
	
			$sql = "INSERT INTO vendas (nome, nomeComprador, codBarra, valorDesconto, valorProduto, qtda, idProduto, idUsuario, data, codigoVenda, marca, aberta_fechada)
				VALUES ('" . $vendas->nome . "', '" . $vendas->nomeComprador . "', '" . $vendas->codBarra . "', '" . $vendas->valorDesconto . "', '" . $vendas->valorProduto . "', 
				'" . $vendas->qtda . "', '" . $vendas->idProduto . "', '" . $vendas->idUsuario . "', '" . $vendas->data . "', 
				'" . $vendas->codigoVenda . "', '" . $vendas->marca . "', '" . $vendas->aberto_fechado . "')";
			
			$conn = new Conexao ();
			$conn->openConnect ();
	
			$mydb = mysqli_select_db ( $conn->getCon (),$conn->getBD() );
			$resultado = mysqli_query ( $conn->getCon (), $sql );
	
			$conn->closeConnect ();
	
		} catch ( PDOException $e ) {
			$e->getMessage();
		}
		
	}
	
	//Alterar o valor de aberta para fechada
	public function alterar($aberta, $id) {
	
		$sql = "UPDATE vendas SET aberta_fechada='" . $aberta . "'	WHERE id = '" . $id . "'";
	
		$conn = new Conexao ();
		$conn->openConnect ();
	
		mysqli_select_db ( $conn->getCon (), $conn->getBD());
		$resultado = mysqli_query ( $conn->getCon (), $sql );
	
		$conn->closeConnect ();
	
	}
	
	//Alterar o nome do comprador
	public function alterarNomeComprador($nomeComprador, $cod) {
	
		$sql = "UPDATE vendas SET nomeComprador='" . $nomeComprador . "'	WHERE codigoVenda = '" . $cod . "'";
	
		$conn = new Conexao ();
		$conn->openConnect ();
	
		mysqli_select_db ( $conn->getCon (), $conn->getBD() );
		$resultado = mysqli_query ( $conn->getCon (), $sql );
	
		$conn->closeConnect ();
	
	}
	
	//deleta a compra cancelada pelo usuario, ja no caixa para finalizar a venda dele
	//Esse funчуo aqui esta indo para a pagina Caixa.php
	public function deleteId($id) {
		
		$sql = "DELETE FROM vendas WHERE id = '" . $id . "'";
	
		$conn = new Conexao ();
		$conn->openConnect ();
	
		mysqli_select_db ( $conn->getCon (), $conn->getBD() );
		$resultado = mysqli_query ( $conn->getCon (), $sql );
	
	}
	
	//deleta a pesquisar feita pelo usuario caixa
	public function deleteProdutoItem($id) {
		
		$sql = "DELETE FROM vendas WHERE id = '" . $id . "'";
	
		$conn = new Conexao ();
		$conn->openConnect ();
	
		mysqli_select_db ( $conn->getCon (), $conn->getBD() );
		$resultado = mysqli_query ( $conn->getCon (), $sql );
	
	}
	
	//esse deleta ele excluir todas as vendas vindo da classse ControlerCancelarTodaCompra.php
	public function deletePeloId($id) {
		
		$sql = "DELETE FROM vendas WHERE id = '" . $id . "'";
	
		$conn = new Conexao ();
		$conn->openConnect ();
	
		mysqli_select_db ( $conn->getCon (), $conn->getBD());
		$resultado = mysqli_query ( $conn->getCon (), $sql );
	
	}
	
	//lista todas as vendas para a listaTodasVendas.php
	public function listaTodasVendas(){
	
		$conn = new Conexao();
		$conn->openConnect();
	
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultado = mysqli_query($conn->getCon(),
				"SELECT * FROM vendas ORDER BY id DESC");
	
		$arrayVendas = array();
	
		while ($row = mysqli_fetch_assoc($resultado)) {
			$arrayVendas[]=$row;
		}
	
		$conn->closeConnect ();
		return $arrayVendas;
	
	}
	
	//lista todas as vendas com o valor do produto vendido para a listaTodasVendas.php
	public function listaValorVendido($dataInicio, $dataFinal){
	
		$sql = "select * from vendas where data between '".$dataInicio."' and '".$dataFinal."'";
		
		$conn = new Conexao();
		$conn->openConnect();
	
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultado = mysqli_query($conn->getCon(), $sql);

		$arrayVendas = array();
	
		while ($row = mysqli_fetch_assoc($resultado)) {
			$arrayVendas[]=$row;
		}
	
		$conn->closeConnect ();
		return $arrayVendas;
	
	}
	
	//lista nome comprador pelo codigo e nome para a paginaInicial.php
	public function listaNomeComprador($cod){
	
		$conn = new Conexao();
		$conn->openConnect();
	
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultado = mysqli_query($conn->getCon(),
				"SELECT nomeComprador FROM vendas WHERE codigoVenda = '".$cod."'");
	
		$arrayVendas = array();
	
		while ($row = mysqli_fetch_assoc($resultado)) {
		$arrayVendas[]=$row;
				
		}
		$conn->closeConnect ();
		return $arrayVendas;
	
	}
	
	//lista a ultima venda
	public function listaUltimaVenda(){
	
		$conn = new Conexao();
		$conn->openConnect();
	
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultado = mysqli_query($conn->getCon(),
				"SELECT * FROM vendas ORDER BY id DESC LIMIT 1");
	
		$arrayVendas = array();
	
		while ($row = mysqli_fetch_assoc($resultado)) {
			$arrayVendas[]=$row;
		}
	
		$conn->closeConnect ();
		return $arrayVendas;
	
	}

	//Lista a ultima venda inserida pelo usuario para a pagina FecharCompar.php
	public function ListaUltimoValor($codVenda){
	
		$conn = new Conexao();
		$conn->openConnect();
	
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultado = mysqli_query($conn->getCon(),
				"SELECT codigoVenda, id, idProduto FROM vendas WHERE codigoVenda LIKE '".$codVenda."' ORDER BY id DESC");
	
		$arrayVendas = array();
	
		while ($row = mysqli_fetch_assoc($resultado)) {
			$arrayVendas[]=$row;
		}
	
		$conn->closeConnect ();
		return $arrayVendas;
	
	}
	
	//Pegar toda a venda efetuado pelo cliente e enviar para ControllerCancelarTodaCompra.php
	public function CancelarTodaCompra($codigoProdutos){
	
		$conn = new Conexao();
		$conn->openConnect();
	
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultado = mysqli_query($conn->getCon(),
				"SELECT * FROM vendas WHERE codigoVenda = '".$codigoProdutos."'");
	
		$arrayVendas = array();
	
		while ($row = mysqli_fetch_assoc($resultado)) {
			$arrayVendas[]=$row;
		}
	
		$conn->closeConnect ();
		return $arrayVendas;
	
	}
	
	//Receber toda as vendas pelo codigo e lista para imprimir, Pagina ImprimirComprovante.php
	public function ListaComprovante($codigoVenda){
	
		$conn = new Conexao();
		$conn->openConnect();
	
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultado = mysqli_query($conn->getCon(),
				"SELECT nome, qtda, valorDesconto FROM vendas WHERE codigoVenda = '".$codigoVenda."'");
	
		$arrayVendas = array();
	
		if (!empty($resultado)){
		
			while ($row = mysqli_fetch_assoc($resultado)) {
				$arrayVendas[]=$row;
			}
			
		}
		
		$conn->closeConnect ();
		return $arrayVendas;
	
	}
	
	//Lista todo codigo e pela vendas se estiver aberta para pagina inicial na parte de finalizar as vendas
	public function ListaVendasFinalizarAberta($codigoVenda){
	
		$conn = new Conexao();
		$conn->openConnect();
	
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultado = mysqli_query($conn->getCon(),
				"SELECT * FROM vendas WHERE codigoVenda = '".$codigoVenda."' AND aberta_fechada LIKE 'Aberta' ORDER BY id ASC");
				 
		$arrayVendas = array();
	
		if (!empty($resultado)){
		
			while ($row = mysqli_fetch_assoc($resultado)) {
				$arrayVendas[]=$row;
			}
			
		}
		
		$conn->closeConnect ();
		return $arrayVendas;
	
	}
	
	
	//Lista vendas em abertas para a PaginaInicial.php
	public function ListaVendasAberta(){
	
		$conn = new Conexao();
		$conn->openConnect();
	
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultado = mysqli_query($conn->getCon(),
				"SELECT DISTINCT codigoVenda, nomeComprador FROM vendas WHERE aberta_fechada LIKE 'Aberta'");
	
		$arrayVendas = array();
	
		if (!empty($resultado)){
		
			while ($row = mysqli_fetch_assoc($resultado)) {
				$arrayVendas[]=$row;
			}
			
		}
		
		$conn->closeConnect ();
		return $arrayVendas;
	
	}
	
	
	//Pegar o codigo da sessao e lista na tela
	public function listaVendasPeloCodigo($codigoSession){
	
		$conn = new Conexao();
		$conn->openConnect();
	
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultado = mysqli_query($conn->getCon(),
				"SELECT * FROM vendas WHERE codigoVenda LIKE '".$codigoSession."'");
	
		$arrayVendas = array();
	
		while ($row = mysqli_fetch_assoc($resultado)) {
			$arrayVendas[]=$row;
		}
	
		$conn->closeConnect ();
		return $arrayVendas;
	
	}
	
	//Pegar o codigo vindo do ControllerFinalizarCompra para pegar a qtda, o valor compra e tudo para somar a compra feita do usuario
	public function listaVendaParaFecharCompra($codigo){
	
		$conn = new Conexao();
		$conn->openConnect();
	
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultado = mysqli_query($conn->getCon(),
				"SELECT * FROM vendas WHERE codigoVenda LIKE '".$codigoSession."'");
	
		$arrayVendas = array();
	
		while ($row = mysqli_fetch_assoc($resultado)) {
			$arrayVendas[]=$row;
		}
	
		$conn->closeConnect ();
		return $arrayVendas;
	
	}

	//faz uma buscar no banco de dados para ver se existe o codigo da session com o do banco
	public function ListaCodigoVendaSession($codSession){
	
		$conn = new Conexao();
		$conn->openConnect();
	
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultado = mysqli_query($conn->getCon(),
				"SELECT codigoVenda FROM vendas WHERE codigoVenda LIKE '".$codSession."'");
	
		$arrayVendas = array();
	
		while ($row = mysqli_fetch_assoc($resultado)) {
			$arrayVendas[]=$row;
		}
	
		$conn->closeConnect ();
		return $arrayVendas;
	
	}

	//Traz todas as compra em abertas para fechar
	public function ListaPeloCod($codigoVenda){
	
		$conn = new Conexao();
		$conn->openConnect();
	
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultado = mysqli_query($conn->getCon(),
				"SELECT * FROM vendas WHERE codigoVenda LIKE '".$codigoVenda."'");
	
		$arrayVendas = array();
	
		while ($row = mysqli_fetch_assoc($resultado)) {
			$arrayVendas[]=$row;
		}
	
		$conn->closeConnect ();
		return $arrayVendas;
	
	}

	//lista a venda pelo id da compra, e envia para o ControllerExcluirItemComprados
	public function listaPeloId($id){
	
		$conn = new Conexao();
		$conn->openConnect();
	
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultado = mysqli_query($conn->getCon(),
				"SELECT * FROM vendas WHERE id = '".$id."'");
	
		$arrayVendas = array();
	
		while ($row = mysqli_fetch_assoc($resultado)) {
			$arrayVendas[]=$row;
		}
	
		$conn->closeConnect ();
		return $arrayVendas;
	
	}
	
	//lista o ultimo valor da vendaTotal para a tela PaginaInicial.php
	public function listaId(){
	
		$conn = new Conexao();
		$conn->openConnect();
	
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultado = mysqli_query($conn->getCon(),
				"SELECT * FROM vendas WHERE id = '".$id."'");
	
		$arrayVendas = array();
	
		while ($row = mysqli_fetch_assoc($resultado)) {
			$arrayVendas[]=$row;
		}
	
		$conn->closeConnect ();
		return $arrayVendas;
	
	}
	
	
	//Essa metodo aqui vai para a classe fecharCaixa.php, ela esta verificando se tem vendas em aberto
	public function listaVendasAbertasParaFechar(){
	
		$conn = new Conexao();
		$conn->openConnect();
	
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultado = mysqli_query($conn->getCon(),
				"SELECT * FROM vendas WHERE aberta_fechada = 'Aberta'");
	
		$arrayVendas = array();
	
		while ($row = mysqli_fetch_assoc($resultado)) {
			$arrayVendas[]=$row;
		}
	
		$conn->closeConnect ();
		return $arrayVendas;
	
	}
	
	//Traz o ultimo "valortotal" cadastrado
	public function UltimaValorTotal($cod){
	
		$conn = new Conexao();
		$conn->openConnect();
	
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultado = mysqli_query($conn->getCon(),
				"SELECT * FROM vendas WHERE codigoVenda LIKE '".$cod."' ORDER BY id DESC LIMIT 1 ");
	
		$arrayVendas = array();
	
		while ($row = mysqli_fetch_assoc($resultado)) {
			$arrayVendas[]=$row;
		}
				
		$conn->closeConnect ();
		return $arrayVendas;
	
	}

}
?>