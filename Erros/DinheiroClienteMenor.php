<?php 

$codigo = $_GET['codigo'];

?>
<script type="text/javascript">
var codigo = "<?php echo $codigo; ?>";
alert("O dinheiro do cliente e menor que o valor da compra");
window.location="../Caixa.php?codigo="+codigo+"";
</script>
