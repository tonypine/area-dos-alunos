<?php
	
	
	class aluno {

		/* ==================================== */
		/* Vars */
		/* ================================== */
		public $codUnidade 	= null;
		public $codCurso 	= null;
		public $ctr 		= null;
		
		public $info = null;		
		public $aFields = Array(
			'Nome as nome',
			'CodTurma as codTurma',
			'DataNascimento as dataNascimento'
		);

		public $modulos = null;		
		public $modFields = Array(
			'TAB00207.CodModulo AS codModulo', 
			'TAB00212.Descricao AS descricao'
		);

		public $freq = null;
		
		public function __construct() {
			$this->codUnidade 	= $_SESSION['Unidade'];
			$this->codCurso 	= $_SESSION['CodCurso'];
			$this->ctr 			= $_SESSION['Ctr'];
			
			//$this->getAluno();
		}
		
		/* ==================================== */
		/* Query Aluno */
		/* ================================== */
		public function getAluno() {
			
			// aluno
			$sql  = "SELECT ";
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

			$idade = preg_split("/ /", $this->info->dataNascimento);
			$data_nascimento = strtotime($idade[0]." 00:00:00");
		    $data_calcula = strtotime(date('Y-m-d')." 00:00:00");
		    $idade = floor(abs($data_calcula-$data_nascimento)/60/60/24/365);
		    $this->info->old = $idade;
			
		}

		/* ==================================== */
		/* Query Modulos */
		/* ================================== */
		public function getModulos() {

			/* ------------------------------------- */
			/* Getting modules */
			/* ----------------------------------- */

			$sql  = "SELECT ";
			$sql .= implode(",", $this->modFields);
			$sql .= " FROM TAB00207, TAB00212
					WHERE TAB00207.CodUnidade = '".$this->codUnidade."'
					AND TAB00207.CodUnidade = TAB00212.CodUnidade
					AND TAB00207.CodTurma = '".$this->info->codTurma."'
					AND TAB00207.CodModulo = TAB00212.CodModulo
					GROUP BY TAB00212.CodModulo
					ORDER BY TAB00212.CodModulo ASC";

			$queryModulos = mysql_query( $sql ) or die('Erro ao buscar módulos');
			
			/* ---------------------------------------------------------- */
			/* Filtering queries and setup the main modulos object */
			/* -------------------------------------------------------- */

			$modulos = Array();
			$modCods = Array();
			while($m = mysql_fetch_object( $queryModulos )):

				$m->descricao = $this->formatText( utf8_encode($m->descricao) );
				$modCods[] = $m->codModulo;
				array_push($modulos, $m);

			endwhile;
			
			/* ------------------------------------- */
			/* Getting Nota os modules */
			/* ----------------------------------- */

			$queryNota = mysql_query("
			SELECT C.Codigo, AVG(E.Nota) AS nota
			FROM TAB00200 A
			INNER JOIN TAB00005 B ON B.CodUnidade = A.CodUnidade AND B.Codigo = A.CodCurso
			INNER JOIN TAB00204 C ON C.CodUnidade = A.CodUnidade AND C.CodProduto = B.CodProduto
			INNER JOIN TAB00212 D ON D.CodUnidade = A.CodUnidade AND D.CodModulo = C.Codigo
			LEFT JOIN TAB00209 E ON E.CodUnidade = A.CodUnidade AND E.CodCurso = A.CodCurso AND E.CTR = A.CTR AND D.CodProva = E.CodProva
			WHERE A.CodUnidade = '".$this->codUnidade."' AND A.CodTurma = '".$this->info->codTurma."' AND (A.Status = 'AT' OR A.Status = 'ES') AND A.CTR = '".$this->ctr."' AND C.Codigo IN(". implode(",", $modCods) .")
			GROUP BY C.Codigo
			ORDER BY A.Nome, C.Codigo ASC
			") or die('Não foi possível buscar a nota do Modulo');
			
			/* ------------------------------------- */
			/* Add Notas to the modules object */
			/* ----------------------------------- */

			foreach ($modulos as $key => $m) {
				$m->nota = mysql_fetch_object( $queryNota );
			}

			$this->modulos = $modulos;

		}
		
		/* ==================================== */
		/* Query Faltas */
		/* ================================== */
		public function getFrequency() {
			
			/* --------------------- */
			/* Getting faltas
			/* ------------------- */

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
			
			$queryFaltas = mysql_query($sql) or die ("Erro ao buscar as faltas.");
			
			/* -------------------------------------- */
			/* Getting lessons num by modules
			/* ------------------------------------ */

			$sql = "SELECT 
						COUNT(A.CodModulo) as numAulas, 
						A.CodModulo,
						Case A.Apurado 
							when 1 
								then 'Apurado' 
							when 0 
								then 'NaoApurado' end as Apurado, 
						B.Modulo as nome
					FROM 
						TAB00208 A
						LEFT OUTER JOIN 
							TAB00204 B ON B.Codigo = A.CodModulo
							AND A.CodUnidade = B.CodUnidade
					WHERE
						A.CodUnidade =  '".$_SESSION['Unidade']."'
						AND A.CodTurma = '" .$this->info->codTurma. "'
						GROUP BY A.CodModulo";

			$queryLessons = mysql_query($sql) or die("Não foi possível contar as aulas.	");	
			
			/* ------------------------------ */
			/* Setup the freq object
			/* ---------------------------- */

			$this->freq->faltas = Array();
			$this->freq->modulos = Array();
			
			while ($m = mysql_fetch_object($queryLessons)):
				$this->freq->total += $m->numAulas;
				$this->freq->modulos[] = $m;
			endwhile;
			
			while($falta = mysql_fetch_object($queryFaltas)):

				/* format faltas */
				$falta->modulo 	= $this->formatText( utf8_encode($falta->modulo) );
				$falta->data 	= $this->formatDate( $falta->data );

				/* add faltas to the array */
				array_push($this->freq->faltas, $falta);

			endwhile;
			
		}

		/* ==================================== */
		/* Format text */
		/* ================================== */
		private function formatText($text = '') {
			return ucwords(str_replace("/", " / ", strtolower( $text )));
		}

		/* ==================================== */
		/* Format date */
		/* ================================== */
		private function formatDate($date = '') {
			$d = explode(" ", $date); 
            $d = explode("-", $d[0]); 
            return $d[2]."/".$d[1]."/".$d[0];
		}
		
		
	}
	
?>