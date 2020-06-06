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

class Editor extends Util {
  
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

 	public function doLogin($eemail, $esenha){
		if(!empty($eemail) and !empty($esenha)){ // empty checker
			$query="SELECT  eid, eemail, enome, esenha FROM editor WHERE esenha = '".$esenha."' AND eemail = '$eemail' LIMIT 1";
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

 	public function all_from_captura_where_cpontos($cpontos){

		$query="SELECT * FROM captura WHERE cpontos = $cpontos";

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

 	public function cid_from_sys_where_cid($cid){

		$query="SELECT cid FROM sys WHERE cid = $cid";
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
 	public function sid_from_sys_where_cid($cid) {

		$query="SELECT sid FROM sys WHERE cid = $cid";

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

 	public function all_from_sys_where_cid($cid) {

		$query="SELECT * FROM sys WHERE cid = $cid";

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

 	public function all_from_sys_where_sstatus($sstatus) {

		$query="SELECT * FROM sys WHERE sstatus = $sstatus";

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


 	public function all_from_captura_where_cpontos_bigger($cpontos){

 		//SELECT * FROM `captura` WHERE `cpontos` >= 6 ORDER BY `cpontos` DESC
		$query="SELECT * FROM captura WHERE cpontos >= $cpontos ORDER BY cpontos DESC";
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

 	public function update_captura_sstatus_2_cpontos_where_cid($cid,$points){

		$query="UPDATE captura SET cstatus=2, cpontos=$points,  cdata='".date("Y-m-d H:i:s")."' WHERE cid = $cid";

		if ($this->mysqli->query($query)) {
			$a['status'] = 'success';
			return  $a;
		} else {
			$a['empty'] = '';
			return  $a;
		}
	}

 	public function update_sys_sstatus_2_where_cid($cid){

		$query="UPDATE sys SET sstatus=2 WHERE cid = $cid";

		if ($this->mysqli->query($query)) {
			$a['status'] = 'success';
			return  $a;
		} else {
			$a['status'] = 'error';
			return  $a;
		}
	}

 	public function update_sys_sstatus_3_where_cid($cid){

		$query="UPDATE sys SET sstatus=3 WHERE cid = $cid";

		if ($this->mysqli->query($query)) {
			$a['status'] = 'success';
			return  $a;
		} else {
			$a['status'] = 'error';
			return  $a;
		}
	}

 	public function update_captura_cstatus_3_where_cid($cid){

		$query="UPDATE captura SET cstatus=3,  cdata='".date("Y-m-d H:i:s")."'   WHERE cid = $cid";

		if ($this->mysqli->query($query)) {
			$a['status'] = 'success';
			return  $a;
		} else {
			$a['status'] = 'error';
			return  $a;
		}
	}


 	public function all_from_avaliador() {

		$query="SELECT * FROM avaliador";

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


/*
	public function count_cid_from_sys_where_cid_and_sstatus($cid, $sstatus) {
		$query="SELECT COUNT(cid) FROM sys WHERE cid = $cid AND sstatus = $sstatus";
		$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
		if($r->num_rows > 0){
			while($row = $r->fetch_assoc()){
				$result[] = $row;
			}
			return $result;
		} else {
			$a['status'] = 'empty';
			return  $a;
		} 

	}

*/

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


 	public function getCapturaPontos0(){

		$query="SELECT * FROM captura WHERE cpontos = 0";
		$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
		if($r->num_rows > 0){
			while($row = $r->fetch_assoc()){
				$result[] = $row;
			}
			return $result;
		} else {
			$a['status'] = 'empty';
			return  $a;
		} 
	}

 	public function getCapturaPontosMaiorQueZero(){

		$query="SELECT * FROM captura WHERE cpontos >= 1";
		$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
		if($r->num_rows > 0){
			while($row = $r->fetch_assoc()){
				$result[] = $row;
			}
			return $result;
		} else {
			$a['status'] = 'empty';
			return  $a;
		} 
	}

 	public function getCapturaPontosSysCid($cid){

		$query="SELECT cid FROM sys WHERE cid = $cid";
		$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
		if($r->num_rows > 0){
			while($row = $r->fetch_assoc()){
				$result[] = $row;
			}
			return $result;
		} else {
			$a['status'] = 'empty';
			return  $a;
		} 
	}

 	public function getSysSid($cid){

		$query="SELECT sid, cid, sstatus FROM sys WHERE cid = $cid";
		$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
		if($r->num_rows > 0){
			while($row = $r->fetch_assoc()){
				$result[] = $row;
			}
			return $result;
		} else {
			$a['status'] = 'empty';
			return  $a;
		} 
	}

 	public function checkCid($cid){

//SELECT COUNT(cid) FROM sys WHERE cid = $cid AND sstatus = 1
//SELECT COUNT(`cid`) FROM `sys` WHERE `cid`= 2 AND`sstatus` = 1

		$query="SELECT COUNT(cid) FROM sys WHERE cid = $cid AND sstatus = 1";
		$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
		if($r->num_rows > 0){
			while($row = $r->fetch_assoc()){
				$result[] = $row;
			}
			return $result;
		} else {
			$a['status'] = 'empty';
			return  $a;
		} 
	}

 	public function getCapturaPontosSysCidStatus1($cid){

		$query="SELECT cid FROM sys WHERE cid = $cid AND sstatus = 1";
		$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
		if($r->num_rows > 0){
			while($row = $r->fetch_assoc()){
				$result[] = $row;
			}
			return $result;
		} else {
			$a['status'] = 'empty';
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

 	public function upCaptura($aid, $cid, $points){

		$query="UPDATE sys SET cpontos=$points, sstatus=1 WHERE aid = $aid AND cid = $cid";

		if ($this->mysqli->query($query)) {
			$a['status'] = 'success';
			return  $a;
		} else {
			$a['status'] = 'error';
			return  $a;
		}
	}

 	public function insertAidCid($aid, $cid){

 		if ($aid == 0) {
			 
			$a['status'] = 'error';
			return  $a;

 		} else {
 			 
			$query="INSERT INTO sys (sid, aid, cid, cpontos, sstatus) VALUES (null, $aid, $cid, 0, 0)";

			if ($this->mysqli->query($query)) {
				$a['status'] = 'success';
				return  $a;
			} else {
				$a['status'] = 'error';
				return  $a;
			}

 		} 

	}

}

?>

