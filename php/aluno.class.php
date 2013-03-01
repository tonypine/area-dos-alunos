<?php
	

	/* ==================================== */
	/* Format text */
	/* ================================== */
	function formatText($text = '') {
		return ucwords(str_replace("/", " / ", strtolower( $text )));
	}

	/* ==================================== */
	/* Format date */
	/* ================================== */
	function formatDate($date = '') {
		$d = explode(" ", $date); 
        $d = explode("-", $d[0]); 
        return $d[2]."/".$d[1]."/".$d[0];
	}

	/* ==================================== */
	/* Class Aluno */
	/* ================================== */
	
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
		public $cron = null;
		
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

				$m->descricao = formatText( utf8_encode($m->descricao) );
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
		/* Query Aulas */
		/* ================================== */

		public function doQueryAulas()	{

			/* ----------------------------------------------------------- */
			/* Nova Master Query Sou Foda -- Getting Data Aulas/Faltas
			/* --------------------------------------------------------- */

			$sql = "SELECT 
						a.CodModulo,
						m.Modulo as modulo,
						a.DataAula,
						f.DataFalta as falta, 
						a.Apurado,
						a.ResumoMateria as resumo,
						a.PrevisaoMateria,
						f.CTR as ctr
					FROM 
						TAB00208 a
						LEFT JOIN
							TAB00206 f
							ON
								f.CodTurma = a.CodTurma
								AND f.DataFalta = a.DataAula
								AND f.CTR = '".$this->ctr."'
								AND f.CodUnidade = a.CodUnidade
						LEFT JOIN
							TAB00204 m
							ON
								m.Codigo = a.CodModulo
								AND m.CodUnidade = a.CodUnidade

					WHERE
						a.CodTurma = '".$this->info->codTurma."'
						AND	a.CodUnidade = '".$this->codUnidade."'
					ORDER BY a.DataAula, f.DataFalta";

			$queryAulas = mysql_query($sql) or die ("Erro ao buscar as Aulas.");
			$this->queryAulas = $queryAulas;
		}
		
		/* ==================================== */
		/* Frequêncy */
		/* ================================== */

		public function getFrequency() {
			
			$queryAulas = $this->queryAulas;

			/* ------------------------------------------- */
			/* Setup the modules and faltas object
			/* ----------------------------------------- */
			
			$this->freq->faltas = Array();
			$modulos = Array();
			while($aula = mysql_fetch_object($queryAulas)):

				if(!isset($modulos[$aula->CodModulo])):
					$modulos[$aula->CodModulo] = (object) Array(
						"name"			=> utf8_encode( formatText($aula->modulo) ),
						"porcentagem"	=> 0,
						"faltas"		=> 0,
						"presencas"		=> 0,
						"iniciado"		=> $aula->Apurado,
						"total"			=> 0
					);
				endif;

				/* se o módulo já foi iniciado */
				if($aula->Apurado):

					if(gettype($aula->falta) != 'NULL'):
						$modulos[$aula->CodModulo]->faltas++;
						$this->freq->totalFaltas++;

						/* faltas object */
						$aula->falta 	= formatDate( $aula->falta );
						array_push($this->freq->faltas, $aula);
					else:
						$modulos[$aula->CodModulo]->presencas++;
						$this->freq->totalPresencas++;
					endif;
					$this->freq->total++;

				endif;
				$modulos[$aula->CodModulo]->total++;

			endwhile;
			mysql_data_seek($queryAulas, 0);

			foreach ($modulos as $key => $m)
				if($m->iniciado) $m->porcentagem = round( (100 / $m->total) * $m->presencas, 1 );

			$this->freq->modulos = $modulos;
			$this->freq->totalPorcentagem = round( (100 / $this->freq->total) * $this->freq->totalPresencas, 1 );
		}		
		
		/* ==================================== */
		/* Cronogram */
		/* ================================== */

		public function setupCronogram() {
			
			$qAulas = $this->queryAulas;
			mysql_data_seek($qAulas, 0);

			/* ------------------------------------------- */
			/* Setup the modules object
			/* ----------------------------------------- */
			
			$modulos = Array();
			while($a = mysql_fetch_object($qAulas)):

				$cod = $a->CodModulo;
				if(!isset($modulos[$cod])):
					$modulos[$cod] = (object) Array(
						"name"			=> utf8_encode( formatText($a->modulo) ),
						"aulas"			=> Array()
					);
				endif;

				$modulos[$cod]->aulas[] = (object) Array(
								"data"		=> formatDate( $a->DataAula ),
								"presenca"	=> 0,
								"descricao"	=> ucwords( str_replace(array("Ç","Ã"),array("ç","ã"),strtolower( utf8_encode( $a->resumo ) )) )
							);

				if(gettype($a->falta) == 'NULL')
					end($modulos[$cod]->aulas)->presenca = 1;

			endwhile;

			$this->cron = $modulos;
		}		
		
	}
	
?>