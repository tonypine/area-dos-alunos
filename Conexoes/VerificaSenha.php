<?php
//REALIZANDO A CONSULTA
$usuario = $_SESSION['Unidade'] . $_SESSION['Ctr'];

$consulta_coordenador = mysql_query("
SELECT SENHA
FROM TAB_LOGIN 
WHERE CodUnidade = '".$_SESSION['Unidade']."' 
AND Codigo = '".$usuario."' 
");

$resultado_consulta_coordenador = mysql_fetch_assoc($consulta_coordenador);

//VERIFICANDO SE A SENHA DO COORDENADOR FOI ALTERADA
if($_SESSION['Nivel'] == 3 and $resultado_consulta_coordenador['SENHA'] == "coordMC!")
{
	echo('
<div id="boxes">

<div style="top: 199.5px; left: 551.5px; display: none;" id="dialog" class="window">
<form name="Form_Altera_Senha" method="post" action="MinhaConta/Senha/AlteraSenha_2_Obrigatorio.php">
<table width="200" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<td width="6" height="6"><img src="../Imagens/Esquema_Cores/branco/s_e.png" width="6" height="6" /></td>
<td background="../Imagens/Esquema_Cores/branco/s.png"></td>
<td width="8" height="6"><img src="../Imagens/Esquema_Cores/branco/s_d.png" width="8" height="6" /></td>
</tr>
<tr>
<td background="../Imagens/Esquema_Cores/branco/e.png"></td>
<td background="../Imagens/Esquema_Cores/preenchimento_tabela.jpg">

	<table width="500" border="0">
        <tr>
          <td height="58" colspan="3" align="center">Sua senha encontra-se no padr&atilde;o &quot;coordMC!&quot;, para maior seguran&ccedil;a<br />
            altere sua senha para outra de sua prefer&ecirc;ncia.</td>
          </tr>
        <tr>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="left">&nbsp;</td>
        </tr>
        <tr>
          <td align="center">Digite a Nova Senha</td>
          <td align="center">&nbsp;</td>
          <td align="left"><input type="password" name="NovaSenha" id="NovaSenha"/></td>
        </tr>
        <tr>
          <td align="center">Confirme a Nova Senha</td>
          <td align="center">&nbsp;</td>
          <td align="left"><input type="password" name="ConfirmacaoSenha" id="ConfirmacaoSenha"/></td>
        </tr>
        <tr>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="left">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="3" align="center"><input type="submit" name="button" value=" Alterar Senha " /></td>
        </tr>
      </table>
</td>
<td background="../Imagens/Esquema_Cores/branco/d.png"></td>
</tr>
<tr>
<td width="6" height="8"><img src="../Imagens/Esquema_Cores/branco/i_e.png" width="6" height="8" /></td>
<td background="../Imagens/Esquema_Cores/branco/i.png"></td>
<td width="8" height="8"><img src="../Imagens/Esquema_Cores/branco/i_d.png" width="8" height="8" /></td>
</tr>
</table>
</form>

</div>

<div style="width: 1478px; height: 602px; display: none; opacity: 0.8;" id="mask"></div>
</div>
');
}

//VERIFICANDO SE A SENHA DO INSTRUTOR FOI ALTERADA
if($_SESSION['Nivel'] == 2 and $resultado_consulta_coordenador['SENHA'] == "instrutorMC!")
{
	echo('<div id="boxes">

<div style="top: 199.5px; left: 551.5px; display: none;" id="dialog" class="window">
<form name="Form_Altera_Senha" method="post" action="MinhaConta/Senha/AlteraSenha_2_Obrigatorio.php">
<table width="200" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<td width="6" height="6"><img src="../Imagens/Esquema_Cores/branco/s_e.png" width="6" height="6" /></td>
<td background="../Imagens/Esquema_Cores/branco/s.png"></td>
<td width="8" height="6"><img src="../Imagens/Esquema_Cores/branco/s_d.png" width="8" height="6" /></td>
</tr>
<tr>
<td background="../Imagens/Esquema_Cores/branco/e.png"></td>
<td background="../Imagens/Esquema_Cores/preenchimento_tabela.jpg">

	<table width="500" border="0">
        <tr>
          <td height="58" colspan="3" align="center">Sua senha encontra-se no padr&atilde;o &quot;instrutorMC!&quot;, para maior seguran&ccedil;a<br />
            altere sua senha para outra de sua prefer&ecirc;ncia.</td>
          </tr>
        <tr>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="left">&nbsp;</td>
        </tr>
        <tr>
          <td align="center">Digite a Nova Senha</td>
          <td align="center">&nbsp;</td>
          <td align="left"><input type="password" name="NovaSenha" id="NovaSenha"/></td>
        </tr>
        <tr>
          <td align="center">Confirme a Nova Senha</td>
          <td align="center">&nbsp;</td>
          <td align="left"><input type="password" name="ConfirmacaoSenha" id="ConfirmacaoSenha"/></td>
        </tr>
        <tr>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="left">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="3" align="center"><input type="submit" name="button" value=" Alterar Senha " /></td>
        </tr>
      </table>
</td>
<td background="../Imagens/Esquema_Cores/branco/d.png"></td>
</tr>
<tr>
<td width="6" height="8"><img src="../Imagens/Esquema_Cores/branco/i_e.png" width="6" height="8" /></td>
<td background="../Imagens/Esquema_Cores/branco/i.png"></td>
<td width="8" height="8"><img src="../Imagens/Esquema_Cores/branco/i_d.png" width="8" height="8" /></td>
</tr>
</table>
</form>

</div>

<div style="width: 1478px; height: 602px; display: none; opacity: 0.8;" id="mask"></div>
</div>
');
}




?>