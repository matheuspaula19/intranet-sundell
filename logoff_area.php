<?php
if( isset($_SESSION['usr_Tipo']) && $_SESSION['usr_Tipo'] == 'admin'){
?>
	<div class='user_id_div'>
	<table align='left'><tr>
	<td rowspan='3'><a href="profile.php?p=<?=$_SESSION['usr_login_name']?>"><img src='admin/profile_imgs/<?=$_SESSION['usr_pic'] ?>' alt='<?=$_SESSION['usr_nome']?>' border="0" style='border-radius: 3px;width:50px;height:50px;'></a></td>
	<td style='font-size: 15px;line-height: 15px;'><a href="profile.php?p=<?=$_SESSION['usr_login_name']?>" style="text-decoration:none;color: #666;"><?php echo substr($_SESSION['usr_nome'],  0, strpos($_SESSION['usr_nome'], " ")); ?></a></td>
	<tr><td style='font-size: 12px;line-height: 12px;'><a href="profile.php?p=<?=$_SESSION['usr_login_name']?>" style="text-decoration:none;color: #666;"><?php echo substr($_SESSION['usr_nome'], strpos($_SESSION['usr_nome'], " ")); ?></a></td></tr>
	<tr><td style='font-size: 10px;line-height: 10px;'>Administrador | <a href='admin/seguranca.php?o=1'>sair</a></td></tr>
	</table>
	</div>
<?php
}
else{
	if( isset($_SESSION['usr_Tipo']) && $_SESSION['usr_Tipo'] == 'editor'){
?>
	<div class='user_id_div'>
	<table align='left'><tr>
	<td rowspan='3'><a href="profile.php?p=<?=$_SESSION['usr_login_name']?>"><img src='admin/profile_imgs/<?=$_SESSION['usr_pic'] ?>' alt='<?=$_SESSION['usr_nome']?>' border="0"  style='border-radius: 3px;width:50px;height:50px;'></a></td>
	<td style='font-size: 15px;line-height: 15px;'><a href="profile.php?p=<?=$_SESSION['usr_login_name']?>" style="text-decoration:none;color: #666;"><?php echo substr($_SESSION['usr_nome'],  0, strpos($_SESSION['usr_nome'], " ")); ?></a></td>
	<tr><td style='font-size: 12px;line-height: 12px;'><a href="profile.php?p=<?=$_SESSION['usr_login_name']?>" style="text-decoration:none;color: #666;"><?php echo substr($_SESSION['usr_nome'], strpos($_SESSION['usr_nome'], " ")); ?></a></td></tr>
	<tr><td style='font-size: 10px;line-height: 10px;'>Editor | <a href='admin/seguranca.php?o=1'>sair</a></td></tr>
	</table>
	</div>
<?php
	}
}
?>