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

				$api->update_captura_cstatus_3_where_cid($decrypt->sha1($_GET['cid']));
			 
				$api->update_sys_sstatus_3_where_cid($decrypt->sha1($_GET['cid']));
	 
				?>
				<meta http-equiv="refresh" content="0; URL='./painel.php'"/>
				<?php
			}
		}
	}
?>