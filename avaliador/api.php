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

require_once('../assets/php/util.php');
require_once('../assets/php/config.php');

class Avaliador extends Util {
  
    private $db = NULL;
    private $mysqli = NULL;

    public function __construct(){
        parent::__construct();
        $this->dbConnect();
    }

    private function dbConnect(){
        $this->mysqli = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB);
        $this->mysqli->query('SET CHARACTER SET utf8');
    }

 	public function doLogin($aemail, $asenha){
		if(!empty($aemail) and !empty($asenha)){
			$query="SELECT  aid, aemail, anome, asenha FROM avaliador WHERE asenha = '".$asenha."' AND aemail = '$aemail' LIMIT 1";
			$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
			if($r->num_rows > 0) {
				$result = $r->fetch_assoc();
						return $result;
			} else {
				$a['status'] = 'error';
				return  $a;
			}
		}
	}

 	public function getSys($aid){

		$query="SELECT  sid, aid, cid, cpontos, sstatus FROM sys WHERE aid = '".$aid."' AND sstatus = 0";
		$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
		if($r->num_rows > 0){
			while($row = $r->fetch_assoc()){
				$result[] = $row;
			}
			return $result;
		} else {
			$a['status'] = 'error';
			return  $a;
		} 
	}

 	public function getCaptura($cid){

		$query="SELECT  cid, cpontos, cautor, ctitulo, ccategoria, cdescricao, csrcfull, csrcsmall, cstatus FROM captura WHERE cid = '".$cid."'";
		$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
		if($r->num_rows > 0) {
			$result = $r->fetch_assoc();
			 return $result;
		} else {
			$a['status'] = 'error';
			return  $a;
		}
	}

 	public function upCaptura($aid, $cid, $cpontos){

		$query_1="UPDATE sys SET cpontos=$cpontos, sstatus = 2 WHERE aid = $aid AND cid = $cid";
		$query_2="SELECT COUNT(cid) FROM sys WHERE cid = $cid AND sstatus = 0";
		$query_3="UPDATE captura SET cstatus = 2 WHERE cid = $cid";
		$result = [];

		if ($this->mysqli->query($query_1)) {
			
			$r = $this->mysqli->query($query_2) or die($this->mysqli->error.__LINE__);
		
			if($r->num_rows > 0){
				while($row = $r->fetch_assoc()){
					$result[] = $row;
				}
			} 

			if (intval($result[0]['COUNT(cid)']) == 0) {
				if ($this->mysqli->query($query_3)) {
					$a['status'] = 'success';
					return  $a;
				} else {
					$a['status'] = 'error';
					return  $a;
				}
			}

			$a['status'] = 'success';
			return  $a;

		} else {
			$a['status'] = 'error';
			return  $a;
		}
	}
}

?>

