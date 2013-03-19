<html>
	<head>
		<style>
		</style>
	</head>
	<body style="margin: 0;">
		<?php 
			
			$path = $_SERVER['DOCUMENT_ROOT'];
			
			// Se as variáveis do formulário foram enviadas
			if(sizeof($_POST) > 0):
				import_request_variables('p');
				
				/*
				 * $typeForm
				 * 1 = SAC
				 * 2 = Trabalhe Conosco
				 */
				
				// PHPMailer
				require "class.phpmailer.php";
				
				// inicia a classe
				$mail = new PHPMailer();
				
				// dados do servidor
				$mail->IsSMTP();
				$mail->Host = "mail.microcampsp.com.br";
				$mail->SMTPAuth = true; // Usa autentica��o SMTP? (opcional)
				$mail->Username = 'tony.pinheiro@microcampsp.com.br'; // Usuário do servidor SMTP
				$mail->Password = 'Tpinheiro!'; // Senha do servidor SMTP
				
				// remetente
				$mail->From = 'webmaster@microcampsp.com.br'; // email
				$mail->FromName = "Webmaster MicrocampSP"; // nome
				
				// destinat�rios
				//$mail->AddCC('ciclano@site.net', 'Ciclano'); // Copia
				//$mail->AddBCC('tony.pinheiro@microcampsp.com.br','Tony Pinheiro'); //Cópia Oculta
				
				$mail->IsHTML(true); // define que o email ser� mandado como html
				$mail->CharSet = 'UTF-8'; // Charset da mensagem (opcional)
				
				
				if($typeForm == 1):
					
					$subject = "Contato Área dos Alunos - [ ".$assunto." ]";					
					$content = "
						<h2>Contato Área dos Alunos</h2>
						<p><strong>Nome:</strong> ".$nome."</p>
						<p><strong>E-Mail:</strong> ".$email."</p>
						<p><strong>Telefone:</strong> ".$tel."</p>
						<p><strong>Mensagem:</strong> ".$message."</p>";

				endif;							
	
				// define a mensagem ( texto e assunto )
				$mail->Subject = $subject; // assunto
													
				$mail->Body = "
				<html>
					<body style='
						font-family: arial;
						font-size: 13px;
						background: url(http://www.microcampsp.com.br/wp-content/themes/microcamp-theme/images/background-pat.jpg) left top'>
						<table width=100% cellpadding=50 cellspacing=0>
							<tr>
								<td>
									<table 
										width=500 
										cellpadding=0 
										cellspacing=0>
										<tr>
											<td align=left style='padding-bottom: 20px'>
											
												<img 
													style='display: block;' 
													src='http://www.microcampsp.com.br/wp-content/themes/microcamp-theme/images/logo-microcampsp.png' />
											
											</td>
										</tr>
										<tr>
											<td style='height: 20px'></td>
										</tr>
										<tr>
											<td>
												<table
													cellpadding=25 
													style='
														font-family: arial;
														font-size: 13px;
														line-height: 18px;
														background: white;
														border: 1px solid #ddd'>
													<tr><td>
														".$content."
													</td></tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</body>
				</html>";
				// $mail->AltBody = "Este é o corpo da mensagem de teste, em Texto Plano!";
				
				// Envia e deixa um feedback de status. ?>
					<?php
						if($mail->Send()):
							?><p style="display: inline-block; font: 13px/22px arial; margin: 0; padding: 10px 20px; border: 1px solid #a0b37d; border-radius: 5px; background-color: #e4ffb2"><?php
							echo "E-mail enviado com sucesso!";
						else: 
							?><p style="display: inline-block; font: 13px/22px arial; margin: 0; padding: 10px 20px; border: 1px solid #cc8f8f; border-radius: 5px; background-color: #ffccb2"><?php
							echo "Não foi possível enviar o email.<br/><br/>";
						endif;
				?></p><?php
	
				// Limpa os destinat�rios e os anexos
				$mail->ClearAllRecipients();
				$mail->ClearAttachments();
			
			endif; // #Se $_POST length é maior que '0'.
		?>
	</body>
</html>			