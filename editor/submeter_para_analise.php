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
	session_start();
	
	require_once('../assets/php/decrypt.php');

	$decrypt = new Decrypt;

	
	if (isset($_GET['sair'])) {
		session_cache_expire();
		session_unset();
		session_destroy();
		?>
		<meta http-equiv="refresh" content="0; URL='./?'"/>
		<?php

	}

	include_once('api.php');

	$api = new Editor;

	if (!isset($_SESSION['eid'])) {
		header("Refresh: 0; url=/login.php");
	 ?>
		<meta http-equiv="refresh" content="0; URL='./login.php'"/>
	 <?php

	} else {

	if (isset($_GET['cid'])) {
 
 		$_SESSION['cid'] = $decrypt->sha1($_GET['cid']);

		?>
			<meta http-equiv="refresh" content="0; URL='./submeter_para_analise.php'"/>
		<?php
	
	}

	if (isset($_SESSION['cid'])) {
?>


<?php
		if (isset($_POST['i'])) {

			if ($_SESSION['cid'] !== "") {
			 
				$a = json_encode($_POST, true);

				$b = json_decode($a, true);
			 
				$post = [];

				$post[] = current($b);
			 
				for ($i=0; $i < count($b); $i++) { 
					 $post[] = next($b);
				}

				for ($i=0; $i < count($post); $i++) { 
					$api->insertAidCid($post[$i], $_SESSION['cid']);
					sleep(1);
				}

			}
	 			$_SESSION['cid'] = "";
			

		?>
			<meta http-equiv="refresh" content="0; URL='./painel.php'"/>
		<?php

		}

?>


<!DOCTYPE HTML>
<!--
	EDITOR by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
<head>
	<title>Astrofotografia Brasil - EDITOR</title>
	<link rel="icon" href="favicon.png">
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
	<link rel="stylesheet" href="assets/css/main.css" />
</head>
<body class="is-preload">

<!-- Wrapper -->
	<div id="wrapper">

		<!-- Main -->
		<div id="main">
			<div class="inner">
				<header id="header">
					<a href="" class="logo"><strong>ASTROFOTOGRAFIA BRASIL</strong> - EDITOR</a>
					<ul class="icons">
						<li>
							<span class="label">Olá, EDITOR.</span> 
						</li>
						<li>
							<a href="?sair" class="icon solid fa-window-close"><span class="label">SAIR</span></a>
						</li>
					</ul>
				</header>


				<!-- Content -->
				<section>

					<div class="box">
						<p>Abaixo são listados todos os (as) avaliadores(as), selecione os responsáveis por analisar esta captura. Sugerimos que escolha no mínimo três. Lembre-se se observar a categoria da captura e as categorias nas quais os avaliadores se propuseram a avaliar. Após selecionar os responsáveis, clique em <strong> ENVIAR PARA AVALIADOR (ES)</strong> para completar o processo.</p>
					</div>
					<div class="row" style="text-align: center;">
						<br /><br /><br />
						<div class="col-4 col-12-medium">
							
						</div>
						<br /><br /><br />
						<div class="col-4 col-12-medium">
							 <a  href="painel.php" class="button primary large">PAINEL</a> 
						</div>
						<br /><br /><br />
						<div   class="col-4 col-12-medium">
 
						</div>
					</div>
					<div class="table-wrapper">
						<table>
							<thead>

								<tr>
									<th>Autor</th>
									<th>Título</th>
									<th>Categoria</th>
									<th>Descricao</th>
									<th></th>
		
								</tr>
							</thead>
							<tbody>

								<?php

							 	if ($_SESSION['cid'] !== "") {
									 

									$getCaptura = $api->getCaptura($_SESSION['cid']);

								?>
								<tr>

									<td>
										<p><?php echo $getCaptura['cautor']; ?></p>
									</td>
									<td>
										<p><?php echo $getCaptura['ctitulo']; ?></p>
									</td>
									<td>
										<p><?php echo $getCaptura['ccategoria']; ?></p>
									</td>
									<td>
										<p><?php echo $getCaptura['cdescricao']; ?></p>
									</td>

									<td> 
										<a href="<?php echo $getCaptura['csrcfull']; ?>" target="blank" class="button primary large">Ver Imagem</a> 
									</td>

								</tr>

								<?php 

								 }

								 ?>
							</tbody>

						</table>
					</div>

					<hr class="major" />


					<div class="table-wrapper">

						<form method="post" action="">
							<table style="text-align: center;">
								<thead>
									<tr>
			
										<th>Nome</th>
										<th>Email</th>
										<th>Categoria</th>
										<th></th>
									</tr>
								</thead>
								<tbody>

								<?php 


				

				$all_from_avaliador = $api->all_from_avaliador();

				//print_r($all_from_avaliador);

				for ($i=0; $i < count($all_from_avaliador); $i++) { 
					//print_r($all_from_avaliador[$i]);			
				?>

									<tr>

										<td>
											<p><?php echo $all_from_avaliador[$i]['anome'] ?></p>
										</td>
										<td>
											<p><?php echo $all_from_avaliador[$i]['aemail'] ?></p>
										</td>
										<td>
											<p><?php echo $all_from_avaliador[$i]['ccategoria'] ?></p>
										</td>
										<td >
											<input type="checkbox" id="aid_<?php echo $all_from_avaliador[$i]['aid'] ?>" name="aid_<?php echo $all_from_avaliador[$i]['aid'] ?>" value="<?php echo $all_from_avaliador[$i]['aid'] ?>">
											<label for="aid_<?php echo $all_from_avaliador[$i]['aid'] ?>">ESCOLHER COMO AVALIADOR (A)</label>
										</td>
									</tr>
								<?php 
									}
								?>
								</tbody>
							</table>
								<!-- Break -->
								<div class="col-12">
									<ul class="actions">
										<li><input type="text" value="0" name="i" style="display: none;" /></li>
										<li><input type="submit" value="ENVIAR PARA AVALIADOR (ES)" class="primary" /></li>
										 
									</ul>
								</div>
							</div>
						</form>

					</div>
					<hr class="major" />


				</section>

						<center>&copy; 2020 Astrofotografia Brasil. <br />  Design by HTML5 UP. <br/> Developed by Isak Ruas.</center>  
						<br /><br />
			</div>
		</div>
	</div>



	<!-- Scripts -->
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/js/browser.min.js"></script>
	<script src="assets/js/breakpoints.min.js"></script>
	<script src="assets/js/util.js"></script>
	<script src="assets/js/main.js"></script>

</body>
</html>

<?php

} else {
		?>
			<meta http-equiv="refresh" content="0; URL='./painel.php'"/>
		<?php
}
 
}
 
?>