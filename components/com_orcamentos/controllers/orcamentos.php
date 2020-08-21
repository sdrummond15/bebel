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

class OrcamentosControllerOrcamentos extends JControllerForm

{

	public function enviarorcamento()

	{

		// Check for request forgeries.



		// Initialise variables.

		$model              = $this->getModel('orcamentos');

		$params             = JComponentHelper::getParams('com_orcamentos');

		$nome             = JRequest::getVar('nome');

              $telefone           = JRequest::getVar('tel');

              $email              = JRequest::getVar('email');

		$edificio             = JRequest::getVar('edificio');

              $endereco           = JRequest::getVar('endereco');

              $bairro              = JRequest::getVar('bairro');

		$cidade              = JRequest::getVar('cidade');

		$cep              = JRequest::getVar('cep');

		$aptos              = JRequest::getVar('aptos');

		$salas              = JRequest::getVar('salas');

		$garagens          = JRequest::getVar('garagens');

              $qtdzeladores      = JRequest::getVar('qtdzeladores');

              $jornadazelador    = JRequest::getVar('jornadazelador');

		$qtdporteiros      = JRequest::getVar('qtdporteiros');

		$jornadaporteiros  = JRequest::getVar('jornadaporteiros');

		$qtdfaxineiras     = JRequest::getVar('qtdfaxineiras');

		$jornadafaxineiras = JRequest::getVar('jornadafaxineiras');

		$qtdoutros = JRequest::getVar('qtdoutros');

		$jornadaoutros = JRequest::getVar('jornadaoutros');
		
		$qtdfuncionarios = JRequest::getVar('qtdfuncionarios');


             PHP_email::email_orcamento($nome, $telefone, $email, $edificio, $endereco, $bairro, $cidade, $cep, $aptos, $salas, $garagens, $qtdzeladores, 
					     $jornadazelador, $qtdporteiros, $jornadaporteiros, $qtdfaxineiras, $jornadafaxineiras, $qtdoutros, $jornadaoutros,
					     $qtdfuncionarios);

	return true;

	}

}

$doc = JFactory::getDocument();

$doc->addStyleSheet('components/com_orcamentos/css/styleorcamentos.css');



class PHP_email extends PHPMailer{



        function email_orcamento($nome, $telefone, $email, $edificio, $endereco, $bairro, $cidade, $cep, $aptos, $salas, $garagens, $qtdzeladores, 
					     $jornadazelador, $qtdporteiros, $jornadaporteiros, $qtdfaxineiras, $jornadafaxineiras, $qtdoutros, $jornadaoutros,
					     $qtdfuncionarios){



                     $app		= JFactory::getApplication();

			$mailfrom	= 'contato@admmaisbrilho.com.br';

			$fromname	= 'Contato Site Mais Brilho ORCAMENTO';

			$sitename	= $app->getCfg('sitename');



                        $mail = JFactory::getMailer();

			$mail->addRecipient($mailfrom);

		//	$mail->addReplyTo(array($email, $nomeconvite));

			$mail->setSender(array($mailfrom, $fromname));

                        $mail->IsHTML();

			$mail->setSubject("Orcamento Site Mais Brilho");

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

                                                            <b>Endereco: </b> ' . $endereco .'-'. $bairro .'/'. $cidade .'

                                                        </font>

                                                        </td>

                                                    </tr>

                                                    <tr>

                                                        <td align=left colspan=2>

                                                        <font size="4" face="Verdana" color="#0F0F73">

                                                            <b>CEP: </b> ' . $cep . '

                                                        </font>

                                                        </td>

                                                    </tr>

                                                    <tr>

                                                        <td align=left colspan=2>

                                                        <font size="4" face="Verdana" color="#0F0F73">

                                                            <b>Qtd. Apartamentos: </b> ' . $aptos . '

                                                        </font>

                                                        </td>

                                                    </tr>

                                                    <tr>

                                                        <td align=left colspan=2>

                                                        <font size="4" face="Verdana" color="#0F0F73">

                                                            <b>Qtd. Salas: </b> ' . $salas . '

                                                        </font>

                                                        </td>

                                                    </tr>

							   <tr>

                                                        <td align=left colspan=2>

                                                        <font size="4" face="Verdana" color="#0F0F73">

                                                            <b>Qtd. Garagens: </b> ' . $garagens . '

                                                        </font>

                                                        </td>

                                                    </tr>

							   <tr>

                                                        <td align=left colspan=2>

                                                        <font size="4" face="Verdana" color="#0F0F73">

                                                            <b>Qtd. Zeladores: </b> ' . $qtdzeladores . '<b>Jornada: </b> ' . $jornadazelador . '

                                                        </font>

                                                        </td>

                                                    </tr>
							   
                                                    <tr>

                                                        <td align=left colspan=2>

                                                        <font size="4" face="Verdana" color="#0F0F73">

                                                            <b>Qtd. Porteiros: </b> ' . $qtdporteiros . '<b>Jornada: </b> ' . $jornadaporteiros . '

                                                        </font>

                                                        </td>

                                                    </tr>

							   <tr>

                                                        <td align=left colspan=2>

                                                        <font size="4" face="Verdana" color="#0F0F73">

                                                            <b>Qtd. Faxineiras: </b> ' . $qtdfaxineiras . '<b>Jornada: </b> ' . $jornadafaxineiras . '

                                                        </font>

                                                        </td>

                                                    </tr>

 							   <tr>

                                                        <td align=left colspan=2>

                                                        <font size="4" face="Verdana" color="#0F0F73">

                                                            <b>Qtd. Outros: </b> ' . $qtdoutros . '<b>Jornada: </b> ' . $jornadautros . '

                                                        </font>

                                                        </td>

                                                    </tr>

							   <tr>

                                                        <td align=left colspan=2>

                                                        <font size="4" face="Verdana" color="#0F0F73">

                                                            <b>Contratados por Conservadora: </b>' . $qtdfuncionarios . '

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