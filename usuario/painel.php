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

 	error_reporting(0);
	session_start();
	//print_r(sha1(1));


	if (isset($_GET['sair'])) {
		session_cache_expire();
		session_unset();
		session_destroy();
		?>
		<meta http-equiv="refresh" content="0; URL='./?'"/>
		<?php

	}


	include_once('api.php');

	$api = new Usuario;

	if (!isset($_SESSION['uid'])) {
		header("Refresh: 0; url=/login.php");
		?>
		<meta http-equiv="refresh" content="0; URL='./login.php'"/>
		<?php

	} else {
?>
<!DOCTYPE HTML>
<!--
	USUÁRIO by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
<head>
	<title>Astrofotografia Brasil - Usuário</title>
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
					<a href="" class="logo"><strong>ASTROFOTOGRAFIA BRASIL</strong> - USUÁRIO</a>
					<ul class="icons">
						<li>
							<span class="label">Olá, <?php echo $_SESSION['unome']; ?>.</span> 
						</li>
						<li>
							<a href="?sair" class="icon solid fa-window-close"><span class="label">SAIR</span></a>
						</li>
					</ul>

				</header>

				<blockquote>
				“Diante da vastidão do tempo e da imensidão do universo, é um imenso prazer para mim dividir um planeta e uma época com você.”
				<br />
				Carl Sagan
				</blockquote>

				<div class="row" style="text-align: center;">
					<br /><br /><br />
					<div class="col-4 col-12-medium"> 
					</div>
					<br /><br /><br />
					<div class="col-4 col-12-medium">
 						<a href="./submeter_captura.php" class="button primary large">SUBMETER CAPTURA</a> 
					</div>
					<br /><br /><br />
					<div   class="col-4 col-12-medium">
					</div>
				</div>


				<!-- Content -->
				<section>

					<div class="box">
						<p>Capturas em processo de análise preliminar do editor.</p>
					</div>

					<div class="table-wrapper">
						<table>
							<thead>

								<tr>
			 
									 
									<th>Título</th>
									<th>Categoria</th>
									<th>Descricao</th>
									<th></th>
								 
								</tr>
							</thead>
							<tbody style="text-align: center;">

 
<?php
 
$GLOBALS['all_from_captura_where_cautor'] = $api->all_from_captura_where_cautor($_SESSION['uid']);

if (!isset($GLOBALS['all_from_captura_where_cautor']['empty'])) {

 //Se não estiver registrado em sys
 //Se estiver registrado em sys
//if (!isset($api->all_from_sys_where_cid($GLOBALS['all_from_captura_where_cautor'][0]['cid'])['empty'])) {

 //echo "string";
	# code...
//}

//

	for ($i=0; $i < count($GLOBALS['all_from_captura_where_cautor']); $i++) { 

		// Se não estiver em sys
		if (isset($api->all_from_sys_where_cid($GLOBALS['all_from_captura_where_cautor'][$i]['cid'])['empty'])) {

			if (intval($GLOBALS['all_from_captura_where_cautor'][$i]['cstatus']) == 0) {
			?>
			<tr>
				<td>
					<p><?php echo $GLOBALS['all_from_captura_where_cautor'][$i]['ctitulo']; ?></p>
				</td>
				<td>
					<p><?php echo $GLOBALS['all_from_captura_where_cautor'][$i]['ccategoria']; ?></p>
				</td>
				<td>
					<p><?php echo $GLOBALS['all_from_captura_where_cautor'][$i]['cdescricao']; ?></p>
				</td>
				<td> 
					<a href="<?php echo $GLOBALS['all_from_captura_where_cautor'][$i]['csrcfull']; ?>" target="blank" class="button primary large">Ver Imagem</a> 
				</td>
			</tr>
<?php
		}
	}

}	 

}
?>
		
 					   </tbody>

						</table>
					</div>

					<hr class="major" />


					<div class="box">
						<p>Capturas encaminhadas aos avaliadores para processo de análise.</p>
					</div>

					<div class="table-wrapper">
						<table>
							<thead>

								<tr>
					 
									<th>Título</th>
									<th>Categoria</th>
									<th>Descricao</th>
									<th></th>
								</tr>
							</thead>
							<tbody style="text-align: center;">

 
<?php
 
if (!isset($GLOBALS['all_from_captura_where_cautor']['empty'])) {
	for ($i=0; $i < count($GLOBALS['all_from_captura_where_cautor']); $i++) { 

	if (!isset($api->all_from_sys_where_cid($GLOBALS['all_from_captura_where_cautor'][$i]['cid'])['empty'])) {

			if (intval($GLOBALS['all_from_captura_where_cautor'][$i]['cstatus']) == 0) {
			?>
			<tr>
				<td>
					<p><?php echo $GLOBALS['all_from_captura_where_cautor'][$i]['ctitulo']; ?></p>
				</td>
				<td>
					<p><?php echo $GLOBALS['all_from_captura_where_cautor'][$i]['ccategoria']; ?></p>
				</td>
				<td>
					<p><?php echo $GLOBALS['all_from_captura_where_cautor'][$i]['cdescricao']; ?></p>
				</td>
				<td> 
					<a href="<?php echo $GLOBALS['all_from_captura_where_cautor'][$i]['csrcfull']; ?>" target="blank" class="button primary large">Ver Imagem</a> 
				</td>
			</tr>
			<?php
			}
		}
	 }
}
?>
		
 					   </tbody>

						</table>
					</div>

					<hr class="major" />


					<div class="box">
						<p>Capturas já analisadas pelos avaliadores, aguardando a publicação do editor.</p>
					</div>

					<div class="table-wrapper">
						<table>
							<thead>
								<tr>
							 
									<th>Título</th>
									<th>Categoria</th>
									<th>Descricao</th>
									<th></th>
								</tr>
							</thead>
							<tbody style="text-align: center;">

 
<?php
 

if (!isset($GLOBALS['all_from_captura_where_cautor']['empty'])) {

	for ($i=0; $i < count($GLOBALS['all_from_captura_where_cautor']); $i++) { 

		if (intval($GLOBALS['all_from_captura_where_cautor'][$i]['cstatus']) == 2) {

			 if (intval($GLOBALS['all_from_captura_where_cautor'][$i]['cpontos']) > 0) {

			?>
				<tr>
	 
					<td>
						<p><?php echo $GLOBALS['all_from_captura_where_cautor'][$i]['ctitulo']; ?></p>
					</td>
					<td>
						<p><?php echo $GLOBALS['all_from_captura_where_cautor'][$i]['ccategoria']; ?></p>
					</td>
					<td>
						<p><?php echo $GLOBALS['all_from_captura_where_cautor'][$i]['cdescricao']; ?></p>
					</td>
					<td> 
						<a href="<?php echo $GLOBALS['all_from_captura_where_cautor'][$i]['csrcfull']; ?>" target="blank" class="button primary large">Ver Imagem</a> 
					</td>
				</tr>
<?php
			}
		}
	}
	 
}
?>
		
 					   </tbody>

						</table>
					</div>

					<hr class="major" />


					<div class="box">
						<p>Capturas não publicadas por não terem atingido a média de 6 pontos.</p>
					</div>

					<div class="table-wrapper">
						<table>
							<thead>
								<tr>
		 							<th>Pontos</th>
									<th>Título</th>
									<th>Categoria</th>
									<th>Descricao</th>
									<th></th>
								</tr>
							</thead>
							<tbody style="text-align: center;">

 
<?php
 

if (!isset($GLOBALS['all_from_captura_where_cautor']['empty'])) {	
	for ($i=0; $i < count($GLOBALS['all_from_captura_where_cautor']); $i++) { 

		if (intval($GLOBALS['all_from_captura_where_cautor'][$i]['cstatus']) == 2) {

			 if (intval($GLOBALS['all_from_captura_where_cautor'][$i]['cpontos']) > 0 and intval($GLOBALS['all_from_captura_where_cautor'][$i]['cpontos']) < 6) {

			?>
				<tr>


					<td>
						<p><?php echo $GLOBALS['all_from_captura_where_cautor'][$i]['cpontos']; ?></p>
					</td>

					<td>
						<p><?php echo $GLOBALS['all_from_captura_where_cautor'][$i]['ctitulo']; ?></p>
					</td>
					<td>
						<p><?php echo $GLOBALS['all_from_captura_where_cautor'][$i]['ccategoria']; ?></p>
					</td>
					<td>
						<p><?php echo $GLOBALS['all_from_captura_where_cautor'][$i]['cdescricao']; ?></p>
					</td>
					<td> 
						<a href="<?php echo $GLOBALS['all_from_captura_where_cautor'][$i]['csrcfull']; ?>" target="blank" class="button primary large">Ver Imagem</a> 
					</td>
				</tr>
<?php
			}
		}
	}
}

?>
		
 					   </tbody>

						</table>
					</div>

					<hr class="major" />

					<div class="box">
						<p>Capturas publicadas.</p>
					</div>

					<div class="table-wrapper">
						<table>
							<thead>
								<tr>
	 								<th>Pontos</th>
									<th>Título</th>
									<th>Categoria</th>
									<th>Descricao</th>
									<th></th>
								</tr>
							</thead>
							<tbody style="text-align: center;">

 
<?php

if (!isset($GLOBALS['all_from_captura_where_cautor']['empty'])) {

	for ($i=0; $i < count($GLOBALS['all_from_captura_where_cautor']); $i++) { 

		if (intval($GLOBALS['all_from_captura_where_cautor'][$i]['cstatus']) == 3) {
		?>
		<tr>
			<td>
				<p><?php echo $GLOBALS['all_from_captura_where_cautor'][$i]['cpontos']; ?></p>
			</td>
			<td>
				<p><?php echo $GLOBALS['all_from_captura_where_cautor'][$i]['ctitulo']; ?></p>
			</td>
			<td>
				<p><?php echo $GLOBALS['all_from_captura_where_cautor'][$i]['ccategoria']; ?></p>
			</td>
			<td>
				<p><?php echo $GLOBALS['all_from_captura_where_cautor'][$i]['cdescricao']; ?></p>
			</td>
			<td> 
				<a href="<?php echo $GLOBALS['all_from_captura_where_cautor'][$i]['csrcfull']; ?>" target="blank" class="button primary large">Ver Imagem</a> 
			</td>
		</tr>
<?php
		}
	}
	 
}
?>
		
 					   </tbody>

						</table>
					</div>

					<hr class="major" />
				 
				<blockquote>
				Sem nenhuma captura aparecer, não se preocupe. Este sistema é automatizado, foi projetado pensando a sua praticidade e usabilidade. Assim que uma nova captura estiver disponível, aparecerá em seu painel. Se você detectou algum problema técnico, entre em contato conosco para que possamos solucionar-lo.
				</blockquote>
				</section>
 
						<center>&copy; 2020 Astrofotografia Brasil. <br />  Design by HTML5 UP.  <br /> Icons made by Surang. <br/>  Developed by Isak Ruas.</center> 
                        
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

}

?>