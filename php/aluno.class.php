<?php
	
	
	class aluno {
		
		public $info = null;		
		public $fields = Array(
			'Nome',
			'CodTurma',
			'DataNascimento'
		);
		public $freq = array();
		
		public function __construct() {
			$this->getAluno();
			$this->storeYearOld();
		}
		
		// busca as informações do aluno
		function getAluno() {
			
			// aluno
			$sql = "SELECT ";
			//$sql .= '*';
			$sql .= implode(",", $this->fields); 
			$sql .= " FROM TAB00200
					WHERE CodUnidade = '".$_SESSION['Unidade']."'
					AND CodCurso = '".$_SESSION['CodCurso']."'
					AND CTR = '".$_SESSION['Ctr']."'";
			
			$queryAluno = mysql_query($sql) or die ("Erro");
			
			// unidade
			$u = mysql_query("
			SELECT Unidade 
			FROM TAB_Unidades
			WHERE CodUnidade = '".$_SESSION['Unidade']."'
			") or die ("Erro");
			$uniNome = mysql_fetch_assoc($u);
			$unidade = $uniNome['Unidade'];
			
			$this->info = mysql_fetch_object($queryAluno);
			$this->info->unidade = $unidade;
			
		}
		
		function getFreq() {
			
			// frequencia
			//$sql = "SELECT ";
			//$sql .= implode(",", $this->fields); 
			$sql = "SELECT 
						A.DataFalta as data, 
						C.Modulo as modulo, 
						B.CodTurma as turma
					FROM 
						TAB00206 A
						LEFT OUTER JOIN 
							TAB00208 B ON B.CodTurma = A.CodTurma 
							and B.CodUnidade = A.CodUnidade 
							and B.DataAula = A.DataFalta
						LEFT OUTER JOIN 
							TAB00204 C ON C.Codigo = B.CodModulo 
							and C.CodUnidade = B.CodUnidade
					WHERE 
						A.CodUnidade = '".$_SESSION['Unidade']."'
						AND A.CodCurso = '".$_SESSION['CodCurso']."'
						AND A.CTR = '".$_SESSION['Ctr']."'
						ORDER BY A.DataFalta";
			
			//CONSULTANDO AS DATAS DAS FALTAS DO ALUNO
			$consulta_faltas = mysql_query($sql) or die ("Erro");
			
			while($obj = mysql_fetch_object($consulta_faltas)):
				array_push($this->freq, $obj);
			endwhile;
			 
			//$this->freq = mysql_fetch_object($consulta_faltas);
			
		}
		
		function storeYearOld() {
			
			$idade = preg_split("/ /", $this->info->DataNascimento);
			$data_nascimento = strtotime($idade[0]." 00:00:00");
		    $data_calcula = strtotime(date('Y-m-d')." 00:00:00");
		    $idade = floor(abs($data_calcula-$data_nascimento)/60/60/24/365);
		    $this->info->old = $idade;
			
		}
		
	}
	
?>