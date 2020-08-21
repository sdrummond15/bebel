<?php

/**

 * @version		$Id: contact.php 21991 2011-08-18 15:43:40Z infograf768 $

 * @package		Joomla.Site

 * @subpackage	Contact

 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.

 * @license		GNU General Public License version 2 or later; see LICENSE.txt

 */



defined('_JEXEC') or die;



jimport('joomla.application.component.controllerform');

class BoletoControllerBoleto extends JControllerForm

{

	public function enviarboleto()

	{

		// Check for request forgeries.



		// Initialise variables.

		$model    = $this->getModel('boleto');

		$params   = JComponentHelper::getParams('com_boleto');

		$nome     = JRequest::getVar('nome');

              $cpf      = JRequest::getVar('cpf');

              $telefone = JRequest::getVar('tel');

              $email    = JRequest::getVar('email');

              $edificio = JRequest::getVar('edificio');

              $unidade  = JRequest::getVar('unidade');

		$unidade  = JRequest::getVar('competencia');



             PHP_email::email_boleto($nome, $cpf, $telefone, $email, $edificio, $unidade, $competencia);

	return true;

	}

}

//require_once(JPATH_SITE . DIRECTORY_SEPARATOR .'libraries'. DIRECTORY_SEPARATOR . 'phpmailer' . DIRECTORY_SEPARATOR . 'phpmailer.php');

$doc = JFactory::getDocument();

$doc->addStyleSheet('components/com_boleto/css/styleboleto.css');



class PHP_email extends PHPMailer{



        function email_boleto($nome, $cpf, $telefone, $email, $edificio, $unidade, $competencia){


                        $app		= JFactory::getApplication();

			   $mailfrom	= 'contato@admmaisbrilho.com.br';

			$fromname	= 'Segunda Via Boleto';

			$sitename	= $app->getCfg('sitename');



                        $mail = JFactory::getMailer();

			$mail->addRecipient($mailfrom);

		//	$mail->addReplyTo(array($email, $nome));

			$mail->setSender(array($mailfrom, $fromname));

                        $mail->IsHTML();

			$mail->setSubject("Pedido Segunda Via Boleto");

			$mail->setBody('<html>

                                            <body>

                                                <table width="55%" align="center">

                                                    <tr>

                                                        <td align=left colspan=2>

                                                        <font size="4" face="Verdana" color="#0F0F73">

                                                            <b>Nome: </b>' .  $nome .'

                                                        </font>

                                                        </td>

                                                    </tr>

                                                    <tr>

                                                        <td align=left colspan=2>

                                                        <font size="4" face="Verdana" color="#0F0F73">

                                                            <b>CPF: </b> ' . $cpf . '

                                                        </font>

                                                        </td>

                                                    </tr>

                                                    

                                                    <tr>

                                                        <td align=left colspan=2>

                                                        <font size="4" face="Verdana" color="#0F0F73">

                                                            <b>Telefone: </b>' . $telefone . '

                                                        </font>

                                                        </td>

                                                    </tr>

                                                    <tr>

                                                        <td align=left colspan=2>

                                                        <font size="4" face="Verdana" color="#0F0F73">

                                                            <b>E-mail:</b> ' . $email . '

                                                        </font>

                                                        </td>

                                                    </tr>

                                                     <tr>

                                                        <td align=left colspan=2>

                                                        <font size="4" face="Verdana" color="#0F0F73">

                                                            <b>Edificio: </b> ' . $edificio . '

                                                        </font>

                                                        </td>

                                                    </tr>

                                                    <tr>

                                                        <td align=left colspan=2>

                                                        <font size="4" face="Verdana" color="#0F0F73">

                                                            <b>Unidade: </b> ' . $unidade . '

                                                        </font>

                                                        </td>

                                                    </tr>

							   <tr>

                                                        <td align=left colspan=2>

                                                        <font size="4" face="Verdana" color="#0F0F73">

                                                            <b>Competencia(s): </b> ' . $competencia . '

                                                        </font>

                                                        </td>

                                                    </tr>

                                                   <tr>

                                                        <td align=left colspan=2>

                                                        <font size="4" face="Verdana" color="#0F0F73">

                                                            <b>Data do Envio: </b>' . date ("d/m/Y H:i:s ") . '

                                                        </font>

                                                        </td>

                                                    </tr>

                                                    <tr>

                                                    </tr>

                                                </table>

                                            </body>

                                        </html>');

                       $sent = $mail->Send();

                       echo '<div class="confirm"><h1>Confirma&ccedil;&atilde;o Enviada com Sucesso.</h1><h1>Obrigado!</h1><br /><a href="index.php" rel="pagina inicial Lumiar Cerimonial">Voltar</a></div>';



	}

                

}