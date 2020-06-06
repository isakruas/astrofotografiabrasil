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

require_once('../assets/php/util.php');
require_once('../assets/php/config.php');

class Usuario extends Util {

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

 	public function doLogin($uemail, $usenha){
		if(!empty($uemail) and !empty($usenha)){ // empty checker
			$query="SELECT uid, uemail, unome, usenha, ustatus, udata FROM usuario WHERE usenha = '".$usenha."' AND uemail = '$uemail' LIMIT 1";
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

 	public function insert_usuario($query){
		if ($this->mysqli->query($query)) {

			$a['success'] = '';
			return  $a;

		} else {
			
			$a['error'] = '';
			return  $a;

		}
	}

 	public function insert_captura($query) {
		if ($this->mysqli->query($query)) {
			$query = "SELECT * FROM `captura` WHERE `cid` = LAST_INSERT_ID();";
			$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
			if($r->num_rows > 0) {
				$result = $r->fetch_assoc();
					return $result;
			} else {
				$a['error'] = '';
				return  $a;
			}
		} else {
			$a['error'] = '';
			return  $a;
		}
	}


 	public function insert_astrometria($query){
		if ($this->mysqli->query($query)) {
			$query = "SELECT * FROM `astrometria` WHERE `id` = LAST_INSERT_ID();";
			$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
			if($r->num_rows > 0) {
				$result = $r->fetch_assoc();
					return $result;
			} else {
				$a['error'] = '';
				return  $a;
			}
		} else {
			$a['error'] = '';
			return  $a;
		}
	}


	public function count_uemail_from_usuario_where_uemail($uemail) {
		$query="SELECT COUNT(uemail) FROM usuario WHERE uemail = '$uemail'";
		$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
		if($r->num_rows > 0){
			while($row = $r->fetch_assoc()){
				$result[] = $row;
			}
			return $result;
		} else {
			$a['empty'] = '';
			return  $a;
		} 

	}



 	public function all_from_sys_where_cid($cid){

		$query="SELECT * FROM sys WHERE cid = $cid";
		 
		$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
		if($r->num_rows > 0) {
			$result = $r->fetch_assoc();
			return $result;
		} else {
			$a['empty'] = '';
			return  $a;
		}
	}




 	public function all_from_captura_where_cautor($cautor){

		$query="SELECT * FROM captura WHERE cautor = $cautor";

		$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);

		if($r->num_rows > 0){
			while($row = $r->fetch_assoc()){
				$result[] = $row;
			}
			return $result;
		} else {
			$a['empty'] = '';
			return  $a;
		} 
	}



	
}
?>

