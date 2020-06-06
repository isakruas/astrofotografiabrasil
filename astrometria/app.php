<?php
/**
* Astrofotografia Brasil
* ======================
*
* Astrofotografia Brasil  é uma  plataforma para  divulgação de  astrofotografias  feitas  por 
* profissionais e/ou amadores no território brasileiro, nesta perspectiva, objetiva incentivar
* a  participação  da  comunidade  brasileira em observações e registros de corpos  celestes e 
* fenômenos astronômicos.
*
* @author      Isak Ruas <isakruas@gmail.com>
*
* @license    	Esta plataforma é disponibilizada sobre a Licença Pública Geral (GNU) V3.0
*              Mais detalhes em: https://github.com/isakruas/astrofotografiabrasil/blob/master/LICENSE
*
* @link        Homepage:     http://astrofotografia.nrolabs.com/
*              GitHub Repo:  https://github.com/isakruas/astrofotografiabrasil/
*              README:       https://github.com/isakruas/astrofotografiabrasil/blob/master/README.md
*
* @version     1.0.00
*/

if (isset($_GET['subid'])) {
	if (is_numeric($_GET['subid'])) {

		require_once ('api.php');
		$api = new Astrometria;
		$astrometria = $api->all_from_astrometria_where_subid($_GET['subid']);

		if ($astrometria !== false) {
			
			define('cid', $astrometria['cid']);
			define('subid', $_GET['subid']);

			$captura = $api->all_from_captura_where_cid(cid);

			if ($captura !== false) {
				#pode carregar a pagina


			define('csrcfull', $captura['csrcfull']);
			define('csrcsmall', $captura['csrcsmall']);


			$url = "http://nova.astrometry.net/api/jobs/".subid."/info/";

			$ch = curl_init();

			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_URL,$url);
			$result=curl_exec($ch);

			curl_close($ch);

			$jobs = json_decode($result, true);
?>



<!DOCTYPE HTML>
<!--
USUÁRIO by HTML5 UP
html5up.net | @ajlkn
Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
<head>
<title>Astrofotografia Brasil</title>
<link rel="icon" href="../favicon.png">
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
<link rel="stylesheet" href="../usuario/assets/css/main.css" />
</head>
<body class="is-preload">

<!-- Wrapper -->
<div id="wrapper">

	<!-- Main -->
	<div id="main">
		<div class="inner">
			<header id="header">
				<a href="../" class="logo"><strong>ASTROFOTOGRAFIA BRASIL</strong></a>
			</header>

			<blockquote style="text-align: justify;">
				Astrofotografia Brasil é uma plataforma para divulgação de astrofotografias feitas por profissionais e/ou amadores no território brasileiro, nesta perspectiva, objetiva incentivar a participação da comunidade brasileira em observações e registros de corpos celestes e fenômenos astronômicos. Periodicamente são incluídas novas fotos.
			</blockquote>

			<div class="row" style="text-align: center;">
				<br /><br /><br />
				<div class="col-4 col-12-medium"> 
				</div>
				<br /><br /><br />
				<div class="col-4 col-12-medium">
						<p class="button  large">ASTROMETRIA</p> 
				</div>
				<br /><br /><br />
				<div   class="col-4 col-12-medium">
				</div>
			</div>


			<!-- Content -->
			<section>

				<div class="box">
					<p>Original</p>
				</div>

				<div class="table-wrapper" style="text-align: justify;">


					<table>
						<thead style="border: none;">
							<tr>
	 							<th>
					<center>
						<img src="<?php echo(csrcsmall) ?>"  alt="" />
					</center>

	 							</th>
								<th>
					<center>
					<a href="<?php echo(csrcfull) ?> " target="blank" class="button primary large">Ampliar imagem</a> 
				</center>

								</th>
							</tr>
						</thead>
						<tbody style="text-align: center;">

					   </tbody>

					</table>





				</div>
			<hr class="major" />
				<div class="box">
					<p>Vermelhos e Verde</p>
				</div>

				<div class="table-wrapper" style="text-align: justify;">
					<center>
						<img src="http://nova.astrometry.net/red_green_image_display/<?php echo(subid) ?>"  alt="" />
					</center>

				</div>
			<hr class="major" />
				<div class="box">
					<p>Anotações</p>
				</div>

				<div class="table-wrapper" style="text-align: justify;">
					<center>
						<img src="http://nova.astrometry.net/annotated_display/<?php echo(subid) ?>"  alt="" />
					</center>

				</div>

			<hr class="major" />

				<div class="box">
					<p>Imagem de extração</p>
				</div>

				<div class="table-wrapper" style="text-align: justify;">
					<center>
						<img src="http://nova.astrometry.net/extraction_image_display/<?php echo(subid) ?>"  alt="" />
					</center>
				</div>

			<hr class="major" />

				<div class="box">
					<p>Tags</p>
				</div>

				<div class="table-wrapper" style="text-align: justify;">

					<?php 

					
					$tags = "";
					for ($i=0; $i < count($jobs['tags']) ; $i++) { 
						$tags = $tags.$jobs['tags'][$i].", ";
					}
					echo $tags; 

					?>

				 

				</div>
			<hr class="major" />

				<div class="box">
					<p>Calibração</p>
				</div>

				<div class="table-wrapper" style="text-align: justify;">

					<table>
						<thead>
							<tr>
	 							<th></th>
								<th></th>
							</tr>
						</thead>
						<tbody style="text-align: center;">

	 
			<tr>
				<td>
					<p>Centro RA</p>
				</td>

				<td>
					<p> <?php echo $jobs['calibration']['ra']; ?> </p>
				</td>
			</tr>
		 
			<tr>
				<td>
					<p>Centro DEC</p>
				</td>

				<td>
					<p> <?php echo $jobs['calibration']['dec']; ?> </p>
				</td>
			</tr>

	 
			<tr>
				<td>
					<p>Raio do campo</p>
				</td>

				<td>
					<p> <?php echo $jobs['calibration']['radius']; ?> </p>
				</td>
			</tr>
	 
			<tr>
				<td>
					<p>Escala de pixels</p>
				</td>

				<td>
					<p> <?php echo $jobs['calibration']['pixscale']; ?> </p>
				</td>
			</tr>


			<tr>
				<td>
					<p>Orientação</p>
				</td>

				<td>
					<p> <?php echo $jobs['calibration']['orientation']; ?> </p>
				</td>
			</tr>
			<tr>
				<td>
					<p>Paridade</p>
				</td>

				<td>
					<p> <?php echo $jobs['calibration']['parity']; ?> </p>
				</td>
			</tr>
			



					   </tbody>

					</table>

				</div>

				

			<hr class="major" />

			<div class="row" style="text-align: center;">
				<br /><br /><br />
				<div class="col-4 col-12-medium"> 
				</div>
				<br /><br /><br />
				<div class="col-4 col-12-medium">
						<p class="button large" onclick="window.location.href = '../' " >VOLTAR</p> 
				</div>
				<br /><br /><br />
				<div   class="col-4 col-12-medium">
				</div>
			</div>

			<blockquote>
			“Diante da vastidão do tempo e da imensidão do universo, é um imenso prazer para mim dividir um planeta e uma época com você.”
			<br />
			Carl Sagan
			</blockquote>
			</section>

					<center>&copy; 2020 Astrofotografia Brasil. <br />  Design by HTML5 UP.  <br /> Icons made by Surang. <br/>  Developed by Isak Ruas.</center> 
                    
					<br /><br />

		</div>
	</div>


</div>

</body>
</html>
<?php


			} else {
				header('Location: ../');
			}
		} else {
			header('Location: ../');
		}
		
	} else {
		header('Location: ../');
	}

} else {
	header('Location: ../');
}
?>