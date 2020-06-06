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

require_once('../assets/php/decrypt.php');

$decrypt = new Decrypt;

session_start();

if (isset($_GET['sair'])) {
	session_cache_expire();
	session_unset();
	session_destroy();
	header("Refresh: 0; url=?");
?>
	<meta http-equiv="refresh" content="0; URL='./?'"/>
<?php

}


include_once('api.php');
$api = new Avaliador;

if (isset($_POST['lpassword']) && isset($_POST['lemail']) ) {

	$avaliador = $api->doLogin($_POST['lemail'], $_POST['lpassword']);

	if (isset($avaliador['aid'])) {
		$_SESSION['aid'] = $avaliador['aid'];
		$_SESSION['anome'] = $avaliador['anome'];
		$_SESSION['aemail'] = $avaliador['aemail'];
	}
}

if(isset($_POST['pcid']) && isset($_POST['ppoints']) && isset($_SESSION['aid'])) {
	#header("Refresh: 0; url=?");
	$captura = $api->upCaptura($_SESSION['aid'], $decrypt->sha1($_POST['pcid']), $_POST['ppoints']);
	if($captura['status'] == "success") {
		header("Refresh: 0; url=?");
	}
}

?>

<!DOCTYPE HTML>
<!--
Prologue by HTML5 UP
html5up.net | @ajlkn
Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
<head>
	<title>Astrofotografia Brasil - Avaliador</title>
	<meta charset="utf-8" />
	<link rel="icon" href="favicon.png">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
	<link rel="stylesheet" href="assets/css/main.css" />
</head>
<body class="is-preload">


<?php

if (!isset($_SESSION['aid'])) {

?>

		<div id="header">

			<div class="top">

				<!-- Nav -->
					<nav id="nav">
						<!--ul>
							<li>
								<a href="#" id="portfolio-link">
									<span class="icon solid  fa-window-close">SOBRE</span>
								</a>
							</li>
						</ul-->
<svg  style="position:absolute; left:50%;  margin-left:-64px; top:50%; margin-top:-64px;" height="128px" viewBox="0 0 488 488" width="128px" xmlns="http://www.w3.org/2000/svg"><path d="m392 312 32-32 32 32-32 32zm0 0" fill="#cb9e78"/><path d="m136 392c-17.671875 0-32-14.328125-32-32 0 17.671875-14.328125 32-32 32 17.671875 0 32 14.328125 32 32 0-17.671875 14.328125-32 32-32zm0 0" fill="#eebc5a"/><path d="m336 168 16-16-24-24-88 88 24 24 16-16" fill="#575c61"/><path d="m407.996094 352.003906 55.996094-55.996094 24 24-55.996094 55.996094zm0 0" fill="#575c61"/><path d="m279.996094 224.003906 56-55.996094 104 104-56 55.996094zm0 0" fill="#d9d7d8"/><path d="m279.996094 224.003906 40-40 87.996094 88-40 39.996094zm0 0" fill="#efedee"/><path d="m328 272v80h32v-48zm0 0" fill="#cb9e78"/><path d="m328 272v80h16v-64zm0 0" fill="#dbaf89"/><path d="m328 408-80 80h48l32-32" fill="#bc8f6f"/><path d="m360 408 80 80h-48l-32-32" fill="#bc8f6f"/><path d="m328 400v88h32v-88" fill="#cb9e78"/><path d="m328 400v88h16v-88" fill="#dbaf89"/><path d="m376 376c0 17.671875-14.328125 32-32 32s-32-14.328125-32-32 14.328125-32 32-32 32 14.328125 32 32zm0 0" fill="#dcb29c"/><path d="m488 160c-17.671875 0-32-14.328125-32-32 0 17.671875-14.328125 32-32 32 17.671875 0 32 14.328125 32 32 0-17.671875 14.328125-32 32-32zm0 0" fill="#5789d6"/><path d="m408 64c-17.671875 0-32-14.328125-32-32 0 17.671875-14.328125 32-32 32 17.671875 0 32 14.328125 32 32 0-17.671875 14.328125-32 32-32zm0 0" fill="#ca5057"/><path d="m120 256c0 30.929688-25.070312 56-56 56s-56-25.070312-56-56 25.070312-56 56-56 56 25.070312 56 56zm0 0" fill="#5789d6"/><path d="m104 256c0-30.574219-21.492188-55.359375-48-55.359375s-48 24.785156-48 55.359375 21.492188 55.359375 48 55.359375 48-24.785156 48-55.359375zm0 0" fill="#699ce6"/><path d="m8 256c0 11.199219 3.320312 21.609375 8.984375 30.359375l23.015625-38.359375v-42.535156c-18.902344 8.992187-32 28.207031-32 50.535156zm0 0" fill="#70b48f"/><path d="m120 256c0-28.207031-20.871094-51.472656-48-55.359375v31.359375l24 32h23.359375c.375-2.617188.640625-5.28125.640625-8zm0 0" fill="#599072"/><path d="m72 205.511719v26.488281l24 32h7.359375c.375-2.617188.640625-5.28125.640625-8 0-22.320312-13.097656-41.511719-32-50.488281zm0 0" fill="#70b48f"/><path d="m264 328c0 26.507812-21.492188 48-48 48s-48-21.492188-48-48 21.492188-48 48-48 48 21.492188 48 48zm0 0" fill="#f8cf6a"/><path d="m240 96c0 48.601562-39.398438 88-88 88s-88-39.398438-88-88 39.398438-88 88-88 88 39.398438 88 88zm0 0" fill="#70b48f"/><path d="m144 64c0 8.835938-7.164062 16-16 16s-16-7.164062-16-16 7.164062-16 16-16 16 7.164062 16 16zm0 0" fill="#ca5057"/><path d="m192 128c0 13.253906-10.746094 24-24 24s-24-10.746094-24-24 10.746094-24 24-24 24 10.746094 24 24zm0 0" fill="#eebc5a"/><g fill="#d9d7d8"><path d="m343.996094 288 24.003906-24.003906 11.3125 11.3125-24.003906 24.003906zm0 0"/><path d="m298.339844 242.34375 24.003906-24.003906 11.3125 11.3125-24 24.003906zm0 0"/><path d="m152 192c-52.9375 0-96-43.0625-96-96s43.0625-96 96-96 96 43.0625 96 96-43.0625 96-96 96zm0-176c-44.113281 0-80 35.886719-80 80s35.886719 80 80 80 80-35.886719 80-80-35.886719-80-80-80zm0 0"/><path d="m168 160c-17.648438 0-32-14.351562-32-32s14.351562-32 32-32 32 14.351562 32 32-14.351562 32-32 32zm0-48c-8.824219 0-16 7.175781-16 16s7.175781 16 16 16 16-7.175781 16-16-7.175781-16-16-16zm0 0"/><path d="m145.28125 143.960938c-69.96875-.882813-145.28125-16.265626-145.28125-47.960938 0-22.832031 37.457031-34.800781 68.878906-40.824219l3.007813 15.71875c-40.71875 7.800781-55.886719 19.539063-55.886719 25.105469 0 10.585938 44.472656 30.886719 129.480469 31.960938zm0 0"/><path d="m191.71875 142.488281-1.246094-15.953125c68.917969-5.390625 97.527344-22.550781 97.527344-30.535156 0-5.648438-15.464844-17.511719-56.96875-25.3125l2.953125-15.71875c31.945313 6 70.015625 17.984375 70.015625 41.03125 0 27.800781-58 42.230469-112.28125 46.488281zm0 0"/></g><path d="m56 272h16v16h-16zm0 0" fill="#70b48f"/><path d="m216 384c-30.878906 0-56-25.128906-56-56s25.121094-56 56-56 56 25.128906 56 56-25.121094 56-56 56zm0-96c-22.054688 0-40 17.945312-40 40s17.945312 40 40 40 40-17.945312 40-40-17.945312-40-40-40zm0 0" fill="#d9d7d8"/><path d="m216 352c-42.382812 0-88-10.015625-88-32 0-18.328125 30.425781-26.039062 48.550781-29l2.578125 15.800781c-27.097656 4.421875-34.714844 11.75-35.144531 13.328125 1.222656 4.191406 25.207031 15.871094 72.015625 15.871094s70.792969-11.679688 72.007812-16.121094c-.433593-1.335937-8.046874-8.664062-35.144531-13.085937l2.578125-15.800781c18.144532 2.96875 48.558594 10.679687 48.558594 29.007812 0 21.984375-45.617188 32-88 32zm0 0" fill="#d9d7d8"/></svg>



					</nav>

			</div>

		</div>

		<div id="main">
			<!-- Contact -->
				<section id="contact" class="one">
					<div class="container">
						<header>
							<h2>ASTROFOTOGRAFIA BRASIL - AVALIADOR</h2>
						</header>
						<form method="post" action="?">
							<div class="row">
								<div class="col-12 ">
									<input type="text" name="lemail" placeholder="astrofotografia@nrolabs.com" required/>
								</div>
								<div class="col-12 ">
									<input type="password" name="lpassword" placeholder="astrofotografia" required/>
								</div>

								<div class="col-12">
									<input type="submit" value="ENTRAR" />
								</div> 
							</div>
						</form>

					</div>
				</section>
		</div>

<?php
	  
} else {

?>

	<!-- Header -->
		<div id="header">

			<div class="top">

				<!-- Logo -->
					<div id="logo">
						<!--span class="image avatar48"><img src="images/avatar.jpg" alt="" /></span-->
						<h1 id="title"><a href="?"><?php echo $_SESSION['anome']; ?></a></h1>
						<p><?php echo $_SESSION['aemail']; ?></p>
					</div>
				<!-- Nav -->
					<nav id="nav">
						<ul>
							<li><a href="?sair" id="portfolio-link"><span class="icon solid  fa-window-close">SAIR</span></a></li>
						</ul>
					</nav>

			</div>

		</div>

	<!-- Main -->
		<div id="main">

			<?php

				if (!isset($_GET['cid'])) {

			?>

			<section id="capturas" class="one">
				<div class="container">

						<header>
							<h2>ASTROFOTOGRAFIA BRASIL - AVALIADOR</h2>
						</header>

						<p style=" text-align: justify; padding-left: 1cm;padding-right: 1cm;" >Olá <?php echo $_SESSION['anome']; ?>, seja bem vindo(a). Com as suas contribuições nossa plataforma irá se ampliar mais a cada dia. Assim que alguma astrofotografia tiver disponível para ser avaliada, ela será listada nesta página. Com alguns cliques e sua experiência, poderemos filtrar as melhores! Somos gratos por suas contribuições. Juntos fazemos mais!</p>


					<div class="row">
					 
						<?php

							$sys = $api->getSys($_SESSION['aid']);

					 
							if (!isset($sys['status'])) {

								for ($i=0; $i < count($sys); $i++) { 
								 
									$captura = $api->getCaptura($sys[$i]['cid']);
								
						?>
								<article class="item">
									<a href="?cid=<?php echo sha1($captura['cid']); ?>" class="image fit">

										<img src="<?php echo $captura['csrcsmall']; ?>" alt="" />
									</a>
									<header>
										<h3><?php echo $captura['ccategoria']; ?></h3>
									</header>
								</article>

						<?php
								}
							}  

						?>
	
					</div>
				</div>
			</section>

			<?php
					 
				} else {

			?>



				<?php

					$captura = $api->getCaptura($decrypt->sha1($_GET['cid']));

					if (!isset($captura['status'])) {

				?>

			<section id="captura" class="one">
				<div class="container">
					<a href="#" class="image featured"><img src="<?php echo $captura['csrcfull']; ?>" alt="" /></a>
				</div>


<p style=" text-align: justify; padding-left: 1cm;padding-right: 1cm;"> <strong>Categoria</strong>: <?php echo $captura['ccategoria']; ?></p>	
		
<p style=" text-align: justify; padding-left: 1cm;padding-right: 1cm;"> <strong>Título</strong>: <?php echo $captura['ctitulo']; ?></p>

<p style=" text-align: justify; padding-left: 1cm;padding-right: 1cm;"> <strong>Descrição</strong>: <?php echo $captura['cdescricao']; ?></p>						

			</section>

 
			<section id="avaliar" class="one">
				<div class="container">

						<p style=" text-align: justify; padding-left: 1cm;padding-right: 1cm;">Para avaliar, arraste o controle deslizante para esquerda ou para direita. Quanto mais a esquerda o controle deslizante se encontra menor é a nota, de forma análoga, quanto mais para direita o controlador se encontra, maior é a nota. Só é possível avaliar uma imagem uma única vez, ou seja, só clique em AVALIAR quando tiver decidido a merecida nota.</p>
						<header>
							<h3 id="_ppoints">5</h3>
						</header>
						<script type="text/javascript">
							function onChangePoints(value) {
								document.getElementById("_ppoints").innerHTML = value
							}
						</script>
					<form method="post" action="?">

						<div class="row">
							<div class="col-12"> 
								<input type="text" style="display: none" name="pcid" value="<?php echo sha1($captura['cid']); ?>">
							</div>
							<div class="col-12">
								<input type="range" name="ppoints" value="5" min="0" max="10" onchange="onChangePoints(this.value)">
							</div>
							<div class="col-12">
								<input type="submit" value="AVALIAR" />
							</div>
						</div>
					</form>

				</div>
			</section>

				<?php

					} else {
						header("Refresh: 0; url=?");
					}
					
				?>

			<?php
					
				}

			?>
		</div>

	<!-- Footer -->
		<div id="footer">

			<!-- Copyright -->
				<ul class="copyright">
					<li>&copy; 2020 Nrọlabs Desenvolvimento de Softwares.</li><li>Design by HTML5 UP.</li>
				</ul>

		</div>

<?php
	
}

?>

	<!-- Scripts -->
		<script src="assets/js/jquery.min.js"></script>
		<script src="assets/js/jquery.scrolly.min.js"></script>
		<script src="assets/js/jquery.scrollex.min.js"></script>
		<script src="assets/js/browser.min.js"></script>
		<script src="assets/js/breakpoints.min.js"></script>
		<script src="assets/js/util.js"></script>
		<script src="assets/js/main.js"></script>

</body>
</html>