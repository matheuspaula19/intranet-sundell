<!--
No campo src da tag img abaixo enviaremos 4 parametros via GET
l = largura da imagem
a = altura da imagem
tf = tamanho fonte das letras
ql = quantidade de letras do captcha
-->
<!--
O texto digitado no campo abaixo sera enviado via POST para
o arquivo validar.php que ira vereficar se o que voce digitou é igual
ao que foi gravado na sessao pelo captcha.php
-->

<script type="text/javascript">
function toUpper(lstr)
{
	var str=lstr.value;
	lstr.value=str.toUpperCase();
}
</script>
<style type="text/css">
	.txt_box{
		height: 27px;
		border: 1px solid #ccc;
		padding-left: 4px;
		outline:none;
		-webkit-box-shadow: 0 1px 3px 0 rgba(0,0,0,.2);
		box-shadow: 0 1px 3px 0 rgba(0,0,0,.2);
	}
	.txt_box:focus{
		-webkit-box-shadow: 0 1px 3px 0 rgba(0,0,0,.3);
		box-shadow: 0 1px 3px 0 rgba(0,0,0,.3);
	}
</style>
<form action="validar.php" name="form" method="post">
	<table>
		<tr>
			<td colspan="2">Digite o que você vê abaixo:</td>
		</tr>
		<tr>
			<td><img src="captcha.php?l=100&a=30&tf=15&ql=5"></td>
			<td><input type="text" onkeyup="toUpper(this)" name="palavra" class="txt_box" style="width:80px;" /></td>
		</tr>
	</table>
   <input type="submit" value="Validar Captcha" />
</form>
