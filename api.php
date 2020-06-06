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


require_once('./assets/php/util.php');
require_once('./assets/php/config.php');

class API extends Util {

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

    public function processApi(){
        $func = strtolower(trim(str_replace("/","",$_REQUEST['x'])));
        if((int)method_exists($this,$func) > 0) {
            $this->$func();
        } else {
            $this->response('API v1.0.0',404); // If the method not exist with in this class "Page not found".
        }
    }

 	public function list(){
		$query="SELECT * FROM captura WHERE cpontos > 6 ORDER BY cdata DESC LIMIT 40";
		$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
		if($r->num_rows > 0) {
            $result = array();
            while($row = $r->fetch_assoc()){
                $result[] = $row;
            }

            $filtro = array();
            for ($i=0; $i < count($result); $i++) { 
   
   				$cautor = $result[$i]['cautor'];
				$query_unome="SELECT unome FROM usuario WHERE uid=$cautor";
       
				$r_unome = $this->mysqli->query($query_unome) or die($this->mysqli->error.__LINE__);
				if($r_unome->num_rows > 0) {
					$result_unome = $r_unome->fetch_assoc();
	            	 $filtro[] = array(
	            	 	'ctitulo'		=> $result[$i]['ctitulo'],
	            	 	'cdescricao'	=> $result[$i]['cdescricao'],
	            	 	'cautor'		=> $result_unome['unome'],
	            	 	'csrcfull'		=> $result[$i]['csrcfull'],
	            	 	'csrcsmall'		=> $result[$i]['csrcsmall'],
	            	 ); 
        		}

            }
				 
            $this->response(json_encode($filtro, JSON_NUMERIC_CHECK),200);
		} else {
			 $this->response('API v1.0.0',404);
		}
	}

}

$api = new API;
$api->processApi();
?>

