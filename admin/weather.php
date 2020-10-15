<html>
<head>
<title>Temperatura</title>
<style type="text/css">
#weather-widget span{font-family: 'Open Sans', sans-serif;color: #777777;font-size: 12px;line-height: 20px;}
#weather-widget td {padding: 0px;}
</style>
</head>
<body>
<?php
error_reporting(0);
if (!$sock = @fsockopen('api.openweathermap.org', 80, $num, $error, 5)) {
echo "<div style=\"text-align: center;height: 100px;background: #9a1616;font-family: 'Open Sans';color: #fff;padding-top: 50px;\">Não foi possível estabelecer conexão com o servidor de temperatura</div>";
}
else{
		//permite a pesquisa por url e define a cidade padrão
		if(isset($_GET['q'])){$api_city = $_GET['q'];}
		else{$api_city = "Sao_jose_dos_campos";}

		$arquivo = "http://api.openweathermap.org/data/2.5/weather?q=".$api_city."&lang=pt&units=metric";
		
		if(file_get_contents($arquivo) === FALSE){
			echo "<div style=\"text-align: center;height: 100px;background: #9a1616;font-family: 'Open Sans';color: #fff;padding-top: 50px;\">Não foi possível estabelecer conexão com o servidor de temperatura</div>";
		}
		else{ 
			$info = file_get_contents($arquivo);
			$lendo = json_decode($info);
			foreach($lendo->weather as $base ){
				$cur_icon = "../weather-api-images/".$base->icon.".png";
				$temp_desc = utf8_decode($base->description);
			}
			$cur_temp = $lendo->main->temp;
			$max_temp = $lendo->main->temp_max;
			$min_temp = $lendo->main->temp_min;
			$humidity = $lendo->main->humidity;
			$wind = $lendo->wind->speed;
			$city = utf8_decode($lendo->name);

			$gmt = 10800;// GMT -03:00 (horario de brasilia)
			$atualizado = gmdate ( "H:i", $lendo->dt - $gmt);
			
			echo "<table id='weather-widget'><tr>";
			echo "<td><img src='".$cur_icon."'/></td>";
			echo "<td align='right' style='width: 100%;'><div><span style='font-size: 45px;line-height: 50px;'>".number_format(str_replace(',','.',$cur_temp))."º</span></div>";
			echo "<div><span>".$city."</span></div>";
			echo "<div><span style='text-transform:capitalize;'>".$temp_desc."</span></div>";
			echo "<div><span style='color: #296ead;font-weight: bolder;'>MIN ".$min_temp."º</span><span>&nbsp;|&nbsp;</span><span style='color:#ce0101;font-weight: bolder;'>MAX ".$max_temp."º</span></div>";
			echo "<div><span style='font-size: 10px;white-space: nowrap;'>Vento:&nbsp;".($wind*3.6)."&nbsp;km/h | Umidade:&nbsp;".$humidity."%</span></div><div><span style='font-size: 10px;'>Atualizado: às: ".$atualizado."</span></div></td></tr>";
			echo "<tr><td></td>";
			echo "</tr></table>";
		}
	}	
?>
</body>
</html>