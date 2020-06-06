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

	$api = new Editor;

	if (!isset($_SESSION['eid'])) {
		header("Refresh: 0; url=/login.php");
		?>
		<meta http-equiv="refresh" content="0; URL='./login.php'"/>
		<?php

	} else {
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
							<span class="label">Olá, <?php echo $_SESSION['enome']; ?>.</span> 
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
 						<a href="./capturas_publicadas.php" class="button primary large">CAPTURAS PUBLICADAS</a> 
					</div>
					<br /><br /><br />
					<div   class="col-4 col-12-medium">
					</div>
				</div>


				<!-- Content -->
				<section>

					<div class="box">
						<p>Abaixo são listadas as capturas que ainda não foram submetidas aos(às) avaliadores(as). Ao clicar em <strong>SUBMETER PARA ANÁLISE</strong> você será direcionado a um painel no qual poderá escolher quem serão os avaliadores. Você poderá escolher quantos avaliadores achar conveniente, sugerimos que escolha no minimo  3.</p>
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
									<th></th>
								</tr>
							</thead>
							<tbody>
<?php
	//Busca em 'captura' imagens com 'cpoints' = 0, se não existir em 'sys' o 'cid' a imagen não foi submetida para analise
	$GLOBALS['all_from_captura_where_cpontos_0'] = $api->all_from_captura_where_cpontos(0);
	//print_r($all_from_captura_where_cpontos_0);
	$GLOBALS['captura_fora_de_processamento'] = [];
	if (!isset($GLOBALS['all_from_captura_where_cpontos_0']['empty'])) {
		for ($i=0; $i < count($GLOBALS['all_from_captura_where_cpontos_0']); $i++) {
			$captura_cpontos_0_tmp = $api->cid_from_sys_where_cid($GLOBALS['all_from_captura_where_cpontos_0'][$i]['cid']);
			//print_r($captura_cpontos_0_tmp);
			if (isset($captura_cpontos_0_tmp['empty'])) {
				//Não estão em processamento
				$GLOBALS['captura_fora_de_processamento'][] = array("cid" => $GLOBALS['all_from_captura_where_cpontos_0'][$i]['cid']);
			}
		}
		//print_r($GLOBALS['captura_fora_de_processamento']);
		for ($i=0; $i < count($GLOBALS['captura_fora_de_processamento']); $i++) { 

			for ($j=0; $j < count($GLOBALS['all_from_captura_where_cpontos_0']); $j++) {
				//print_r($GLOBALS['all_from_captura_where_cpontos_0'][$j]['cid']);
				//print_r($GLOBALS['captura_fora_de_processamento'][$i]['cid']);

				if($GLOBALS['all_from_captura_where_cpontos_0'][$j]['cid'] == $GLOBALS['captura_fora_de_processamento'][$i]['cid']){

					$captura = $GLOBALS['all_from_captura_where_cpontos_0'][$j];
					//print_r($captura);
					?>
					<tr>
 
						<td>
							<p><?php echo $captura['cautor']; ?></p>
						</td>
						<td>
							<p><?php echo $captura['ctitulo']; ?></p>
						</td>
						<td>
							<p><?php echo $captura['ccategoria']; ?></p>
						</td>
						<td>
							<p><?php echo $captura['cdescricao']; ?></p>
						</td>

						<td> 
							<a href="<?php echo $captura['csrcfull']; ?>" target="blank" class="button primary large">Ver Imagem</a> 
						</td>
						<td>
							<a href="./submeter_para_analise.php?cid=<?php echo sha1($captura['cid']);  ?>" class="button primary large">SUBMETER PARA ANÁLISE</a> 
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
						<p>Abaixo são listadas as capturas que já foram submetidas ao processo de análise, as que o exibem o botão  <strong>CLASSIFICAR</strong> já receberam as notas dos (as) avaliadores (as), ao clicar neste botão calcularemos a média das notas, caso for uma valor maior ou igual a 6 em uma escala de 0 a 10, a captura estará apta para publicação.</p>
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
									<th></th>
								</tr>
							</thead>
							<tbody>

<?php
	//Busca em 'captura' imagens com 'cpoints' = 0, se não existir em 'sys' o 'cid' a imagen não foi submetida para analise
	//print_r($all_from_captura_where_cpontos_0);
	$GLOBALS['captura_em_processamento'] = [];

	if (!isset($GLOBALS['all_from_captura_where_cpontos_0']['empty'])) {
		for ($i=0; $i < count($GLOBALS['all_from_captura_where_cpontos_0']); $i++) {
			$captura_cpontos_0_tmp = $api->cid_from_sys_where_cid($GLOBALS['all_from_captura_where_cpontos_0'][$i]['cid']);
			//print_r($captura_cpontos_0_tmp);
			if (!isset($captura_cpontos_0_tmp['empty']))   {
				//Não estão em processamento
				$GLOBALS['captura_em_processamento'][] = array("cid" => $GLOBALS['all_from_captura_where_cpontos_0'][$i]['cid']);
			}
		}
		//print_r($GLOBALS['captura_em_processamento']);
		for ($i=0; $i < count($GLOBALS['captura_em_processamento']); $i++) { 

			for ($j=0; $j < count($GLOBALS['all_from_captura_where_cpontos_0']); $j++) {
				//print_r($GLOBALS['all_from_captura_where_cpontos_0'][$j]['cid']);
				//print_r($GLOBALS['captura_em_processamento'][$i]['cid']);

				if($GLOBALS['all_from_captura_where_cpontos_0'][$j]['cid'] == $GLOBALS['captura_em_processamento'][$i]['cid']){

					$captura = $GLOBALS['all_from_captura_where_cpontos_0'][$j];
					//print_r($captura);
					?>
					<tr>
	 
						<td>
							<p><?php echo $captura['cautor']; ?></p>
						</td>
						<td>
							<p><?php echo $captura['ctitulo']; ?></p>
						</td>
						<td>
							<p><?php echo $captura['ccategoria']; ?></p>
						</td>
						<td>
							<p><?php echo $captura['cdescricao']; ?></p>
						</td>

						<td> 
							<a href="<?php echo $captura['csrcfull']; ?>" target="blank" class="button primary large">Ver Imagem</a> 
						</td>
						<td>

							<?php 
								if (intval($captura['cstatus']) == 2) {
							?>

							<a href="./clasificar.php?cid=<?php echo sha1($captura['cid']);  ?>" class="button primary large">CLASSIFICAR</a> 
		
							<?php
								}
							?>
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
						<p>Abaixo são listadas as capturas que já foram analisadas e obtiveram o nota mínima de 6 pontos, ao clicar em <strong> PUBLICAR </strong>estas capturas serão disponibilizadas no aplicativo mobile e <i>website</i>. Sugerimos que aguarde a acumulação das imagens e as publique periodicamente em um intervalo semanal, mensal ou trimestral.</p>
					</div>

					<div class="table-wrapper">
						<table>
							<thead>
								<tr>
		 
									<th>Autor</th>
									<th>Pontos</th>
									<th>Título</th>
									<th>Categoria</th>
									<th>Descricao</th>
									<th> </th>
									<th> </th>
								</tr>
							</thead>
							<tbody>
<?php
//Busca em 'captura' imagens com 'cpoints' > 0, imagens já clasificadas,  se 'captura.cstatus' = 0,
 //a imagem não foi publicada,[ = 1, publicada, = 2, desclasificada.] ordenar do maior 'cpoints' para o 
 //menor. Minimo de 7 pontos para ser publicada 
					
	$cidCapturaPontosMaiorQueZero = [];

	$captura_where_cpontos_bigger_6 = $api->all_from_captura_where_cpontos_bigger(6);

	if (!isset($captura_where_cpontos_bigger_6['empty'])) {
 
		for ($i=0; $i < count($captura_where_cpontos_bigger_6); $i++) { 
		 
			if ($captura_where_cpontos_bigger_6[$i]['cstatus'] == 2) {
				 
		?>

		<tr>
 
			<td>
				<p><?php echo $captura_where_cpontos_bigger_6[$i]['cautor']; ?></p>
			</td>
			<td>
				<p><?php echo $captura_where_cpontos_bigger_6[$i]['cpontos']; ?></p>
			</td>
			<td>
				<p><?php echo $captura_where_cpontos_bigger_6[$i]['ctitulo']; ?></p>
			</td>
			<td>
				<p><?php echo $captura_where_cpontos_bigger_6[$i]['ccategoria']; ?></p>
			</td>
			<td>
				<p><?php echo $captura_where_cpontos_bigger_6[$i]['cdescricao']; ?></p>
			</td>
			<td> 
				<a href="<?php echo $captura_where_cpontos_bigger_6[$i]['csrcfull']; ?>" target="blank" class="button primary large">Ver Imagem</a> 
			</td>
 
			<td> 
				<a href="./publicar.php?cid=<?php echo sha1($captura_where_cpontos_bigger_6[$i]['cid']);  ?>"   class="button primary large">Publicar</a> 
			</td>
		</tr>
<?php

			}


			/*

			if ($captura_where_cpontos_bigger_6[$i]['cstatus'] == 3) {
				 
		?>

		<tr>
			<td>
				<p><?php echo $captura_where_cpontos_bigger_6[$i]['cid'];  ?></p>
			</td>
			<td>
				<p><?php echo $captura_where_cpontos_bigger_6[$i]['cautor']; ?></p>
			</td>
			<td>
				<p><?php echo $captura_where_cpontos_bigger_6[$i]['cpontos']; ?></p>
			</td>
			<td>
				<p><?php echo $captura_where_cpontos_bigger_6[$i]['ctitulo']; ?></p>
			</td>
			<td>
				<p><?php echo $captura_where_cpontos_bigger_6[$i]['ccategoria']; ?></p>
			</td>
			<td>
				<p><?php echo $captura_where_cpontos_bigger_6[$i]['cdescricao']; ?></p>
			</td>
			<td> 
				<a href="<?php echo $captura_where_cpontos_bigger_6[$i]['csrcfull']; ?>" target="blank" class="button primary large">Ver Imagem</a> 
			</td>
 
			<td> 
			</td>
		</tr>
<?php

			}


*/






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

}

?>