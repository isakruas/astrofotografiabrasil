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

class Astrometria extends Util {

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
            $this->response('API v1.0.0',404);
        }
    }
		
	public function all_from_astrometria_where_subid ($subid){
		$query_astrometria="SELECT * FROM astrometria WHERE subid=".$subid;
		$r_astrometria = $this->mysqli->query($query_astrometria);
		if($r_astrometria->num_rows > 0) {
			return $r_astrometria->fetch_assoc();
		} else {
			return false;
		}
	}

	public function all_from_captura_where_cid ($cid){
		$query_captura="SELECT * FROM captura WHERE cid=".$cid;
		$r_captura = $this->mysqli->query($query_captura);
		if($r_captura->num_rows > 0) {
			return $r_captura->fetch_assoc();
		} else {
			return false;
		}
	}

}

?>

 