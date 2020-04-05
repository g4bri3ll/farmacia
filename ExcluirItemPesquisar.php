<?php

$id = $_GET['id'];

?>
<script type="text/javascript">
var id = "<?php echo $id; ?>";
	if (confirm("Desejar excluir esse item mesmo?")){
		window.location="Controller/ControllerExcluirItemPesquisa.php?id=" + id;
	} else {
		window.location="PaginaInicial.php";
	}
</script>
