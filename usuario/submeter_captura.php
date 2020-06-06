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

	error_reporting(-1);
 	define('URL', "https://astrofotografia.nrolabs.com/usuario/");
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
 						<a href="./painel.php" class="button primary large">PAINEL</a> 
					</div>
					<br /><br /><br />
					<div   class="col-4 col-12-medium">
					</div>
				</div>


				<!-- Content -->
				<section>
					<script type="text/javascript">
						
						setInterval(function(){

							if (document.getElementById('ucaptura').value=='') {
								document.getElementById('label_ucaptura').innerHTML ='SELECIONAR ARQUIVO';
								document.getElementById('label_ucaptura').style.background ='#fff';
								document.getElementById('label_ucaptura').style.color ='#000';
							} else {
								document.getElementById('label_ucaptura').innerHTML ='ARQUIVO SELECIONADO';
								document.getElementById('label_ucaptura').style.background ='#34a58e';
								document.getElementById('label_ucaptura').style.color ='#fff';
							}

						}, 3000);
					</script>


<?php 
	if(isset($_FILES["ucaptura"]) && isset($_POST['utitulo']) && isset($_POST['ucategoria']) && isset($_POST['udescricao'])) {
		


	 
	$date = date("Y-m-d H:i:s");
	$name = sha1($date);
	$small_api = "https://astrofotografia.nrolabs.com/usuario/thumb.php";
	//$small_api = "http://localhost/astrofotografia/usuario/thumb.php";
	$base_path_full = "./full/";
	$base_path_small = "./small/";
	$max_filesize = 15485760; //10mb
	$allowed_ext = array('jpg', 'jpeg','JPG', 'JPEG'); //somente jpg

	 
 
		$file_size = $_FILES['ucaptura']['size'];

 		if ($file_size > $max_filesize) {

			//die('Arquivo maior que o permitido');
?>
				<div class="box">
				Ops :( ! ... Tivemos alguns problemas ao processar sua solicitação.  O arquivo no qual selecionou excedeu o tamanho máximo permitido. Lamentamos pelo ocorrido, estamos trabalhando para possibilitar um maior armazenamento de arquivos em nossos servidores. Por favor, selecione uma imagem com no máximo 10MB. COD:001.
			</div>
<?php


		} else {

			$fileinfo = pathinfo($_FILES['ucaptura']['name']);
			$file_ext = $fileinfo['extension'];

			if (in_array($file_ext, $allowed_ext) === false ) {

				//die('Extensão não permitida');
?>
				<div class="box">
				Ops :( ! ... Tivemos alguns problemas ao processar sua solicitação. Só processamos imagens com extensão  <strong>.jpg</strong>. Por favor, selecione um arquivo adequado.

				</div>
<?php


			}  else {
	
				if (file_exists($base_path_full."/".$name.".".$file_ext)) {

			//		die('O Arquivo já foi enviado');
?>
				<div class="box">
				Ops :( ! ... Tivemos alguns problemas ao processar sua solicitação, por favor tente novamente dentro de alguns instantes. Isto pode acontecer devido diversos fatores, como sobrecarga de nossos servidores eu erros de comunicação da sua internet. COD:002.
				</div>
<?php

				} else {

					$file_name = $_FILES['ucaptura']['name'];
					$file_tmp  = $_FILES['ucaptura']['tmp_name'];

					$i = explode(".", $file_name);
					$file_ext  = $i[count($i)-1];

					if(move_uploaded_file($file_tmp, $base_path_full."/".$name.".".$file_ext)){
						//die ("Agradecemos por sua participação, se sua imagem for classificada aparecerá aqui em breve, boa sorte!");
						$curl = curl_init();
						curl_setopt_array($curl, [
						    CURLOPT_RETURNTRANSFER => 1,
						    CURLOPT_URL => $small_api."?file=".$base_path_full."/".$name.".".$file_ext."&sizex=360",
						]);
						$resp = curl_exec($curl);
						curl_close($curl);

						if ($resp == true) {

							include_once('api.php');
							
							$query = "INSERT INTO `captura`(`cid`, `cpontos`, `cautor`, `ctitulo`, `ccategoria`, `cdescricao`, `csrcfull`, `csrcsmall`, `cstatus`, `cdata`) VALUES (null,0,'".$_SESSION['uid']."','".$_POST['utitulo']."','".$_POST['ucategoria']."','".$_POST['udescricao']."','".URL."full/?l=".$name."','".URL."small/?l=".$name."',0,'".date("Y-m-d H:i:s")."')";

							$api = new Usuario;
							$sql = $api->insert_captura($query);

							if(isset($sql['cid'])) {

 
								$python = shell_exec('python astrometry.py --apikey=ezyjswfcrpsmkgan --urlupload='.$sql['csrcfull'].' --private');
								#$python = '{"status": "success", "subid": 3583093, "hash": "6d0b351f1b4e2b7553abae223e8c9dc85893663b"}';

								$astrometry = json_decode($python);

								if ($astrometry->status == 'success') {
									if ($astrometry->subid) {
										$subid = $astrometry->subid;
										$hash = $astrometry->hash;
										$cid = $sql['cid'];

										$query = "INSERT INTO `astrometria`(`id`, `cid`, `subid`, `hash`) VALUES (null,".$cid.",".$subid.",'".$hash."');";

										$sql = $api->insert_astrometria($query);
									}
								}
 
?>
				<div class="box">
				Recebemos sua captura! Em breve analisaremos se está de acordo com nossa política editorial, caso tudo certo, será encaminhada para os avaliadores. Você poderá acompanhar o progresso deste processo em seu painel.
				</div>
<?php

								//die('Inserido no banco de dados');


							} else {
								unlink($base_path_full."/".$name.".".$file_ext);
								unlink($base_path_small."/".$name.".".$file_ext);
								//die('Não inserido no banco de dados');

?>
				<div class="box">
				Ops :( ! ... Tivemos alguns problemas ao processar sua solicitação, por favor tente novamente dentro de alguns instantes. Isto pode acontecer devido diversos fatores, como sobrecarga de nossos servidores eu erros de comunicação da sua internet. COD:003.
				</div>
<?php
							}

						}  else {

							unlink($base_path_full."/".$name.".".$file_ext);

							if (file_exists($base_path_small."/".$name.".".$file_ext)) {
								unlink($base_path_small."/".$name.".".$file_ext);
							}
?>
				<div class="box">
				Ops :( ! ... Tivemos alguns problemas ao processar sua solicitação, por favor tente novamente dentro de alguns instantes. Isto pode acontecer devido diversos fatores, como sobrecarga de nossos servidores eu erros de comunicação da sua internet. COD:004.
				</div>
<?php
							//die('Erro na criação da miniatura');
						}
					}

				}
			}
		}
 










	} else {
?>
 

				<form method="post" action="" enctype="multipart/form-data">
					<div class="row gtr-uniform">
						<div class="col-6 col-12-xsmall">
							<input type="text" name="utitulo" id="utitulo" value="" placeholder="Título" required />
						</div>
						<div class="col-6 col-12-xsmall">
				 
							<input type="file" style="display: none !important;" name="ucaptura" id="ucaptura" value=""  required/>
							<label  style="background: #fff; height: 100%;text-align: center;padding-top: 1.7%; cursor: pointer;border-radius: 0.375em;" for='ucaptura' id="label_ucaptura">SELECIONAR ARQUIVO</label>

						</div>
						<!-- Break -->
						<div class="col-12">
							<select name="ucategoria" id="ucategoria" required>
								<option value="">- Categoria -</option>
								<option value="DSOs">DSOs</option>
								<option value="Sistema Solar">Sistema Solar</option>
								<option value="Solares">Solares</option>
								<option value="Panorâmicas">Panorâmicas</option>
							</select>
						</div>
 
						<!-- Break -->
						<div class="col-12">
							<textarea name="udescricao" id="udescricao" placeholder="Descrição" rows="6" required></textarea>
						</div>
						<!-- Break -->
						<div class="col-12">
							<ul class="actions">
								<li><input type="submit" value="SUBMETER " class="primary" /></li>
							 	 <li><input type="reset" value="APAGAR TODO FORMULÁRIO" /></li>
							</ul>
						</div>
					</div>
				</form>

<?php

}

?>
				<hr class="major" />


				 
 
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