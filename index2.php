<?php
session_start();

//INCLUINDO O VERIFICADOR
require_once("../../Conexoes/VerificaAluno.php");

//INCLUINDO A CONEXAO DO BANCO
require_once("../../Conexoes/conexao.php");

//DESCOBRINDO O NOME DA UNIDADE
$Consulta_Nome_Unidade = mysql_query("
SELECT Unidade 
FROM TAB_Unidades
WHERE CodUnidade = '".$_SESSION['Unidade']."'
") or die ("Erro");
$Resultado_Nome_Unidade = mysql_fetch_assoc($Consulta_Nome_Unidade);
$Nome_Unidade = $Resultado_Nome_Unidade['Unidade'];

//CONSULTANDO AS INFORMACOES DO ALUNO
$Consulta_Informacoes_Aluno = mysql_query("
SELECT Nome, CodTurma
FROM TAB00200
WHERE CodUnidade = '".$_SESSION['Unidade']."'
AND CodCurso = '".$_SESSION['CodCurso']."'
AND CTR = '".$_SESSION['Ctr']."'
") or die ("Erro");
$Resultado_Informacoes_Aluno = mysql_fetch_assoc($Consulta_Informacoes_Aluno);

//DEFININDO SESSÕES
$_SESSION['Nome'] = $Resultado_Informacoes_Aluno['Nome'];
$_SESSION['CodTurma'] = $Resultado_Informacoes_Aluno['CodTurma'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<title>Documento sem título</title>
</head>

<link rel="stylesheet" type="text/css" href="../../CSS/megamenu.css" />
<link rel="stylesheet" type="text/css" href="../../CSS/layout_index.css"/>
<link rel="stylesheet" type="text/css" href="../../CSS/formatacao.css"/>

<script type="text/javascript" src="../../JS/scripts.js"></script>

<body>

<!-- FRAME SUPERIOR	-->
<div id="framecontentTop">
    <div class="innertube">
    </div>
</div>



<!-- FOTO DO ALUNO -->
<div class="Foto_Aluno">
  <table width="120" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td height="9" colspan="3"><img src="../Imagens/Foto_Aluno/cima.png" width="120" height="9" /></td>
    </tr>
    <tr>
      <td rowspan="2"><img src="../Imagens/Foto_Aluno/esquerda.png" width="9" height="111" /></td>
      <td width="100" height="100"><div align="center" class="imgContainer"><img src="../Imagens/Avatares/microcamp.jpg" width="100" height="100" /></div></td>
      <td rowspan="2"><img src="../Imagens/Foto_Aluno/direita.png" width="11" height="111" /></td>
    </tr>
    <tr>
      <td><img src="../Imagens/Foto_Aluno/baixo.png" width="100" height="11" /></td>
    </tr>
  </table>
</div>


<!-- BARRA SEPARADORA -->
<div id="barra_separadora">
<img src="../Imagens/Esquema_Cores/separador.png" width="95%" height="2">
</div>


<!-- DIV SAIR -->
<div class="wrapper_menu menu_light_theme" id="sair">
<ul class="menu menu_lightblue">
<li class="right nodrop"><a href="../../Conexoes/Logout.php" target="_parent">Sair</a></li>
</ul>
</div>


<!-- MSG NOME ALUNO -->
<div id="msg_nome_aluno">
Bem Vindo(a) <?php echo $Resultado_Informacoes_Aluno['Nome'];?>, Hoje é <script type="text/javascript">

data = new Date();
dia = data.getDate();
mes = data.getMonth();
ano = data.getFullYear();

meses = new Array(12);

meses[0] = "Janeiro";
meses[1] = "Fevereiro";
meses[2] = "Mar&ccedil;o";
meses[3] = "Abril";
meses[4] = "Maio";
meses[5] = "Junho";
meses[6] = "Julho";
meses[7] = "Agosto";
meses[8] = "Setembro";
meses[9] = "Outubro";
meses[10] = "Novembro";
meses[11] = "Dezembro";

document.write (dia + " de " + meses[mes] + " de " + ano);

  </script> - Microcamp São Paulo Unidade <?php echo $Nome_Unidade; ?>
</div>






<!-- FOTO DO ALUNO -->
<div class="MenuCss">
<div class="wrapper_menu menu_light_theme"><!-- BEGIN MENU WRAPPER -->
    <ul class="menu menu_lightblue"><!-- BEGIN MENU -->
    
        <li class="nodrop"><a href="../../Joomla/index.php" target="FrameAluno">Home</a></li>
        
        <li><a href="#" class="drop">Informa&ccedil;&otilde;es</a>
         
          <!-- Begin 3 columns Item -->
          <div class="dropdown_2columns">
           
            <!-- Begin 3 columns container -->
            <div class="col_2 firstcolumn">
              <h2>Informações do Aluno.</h2>
             
              <div class="col_1 firstcolumn">
                <ul class="greybox">
                  <li><a href="Informacoes/Inf_Pessoais.php" target="FrameAluno">Inf. Pessoais</a></li>
                  <li><a href="Boletim/Mostra_Notas.php" target="FrameAluno">Boletim de Notas</a></li>
                  <li><a href="Faltas/Mostra_Faltas.php" target="FrameAluno">Faltas</a></li>
                  <li><a href="Informacoes/AulaCorrente.php" target="FrameAluno">Cronograma</a></li>
                </ul>
              </div>
              
              <div class="col_1">
                <p class="dark_grey_box">Tenha informações precisas em tempo real sobre suas seus dados pessoais, suas notas obtidas, faltas no curso e um cronograma completo do curso com a descrição da aula do dia.</p>
              </div>
                            
            </div>
            
            <!-- -->
            
          </div>
          <!-- End 3 columns container -->
        </li>
        <!-- End 5 columns Item -->
        <li><a href="#" class="drop">Minha Conta</a>
          <!-- Begin 3 columns Item -->
          <div class="dropdown_2columns">
            <!-- Begin 3 columns container -->
            <div class="col_2 firstcolumn">
              <h2>Preferencias</h2>
              <div class="col_1 firstcolumn">
                <ul class="greybox">
                  <li><a href="MinhaConta/Senha/AlteraSenha_1.php" target="FrameAluno">Alterar Senha</a></li>
                  <li><a href="#">Plano de Fundo</a></li>
                </ul>
              </div>
              <div class="col_1">
                <p class="strong">Use esta opção para alterar sua senha ou o Plano de Fundo.</p>
              </div>
            </div>
            <!-- -->
          </div>
          <!-- End 3 columns container -->
        </li>
        <!-- End 4 columns Item --><!-- End 3 columns Item --><!-- End 2 columns Item --><!-- End 1 column Item -->    
    
    </ul><!-- END MENU -->


</div>
</div>



<!-- FRAME DO CONTEUDO -->
<div id="maincontent">
    <div class="innertube">
    <iframe name="FrameAluno" src="http://www.alunos.microcampsp.com.br/Joomla" width="100%" height="100%" frameborder="0" allowtransparency="true"></iframe>
    </div>
</div>



<!-- FRAME DA BARRA DE STATUS -->
<div id="framecontentBottom">
    <div class="innertube">
        <center>
        <img src="../Imagens/Esquema_Cores/Barra_Branca_Index.png" width="799">
        </center>
    </div>
</div>


</body>
</html>
