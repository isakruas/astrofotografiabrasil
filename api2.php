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

 	public function i_list(){
		$query="SELECT * FROM captura WHERE cpontos > 6 AND cstatus = 3 ORDER BY cdata DESC LIMIT 40";
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
	            	 	'cid'		=> $result[$i]['cid'],
	            	 	'ctitulo'		=> $result[$i]['ctitulo'],
	            	 	'cdescricao'	=> $result[$i]['cdescricao'],
	            	 	'cautor'		=> $result_unome['unome'],
	            	 	'csrcfull'		=> $result[$i]['csrcfull'],
	            	 	'csrcsmall'		=> $result[$i]['csrcsmall'],
	            	 ); 
        		}

            }
				
				$html = "";
            for ($i=0; $i < count($filtro); $i++) { 


				$query_astrometria="SELECT subid FROM astrometria WHERE cid =".$filtro[$i]['cid'];
				$r_astrometria = $this->mysqli->query($query_astrometria);
				if($r_astrometria->num_rows > 0) {
					$result_astrometria = $r_astrometria->fetch_assoc();
				} else {
					$result_astrometria = false;
				}

				if (!$result_astrometria == false) {
					 
					$html = $html.'<article class="thumb"> <a href="'.$filtro[$i]['csrcfull'].'" class="image"><img src="'.$filtro[$i]['csrcsmall'].'" alt="" /></a><h2>'.$filtro[$i]['ctitulo'].' - '.$filtro[$i]['cautor'].'</h2> <p>'.$filtro[$i]['cdescricao'].'</p><p style="float: right;"><a href="./astrometria/'.$result_astrometria['subid'].'"  target="_blank">Astrometria</a> por Astrometry.net</p></article>';

				} else {
					$html = $html.'<article class="thumb"> <a href="'.$filtro[$i]['csrcfull'].'" class="image"><img src="'.$filtro[$i]['csrcsmall'].'" alt="" /></a><h2>'.$filtro[$i]['ctitulo'].' - '.$filtro[$i]['cautor'].'</h2> <p>'.$filtro[$i]['cdescricao'].'</p></article>';

				}
            }

            return $html;
		} else {
			 $html = '<article class="thumb"> <a href="images/fulls/1.jpg" class="image"><img src="images/thumbs/1.jpg" alt="" /></a> <h2>Magna feugiat lorem</h2> <p>Nunc blandit nisi ligula magna sodales lectus elementum non. Integer id venenatis velit.</p> </article> <article class="thumb"> <a href="images/fulls/2.jpg" class="image"><img src="images/thumbs/2.jpg" alt="" /></a> <h2>Nisl adipiscing</h2> <p>Nunc blandit nisi ligula magna sodales lectus elementum non. Integer id venenatis velit.</p> </article> <article class="thumb"> <a href="images/fulls/3.jpg" class="image"><img src="images/thumbs/3.jpg" alt="" /></a> <h2>Tempus aliquam veroeros</h2> <p>Nunc blandit nisi ligula magna sodales lectus elementum non. Integer id venenatis velit.</p> </article> <article class="thumb"> <a href="images/fulls/4.jpg" class="image"><img src="images/thumbs/4.jpg" alt="" /></a> <h2>Aliquam ipsum sed dolore</h2> <p>Nunc blandit nisi ligula magna sodales lectus elementum non. Integer id venenatis velit.</p> </article> <article class="thumb"> <a href="images/fulls/5.jpg" class="image"><img src="images/thumbs/5.jpg" alt="" /></a> <h2>Cursis aliquam nisl</h2> <p>Nunc blandit nisi ligula magna sodales lectus elementum non. Integer id venenatis velit.</p> </article> <article class="thumb"> <a href="images/fulls/6.jpg" class="image"><img src="images/thumbs/6.jpg" alt="" /></a> <h2>Sed consequat phasellus</h2> <p>Nunc blandit nisi ligula magna sodales lectus elementum non. Integer id venenatis velit.</p> </article> <article class="thumb"> <a href="images/fulls/7.jpg" class="image"><img src="images/thumbs/7.jpg" alt="" /></a> <h2>Mauris id tellus arcu</h2> <p>Nunc blandit nisi ligula magna sodales lectus elementum non. Integer id venenatis velit.</p> </article> <article class="thumb"> <a href="images/fulls/8.jpg" class="image"><img src="images/thumbs/8.jpg" alt="" /></a> <h2>Nunc vehicula id nulla</h2> <p>Nunc blandit nisi ligula magna sodales lectus elementum non. Integer id venenatis velit.</p> </article> <article class="thumb"> <a href="images/fulls/9.jpg" class="image"><img src="images/thumbs/9.jpg" alt="" /></a> <h2>Neque et faucibus viverra</h2> <p>Nunc blandit nisi ligula magna sodales lectus elementum non. Integer id venenatis velit.</p> </article> <article class="thumb"> <a href="images/fulls/1.jpg" class="image"><img src="images/thumbs/1.jpg" alt="" /></a> <h2>Mattis ante fermentum</h2> <p>Nunc blandit nisi ligula magna sodales lectus elementum non. Integer id venenatis velit.</p> </article> <article class="thumb"> <a href="images/fulls/11.jpg" class="image"><img src="images/thumbs/11.jpg" alt="" /></a> <h2>Sed ac elementum arcu</h2> <p>Nunc blandit nisi ligula magna sodales lectus elementum non. Integer id venenatis velit.</p> </article> <article class="thumb"> <a href="images/fulls/12.jpg" class="image"><img src="images/thumbs/12.jpg" alt="" /></a> <h2>Vehicula id nulla dignissim</h2> <p>Nunc blandit nisi ligula magna sodales lectus elementum non. Integer id venenatis velit.</p> </article>';

			 return $html;
		}
	}

}


?>

