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
	require_once('api.php');

	$decrypt = new Decrypt;
	$api = new Editor;

	if (!isset($_SESSION['eid'])) {
		header("Refresh: 0; url=/login.php");
	 	?>
		<meta http-equiv="refresh" content="0; URL='./login.php'"/>
	 	<?php
	} else {

		if (isset($_GET['cid'])) {
			if (is_numeric($decrypt->sha1($_GET['cid']))) {
				$all_sys_cid = $api->all_from_sys_where_cid($decrypt->sha1($_GET['cid']));

				//print_r($all_sys_cid );
				$cpontos = 0;

				for ($i=0; $i < count($all_sys_cid); $i++) { 
					$cpontos = $cpontos + $all_sys_cid[$i]['cpontos'];
					//print_r($all_sys_cid[$i]['cpontos']);
				}

				//print_r($cpontos);
				$cpontos = ceil(($cpontos/count($all_sys_cid)));

				//print_r($cpontos);

				$api->update_captura_sstatus_2_cpontos_where_cid($decrypt->sha1($_GET['cid']), $cpontos);

			 
				$api->update_sys_sstatus_2_where_cid($decrypt->sha1($_GET['cid']));
	 

				?>
				<meta http-equiv="refresh" content="0; URL='./painel.php'"/>
				<?php


			}
		}
	}
?>