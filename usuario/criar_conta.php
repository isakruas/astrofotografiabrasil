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
* @license      Esta plataforma é disponibilizada sobre a Licença Pública Geral (GNU) V3.0
*              Mais detalhes em: https://github.com/isakruas/astrofotografiabrasil/blob/master/LICENSE
*
* @link        Homepage:     http://astrofotografia.nrolabs.com/
*              GitHub Repo:  https://github.com/isakruas/astrofotografiabrasil/
*              README:       https://github.com/isakruas/astrofotografiabrasil/blob/master/README.md
*
* @version     1.0.00
*/
//error_reporting(0);

$debug = false;


#Gera um codigo unico

$nup = date('siHmdHis') . (substr(round(microtime(true) * 100), (strlen(round(microtime(true) * 100)) - 2), strlen(round(microtime(true) * 100))));

function s1()
{
    $characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $randstring = '';
    for ($i = 0; $i < 27; $i++) {
        $randstring = $characters[rand(0, (strlen($characters) - 1))];
    }
    return $randstring;
    unset($randstring);
}

function s2()
{
    $characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $randstring = '';
    for ($i = 0; $i < 27; $i++) {
        $randstring = $characters[rand(0, (strlen($characters) - 1))];
    }
    return $randstring;
    unset($randstring);
}

session_start();

include_once('api.php');

$api = new Usuario;

if (isset($_POST['upassword']) && isset($_POST['uemail'])) {
    $USUÁRIO = $api->doLogin($_POST['uemail'], $_POST['upassword']);
    if (isset($USUÁRIO['uid'])) {
        $_SESSION['uid']    = $USUÁRIO['uid'];
        $_SESSION['unome']  = $USUÁRIO['unome'];
        $_SESSION['uemail'] = $USUÁRIO['uemail'];
    } else {
        //print_r($USUÁRIO);
    }
}

/*

$_SESSION['i'] serve para saber em qual tela o usuario esta


*/

#Cria a $_SESSION['i'] com o valor zero, ou seja, o usuário está na primeira tela do cadastro
if (!isset($_SESSION['i'])) {
    $_SESSION['i'] = 0;
	?><meta http-equiv="refresh" content="0; URL='./criar_conta.php'"/> <?php
} else {
    
    #verifica se tem um token criado, se não tiver irá cria-lo; Esse tokem servirá para verificar o email
    if (!isset($_SESSION['code'])) {
        $_SESSION['code'] = $nup . s1() . s2();
		?><meta http-equiv="refresh" content="0; URL='./criar_conta.php'"/><?php
    } else {
        
        if ($debug) {
            print_r($_SESSION['code']);
        }
        
        if (isset($_POST['email'])) {
            
            $count_uemail = $api->count_uemail_from_usuario_where_uemail($_POST['email']);
            
            if (intval($count_uemail[0]['COUNT(uemail)']) == 0) {
                
                $_SESSION['form']['email'] = $_POST['email'];


                $message = "<html><head><title>Astrofotografia Brasil</title><style type='text/css'>* {margin: 0px;padding: 0px;}body {background: #f4f4f4;font-family: Courier New, monospace;color: #666;font-size: 16pt;}</style></head><body><br><table><tbody><tr><th>" . $_SESSION['code'] . "</th></tr></tbody></table> </body></html>";
                // Always set content-type when sending HTML email
                
                //$message = "<html><head><title>Astrofotografia Brasil</title><style type='text/css'>* {margin: 0px;padding: 0px;}body {color: #a0a0a1;font-family: 'Source Sans Pro', Helvetica, sans-serif;font-size: 15pt; font-weight: 300; letter-spacing: 0.025em;line-height: 1.65;background: #242629; text-align: center; -webkit-overflow-scrolling: touch; overflow-x: auto; }table { margin: 0 0 2em 0; width: 100%; } table tbody tr { border: solid 1px rgba(210, 215, 217, 0.75); border-left: 0; border-right: 0; } table tbody tr:nth-child(2n + 1) { background-color: rgba(230, 235, 237, 0.25); } table td { padding: 0.75em 0.75em; } table th { color: #3d4449; font-size: 0.9em; font-weight: 600; padding: 0 0.75em 0.75em 0.75em; text-align: left; } table thead { border-bottom: solid 2px rgba(210, 215, 217, 0.75); } table tfoot { border-top: solid 2px rgba(210, 215, 217, 0.75); } table.alt { border-collapse: separate; } table.alt tbody tr td { border: solid 1px rgba(210, 215, 217, 0.75); border-left-width: 0; border-top-width: 0; } table.alt tbody tr td:first-child { border-left-width: 1px; } table.alt tbody tr:first-child td { border-top-width: 1px; } table.alt thead { border-bottom: 0; } table.alt tfoot { border-top: 0; }.box { border-radius: 0.375em; border: solid 1px rgba(210, 215, 217, 0.75); margin-bottom: 2em; padding: 1.5em; } .box > :last-child, .box > :last-child > :last-child, .box > :last-child > :last-child > :last-child { margin-bottom: 0; } .box.alt { border: 0; border-radius: 0; padding: 0; }</style></head><body><br><div class='box' style='text-align: justify; width: 30vw ;position:fixed; left:50%; margin-left:-15vw; top:50%; margin-top:-64px;'><p>Olá, este é seu código de verificação para prosseguir no processo de cadastro na plataforma <strong>Astrofotografia Brasil</strong>. Caso não tenha solicitado este código, basta ignorá esta mensagem.</p></div><table><thead><tr><th></th><th></th><th></th></tr></thead><tbody><tr><td></td><td></td><td></td></tr><tr><td></td><td style='height:128px; text-align: center; font-size: 20pt'>".$_SESSION ['code']."</td><td></td></tr><tr><td></td><td></td><td></td></tr></tbody><tfoot><tr><td colspan='3'></td></tr></tfoot></table> <p style='position:fixed; left:50%; width:10cm; margin-left:-5cm; font-size:10pt; bottom:1cm;'>© 2020 Nrọlabs Desenvolvimento de Softwares.</p> </body></html>";
                
                $subject = "Código de verificação  - Astrofotografia Brasil";
                // Always set content-type when sending HTML email
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                // More headers
                $headers .= 'From: <' . 'astrofotografia@nrolabs.com' . '>' . "\r\n";
                // $headers .= 'Cc: <isakruas@gmail.com>'. "\r\n";
                
                if (!$debug) {
                    mail($_SESSION['form']['email'], $subject, $message, $headers);
                }
                
                $_SESSION['i'] = 1;
                
            } else {
                $_SESSION['i'] = 8;
            }
            
        }
        
        if (isset($_POST['cv'])) {
            
            if ($_POST['cv'] == $_SESSION['code']) {
                $_SESSION['i'] = 2;
            } else {
                $_SESSION['i'] = 3;
            }
        }
        
        if (isset($_POST['nome'])) {
            
            $_SESSION['i']            = 4;
            $_SESSION['form']['nome'] = $_POST['nome'];
            
        }
        
        if (isset($_POST['senha'])) {
            
            $_SESSION['i']             = 5;
            $_SESSION['form']['senha'] = $_POST['senha'];
            
        }
        
        if (isset($_POST['cc'])) {
        
            $query = "INSERT INTO `usuario` (`uid`, `uemail`, `unome`, `usenha`, `ustatus`, `udata`) VALUES (NULL, '" . $_SESSION['form']['email'] . "', '" . $_SESSION['form']['nome'] . "', '" . $_SESSION['form']['senha'] . "', '1', '" . date("Y-m-d H:i:s") . "')";
            
            $api = new Usuario;
            $sql = $api->insert_usuario($query);
            if (isset($sql['success'])) {
                
                $_SESSION['i'] = 6;
                
            } else {
                
                $_SESSION['i'] = 7;
                
            }      
        }
        
     
        if (isset($_SESSION['uid'])) {
            header("Refresh: 0; url=/painel.php");
			?><meta http-equiv="refresh" content="0; URL='./painel.php'"/><?php  
        }
        

        if (isset($_GET['i'])) {
            session_cache_expire();
            session_unset();
            session_destroy();
            ?><meta http-equiv="refresh" content="0; URL='./criar_conta.php'"/><?php
        }

        if (isset($_GET['sms'])) {
            if ($_GET['sms'] == 1) {
               $_SESSION['i'] = 9;
                ?><meta http-equiv="refresh" content="0; URL='./criar_conta.php'"/><?php
            }
            if ($_GET['sms'] == 2) {
               $_SESSION['i'] = 1;
                ?><meta http-equiv="refresh" content="0; URL='./criar_conta.php'"/><?php
            } 
        }

        if (isset($_POST['sms'])) {
            $_POST['sms'] = trim(str_replace('/', '', str_replace(' ', '', str_replace('-', '', str_replace(')', '', str_replace('(', '',  $_POST['sms']))))));
            $regexCel = '/[0-9]{2}[6789][0-9]{3,4}[0-9]{4}/'; // Regex para validar somente celular
            if (preg_match($regexCel, $_POST['sms'] )) {

                $number = $_POST['sms'];
                $rand = $_SESSION['code'];
                $msg = "Olá, você pediu para se registrar na plataforma Astrofotografia Brasil, este é o seu código de verificação: ".$rand.". Caso não tenha sido você, ignore esta mensagem.";
                $ch = curl_init();
                $data = array('key'         => '', 
                              'type'        => '9',
                              'number'      => $_POST['sms'],
                              'msg'         => $msg);

                curl_setopt($ch, CURLOPT_URL, 'http://api.smsdev.com.br/send');
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $res    = curl_exec ($ch);
                $err    = curl_errno($ch);
                $errmsg = curl_error($ch);
                $header = curl_getinfo($ch);

                curl_close($ch);

                $check = json_decode($res);

                if ($check->situacao == "OK") {

                    $arquivo = fopen('sms.txt','a+');
                    $texto = $_POST['sms'].' '.date("Y-m-d H:i:s").PHP_EOL;
                    fwrite($arquivo, $texto);
                    fclose($arquivo);

                    $_SESSION['i'] = 11;
                } else {
                    $_SESSION['i'] = 10;
                }

            } else {
                 $_SESSION['i'] = 10;
            }
        }



        
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

                            <!-- Header -->
                                <header id="header">
                                    <a href="" class="logo"><strong>ASTROFOTOGRAFIA BRASIL</strong> - USUÁRIO</a>
                                </header>

                            <!-- Content -->
                                <section>
                                    <br /><br /><br /><br />
                                        <div class="row">
                                            <div class="col-4 col-12-medium"></div>
                                            <div class="col-4 col-12-medium">

                                                <svg  style="position:relative; left:50%;  margin-left:-64px; top:50%; margin-top:-64px;" height="128px" viewBox="0 0 488 488" width="128px" xmlns="http://www.w3.org/2000/svg"><path d="m392 312 32-32 32 32-32 32zm0 0" fill="#cb9e78"/><path d="m136 392c-17.671875 0-32-14.328125-32-32 0 17.671875-14.328125 32-32 32 17.671875 0 32 14.328125 32 32 0-17.671875 14.328125-32 32-32zm0 0" fill="#eebc5a"/><path d="m336 168 16-16-24-24-88 88 24 24 16-16" fill="#575c61"/><path d="m407.996094 352.003906 55.996094-55.996094 24 24-55.996094 55.996094zm0 0" fill="#575c61"/><path d="m279.996094 224.003906 56-55.996094 104 104-56 55.996094zm0 0" fill="#d9d7d8"/><path d="m279.996094 224.003906 40-40 87.996094 88-40 39.996094zm0 0" fill="#efedee"/><path d="m328 272v80h32v-48zm0 0" fill="#cb9e78"/><path d="m328 272v80h16v-64zm0 0" fill="#dbaf89"/><path d="m328 408-80 80h48l32-32" fill="#bc8f6f"/><path d="m360 408 80 80h-48l-32-32" fill="#bc8f6f"/><path d="m328 400v88h32v-88" fill="#cb9e78"/><path d="m328 400v88h16v-88" fill="#dbaf89"/><path d="m376 376c0 17.671875-14.328125 32-32 32s-32-14.328125-32-32 14.328125-32 32-32 32 14.328125 32 32zm0 0" fill="#dcb29c"/><path d="m488 160c-17.671875 0-32-14.328125-32-32 0 17.671875-14.328125 32-32 32 17.671875 0 32 14.328125 32 32 0-17.671875 14.328125-32 32-32zm0 0" fill="#5789d6"/><path d="m408 64c-17.671875 0-32-14.328125-32-32 0 17.671875-14.328125 32-32 32 17.671875 0 32 14.328125 32 32 0-17.671875 14.328125-32 32-32zm0 0" fill="#ca5057"/><path d="m120 256c0 30.929688-25.070312 56-56 56s-56-25.070312-56-56 25.070312-56 56-56 56 25.070312 56 56zm0 0" fill="#5789d6"/><path d="m104 256c0-30.574219-21.492188-55.359375-48-55.359375s-48 24.785156-48 55.359375 21.492188 55.359375 48 55.359375 48-24.785156 48-55.359375zm0 0" fill="#699ce6"/><path d="m8 256c0 11.199219 3.320312 21.609375 8.984375 30.359375l23.015625-38.359375v-42.535156c-18.902344 8.992187-32 28.207031-32 50.535156zm0 0" fill="#70b48f"/><path d="m120 256c0-28.207031-20.871094-51.472656-48-55.359375v31.359375l24 32h23.359375c.375-2.617188.640625-5.28125.640625-8zm0 0" fill="#599072"/><path d="m72 205.511719v26.488281l24 32h7.359375c.375-2.617188.640625-5.28125.640625-8 0-22.320312-13.097656-41.511719-32-50.488281zm0 0" fill="#70b48f"/><path d="m264 328c0 26.507812-21.492188 48-48 48s-48-21.492188-48-48 21.492188-48 48-48 48 21.492188 48 48zm0 0" fill="#f8cf6a"/><path d="m240 96c0 48.601562-39.398438 88-88 88s-88-39.398438-88-88 39.398438-88 88-88 88 39.398438 88 88zm0 0" fill="#70b48f"/><path d="m144 64c0 8.835938-7.164062 16-16 16s-16-7.164062-16-16 7.164062-16 16-16 16 7.164062 16 16zm0 0" fill="#ca5057"/><path d="m192 128c0 13.253906-10.746094 24-24 24s-24-10.746094-24-24 10.746094-24 24-24 24 10.746094 24 24zm0 0" fill="#eebc5a"/><g fill="#d9d7d8"><path d="m343.996094 288 24.003906-24.003906 11.3125 11.3125-24.003906 24.003906zm0 0"/><path d="m298.339844 242.34375 24.003906-24.003906 11.3125 11.3125-24 24.003906zm0 0"/><path d="m152 192c-52.9375 0-96-43.0625-96-96s43.0625-96 96-96 96 43.0625 96 96-43.0625 96-96 96zm0-176c-44.113281 0-80 35.886719-80 80s35.886719 80 80 80 80-35.886719 80-80-35.886719-80-80-80zm0 0"/><path d="m168 160c-17.648438 0-32-14.351562-32-32s14.351562-32 32-32 32 14.351562 32 32-14.351562 32-32 32zm0-48c-8.824219 0-16 7.175781-16 16s7.175781 16 16 16 16-7.175781 16-16-7.175781-16-16-16zm0 0"/><path d="m145.28125 143.960938c-69.96875-.882813-145.28125-16.265626-145.28125-47.960938 0-22.832031 37.457031-34.800781 68.878906-40.824219l3.007813 15.71875c-40.71875 7.800781-55.886719 19.539063-55.886719 25.105469 0 10.585938 44.472656 30.886719 129.480469 31.960938zm0 0"/><path d="m191.71875 142.488281-1.246094-15.953125c68.917969-5.390625 97.527344-22.550781 97.527344-30.535156 0-5.648438-15.464844-17.511719-56.96875-25.3125l2.953125-15.71875c31.945313 6 70.015625 17.984375 70.015625 41.03125 0 27.800781-58 42.230469-112.28125 46.488281zm0 0"/></g><path d="m56 272h16v16h-16zm0 0" fill="#70b48f"/><path d="m216 384c-30.878906 0-56-25.128906-56-56s25.121094-56 56-56 56 25.128906 56 56-25.121094 56-56 56zm0-96c-22.054688 0-40 17.945312-40 40s17.945312 40 40 40 40-17.945312 40-40-17.945312-40-40-40zm0 0" fill="#d9d7d8"/><path d="m216 352c-42.382812 0-88-10.015625-88-32 0-18.328125 30.425781-26.039062 48.550781-29l2.578125 15.800781c-27.097656 4.421875-34.714844 11.75-35.144531 13.328125 1.222656 4.191406 25.207031 15.871094 72.015625 15.871094s70.792969-11.679688 72.007812-16.121094c-.433593-1.335937-8.046874-8.664062-35.144531-13.085937l2.578125-15.800781c18.144532 2.96875 48.558594 10.679687 48.558594 29.007812 0 21.984375-45.617188 32-88 32zm0 0" fill="#d9d7d8"/></svg>

                                            </div>
                                            <div class="col-4 col-12-medium"></div>
                                        </div>
                                        <br /><br /><br /><br />


                                        <div class="row">
                                            <div class="col-4 col-12-medium"></div>
                                            <div class="col-4 col-12-medium">
<?php
        
        if (isset($_SESSION['i'])) {
            
            
            switch ($_SESSION['i']) {
                case 0:
                    
?>
                                               <form method="post" action="">
                                                    <div class="row gtr-uniform">
                                                        <div class="col-12">
                                                            <input type="email" name="email" id="email" value="" placeholder="Email" required />
                                                        </div>
                                                        <!-- Break -->
                                                        <div class="col-12">
                                                            <ul class="actions">
                                                            <li><input type="submit" value="CONTINUAR" class="primary" /></li>
                                                            <li><a href="./" target="blank" class="button primary ">Cancelar cadastro</a></li>
                                                            
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </form>
                                                <div class="box" style="text-align: justify;">
                                                    <p>Olá, que bom é vê-lo por aqui! Com alguns passos simples será possível criar sua conta na plataforma Astrofotografia Brasil, vamos lá? Inicialmente, leia nossos <a href="./termos_e_condicoes">Termos e Condições</a>, depois digite na caixa de texto acima o seu email, em seguida clique em CONTINUAR.</p>
                                                </div>
<?php
                    
                    break;
                
                case 1:
                    
?>
                                               <form method="post" action="">
                                                    <div class="row gtr-uniform">
                                                        <div class="col-12">
                                                            <input type="text" name="cv" id="cv" value="" placeholder="Código" required />
                                                        </div>
                                                        <!-- Break -->
                                                        <div class="col-12">
                                                            <ul class="actions">
                                                            <li><input type="submit" value="CONTINUAR" class="primary" /></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </form>
                                                <div class="box" style="text-align: justify;">
                                                    <p>Perfeito! Lhe enviamos um email de confirmação, por favor, digite no campo acima o código enviado, após clique em CONTINUAR. Você também pode receber o código por mensagem, para isso clique <a href="?sms=1"> aqui</a></p>
                                                </div>
<?php
                    
                    break;
                
                case 2:
?>
                                               <form method="post" action="">
                                                    <div class="row gtr-uniform">
                                                        <div class="col-12">
                                                            <input type="text" name="nome" id="nome" value="" placeholder="Nome" required />
                                                        </div>
                                                        <!-- Break -->
                                                        <div class="col-12">
                                                            <ul class="actions">
                                                            <li><input type="submit" value="CONTINUAR" class="primary" /></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </form>
                                                <div class="box" style="text-align: justify;">
                                                    <p>Ótimo, agora escolha um nome de usuário e clique em CONTINUAR. Este será o nome que aparecerá juntamente com as capturas nas quais você submeter e forem aprovadas e publicadas.</p>
                                                </div>
<?php
                    
                    break;
                
                case 3:
                    
?>
                                               <form method="post" action="">
                                                    <div class="row gtr-uniform">
                                                        <div class="col-12">
                                                            <input type="text" name="cv" id="cv" value="" placeholder="Código" required />
                                                        </div>
                                                        <!-- Break -->
                                                        <div class="col-12">
                                                            <ul class="actions">
                                                            <li><input type="submit" value="CONTINUAR" class="primary" /></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </form>
                                                <div class="box" style="text-align: justify;">
                                                    <p>Ops! :( .. O código informado está incorreto, por favor, informe o código certo e após clique em CONTINUAR. Verifique sua caixa de span, ou aguarde mais alguns minutos.Se o problema persistir, tente mais tarde.</p>
                                                </div>
<?php
                    
                    break;
                case 4:
?>
                                               <form method="post" action="">
                                                    <div class="row gtr-uniform">
                                                        <div class="col-12">
                                                            <input type="password" name="senha" id="senha" value="" placeholder="Senha" required />
                                                        </div>
                                                        <!-- Break -->
                                                        <div class="col-12">
                                                            <ul class="actions">
                                                            <li><input type="submit" value="CONTINUAR" class="primary" /></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </form>
                                                <div class="box" style="text-align: justify;">
                                                    <p>Já está quase acabando! :) … Agora escolha uma senha e clique em CONTINUAR. Lembre-se de escolher uma senha segura. Fazemos o possível para manter seus dados em sigilo, pedimos sua colaboração neste processo. Nunca repasse sua senha para ninguém.</p>
                                                </div>
<?php
                    
                    break;
                
                case 5:
?>
                                               <form method="post" action="">
                                               		<table>
                                                            <thead>
                                                                <tr>
                                                                    <th></th>
                                                                    <th></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>Nome</td>
                                                                    <td><?php echo $_SESSION['form']['nome']; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Email</td>
                                                                    <td><?php echo $_SESSION['form']['email']; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Senha</td>
                                                                    <td><?php echo $_SESSION['form']['senha']; ?></td>
                                                                </tr>
                                                            </tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <td colspan="2"></td>
                                                                    
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                        <input type="text" name="cc" style="display: none !important;" />
                                                        <input type="submit" value="CRIAR CONTA" class="primary" /> 
                                                         <a href="criar_conta.php?i" target="blank" class="button primary ">Cancelar cadastro</a>
                                                </form>
                                                <div class="box" style="text-align: justify;">
                                                    <p>Por favor, verifique se seus dados estão corretos. Ao clicar em CRIAR CONTA, iremos inserir estas informações em nossa base de dados. <br />Você poderá solicitar o cancelamento de sua conta a qualquer momento, para isso basta enviar um email para <stong>astrofotografia@nrolabs.com</stong>.</p>
                                                </div>
<?php
                    
                    
                    break;
                
                case 6:
?>
 
                                                <div class="box" style="text-align: justify;">
                                                    <p><?php echo $_SESSION['form']['nome']; ?>, seja bem vindo! Tudo certo na criação de sua conta, estamos lhe redirecionado para a página de login.</p>
                                                </div>
                                                <meta http-equiv="refresh" content="10; URL='./login.php'"/>
<?php
                    
                    session_cache_expire();
                    session_unset();
                    session_destroy();
                    
                    break;
                
                case 7:
?>
                                               <form method="post" action="">
                                               	<table>
                                                            <thead>
                                                                <tr>
                                                                    <th></th>
                                                                    <th></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>Nome</td>
                                                                    <td><?php
                                                                    echo $_SESSION['form']['nome']; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Email</td>
                                                                    <td><?php echo $_SESSION['form']['email']; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Senha</td>
                                                                    <td><?php echo $_SESSION['form']['senha']; ?></td>
                                                                </tr>
                                                            </tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <td colspan="2"></td>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                        <input type="text" name="cc" style="display: none !important;" />
                                                        <input type="submit" value="CRIAR CONTA" class="primary" /> 
                                                         <a href="criar_conta.php?i" target="blank" class="button primary ">Cancelar cadastro</a>
                                                </form>
                                                <div class="box" style="text-align: justify;">
                                                    <p>Ops! :( .. Tivemos um erro ao processar sua solicitação, pedimos desculpas pelo transtorno.Por favor, tente novamente. Se o problema persistir, tente mais tarde ou entre em contato com nossos canais de suporte.</p>
                                                </div>
<?php
                    
                    
                    break;
                case 8:
                    
?>
                                               <form method="post" action="">
                                                    <div class="row gtr-uniform">
                                                        <div class="col-12">
                                                            <input type="text" name="email" id="email" value="" placeholder="Email" required />
                                                        </div>
                                                        <!-- Break -->
                                                        <div class="col-12">
                                                            <ul class="actions">
                                                            <li><input type="submit" value="CONTINUAR" class="primary" /></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </form>
                                                <div class="box" style="text-align: justify;">
                                                    <p>Ops! :( .. O email informado já se encontra cadastrado em nossa base de dados, caso seja o proprietário deste email, e por algum motivo ou razão alguém criou a sua conta sem o seu consentimento, entre em contato com a equipe de suporte. Digite outro email válido e clique em CONTINUAR.</p>
                                                </div>
<?php
                    
                    break;


                case 9:
                    
?>
                                               <form method="post" action="">
                                                    <div class="row gtr-uniform">
                                                        <div class="col-12">
                                                            <input type="text" name="sms" id="sms" value="" placeholder="00000000000" required />
                                                        </div>
                                                        <!-- Break -->
                                                        <div class="col-12">
                                                            <ul class="actions">
                                                            <li><input type="submit" value="ENVIAR SMS" class="primary" /></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </form>
                                                <div class="box" style="text-align: justify;">
                                                    <p>Ok, digite seu número de telefone acima e clique em ENVIAR SMS para receber o código de verificação. Caso já tenha recebido o email com o código e queira voltar para a tela de validação, clique <a href="?sms=2">aqui.</a></p>
                                                </div>
<?php
                    
                    break;




                case 10:
                    
?>
                                               <form method="post" action="">
                                                    <div class="row gtr-uniform">
                                                        <div class="col-12">
                                                            <input type="text" name="sms" id="sms" value="" placeholder="00000000000" required />
                                                        </div>
                                                        <!-- Break -->
                                                        <div class="col-12">
                                                            <ul class="actions">
                                                            <li><input type="submit" value="ENVIAR SMS" class="primary" /></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </form>
                                                <div class="box" style="text-align: justify;">
                                                    <p>Ops! :( .. Não foi possível enviar o SMS para você, digite o seu número de telefone novamente e clique em ENVIAR SMS. Caso já tenha recebido o email com o código e queira voltar para a tela de validação, clique <a href="?sms=2">aqui.</a></p>
                                                </div>
<?php
                    
                    break;

                case 11:
                    
?>
                                               <form method="post" action="">
                                                    <div class="row gtr-uniform">
                                                        <div class="col-12">
                                                            <input type="text" name="cv" id="cv" value="" placeholder="Código" required />
                                                        </div>
                                                        <!-- Break -->
                                                        <div class="col-12">
                                                            <ul class="actions">
                                                            <li><input type="submit" value="CONTINUAR" class="primary" /></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </form>
                                                <div class="box" style="text-align: justify;">
                                                    <p>Perfeito! Além do e-mail lhe enviamos um SMS com o código de verificação. Por favor, digite no campo acima o código enviado, após clique em CONTINUAR.</p>
                                                </div>
<?php
                    
                    break;

            }
        }
?>

                                            </div>
                                            <div class="col-4 col-12-medium"></div>
                                        </div>
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
    
}

?>