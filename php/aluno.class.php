<?php
	
	
	class aluno {

		// global
		public $codUnidade 	= null;
		public $codCurso 	= null;
		public $ctr 		= null;
		
		public $info = null;		
		public $aFields = Array(
			'Nome',
			'CodTurma',
			'DataNascimento'
		);

		public $modulos = null;		
		public $modFields = Array(
			'TAB00207.CodModulo AS CodModulo', 
			'TAB00212.Descricao AS Descricao'
		);

		public $freq = array();
		
		public function __construct() {
			$this->codUnidade 	= $_SESSION['Unidade'];
			$this->codCurso 	= $_SESSION['CodCurso'];
			$this->ctr 			= $_SESSION['Ctr'];
			
			$this->getAluno();
			$this->storeYearOld();
		}
		
		// busca as informações do aluno
		public function getAluno() {
			
			// aluno
			$sql  = "SELECT ";
			//$sql .= '*';
			$sql .= implode(",", $this->aFields); 
			$sql .= " FROM TAB00200
					WHERE CodUnidade = '".$this->codUnidade."'
					AND CodCurso = '".$this->codCurso."'
					AND CTR = '".$this->ctr."'";
			
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
			$this->info->unidade = utf8_encode( $unidade );
			
		}

		public function getModulos() {

			$sql  = "SELECT ";
			$sql .= implode(",", $this->modFields);
			$sql .= " FROM TAB00207, TAB00212
					WHERE TAB00207.CodUnidade = '".$this->codUnidade."'
					AND TAB00207.CodUnidade = TAB00212.CodUnidade
					AND TAB00207.CodTurma = '".$this->info->CodTurma."'
					AND TAB00207.CodModulo = TAB00212.CodModulo
					GROUP BY TAB00212.CodModulo
					ORDER BY TAB00212.CodModulo ASC";

			$queryModulos = mysql_query( $sql ) or die('Erro ao buscar módulos');
			$this->modulos = mysql_fetch_object( $queryModulos );

		}
		
		public function getFreq() {
			
			// frequencia
			//$sql = "SELECT ";
			//$sql .= implode(",", $this->aFields); 
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
		
		public function storeYearOld() {
			
			$idade = preg_split("/ /", $this->info->DataNascimento);
			$data_nascimento = strtotime($idade[0]." 00:00:00");
		    $data_calcula = strtotime(date('Y-m-d')." 00:00:00");
		    $idade = floor(abs($data_calcula-$data_nascimento)/60/60/24/365);
		    $this->info->old = $idade;
			
		}
		
	}
	
?>