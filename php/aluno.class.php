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
		public $codUnidade ;
		public $codCurso ;
		public $ctr 	;
		
		public $info;		
		public $aFields = Array(
			'Nome as nome',
			'CodTurma as codTurma',
			'DataNascimento as dataNascimento'
		);

		public $modulos;		
		public $modFields = Array(
			'TAB00207.CodModulo AS codModulo', 
			'TAB00212.Descricao AS descricao'
		);

		public $freq;
		public $cron;

		public $mysqli;

		public $debug = array();
		
		public function __construct($codUnidade, $codCurso, $ctr) {
			if(!$codUnidade || !$codCurso || !$ctr)
				return false;

			$this->codUnidade 	= $codUnidade;
			$this->codCurso 	= $codCurso;
			$this->ctr 			= $ctr;
			
			require_once 'conexao.php';
			$this->mysqli = $mysqli;
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

			$queryAluno = $this->mysqli->query($sql) or die ("Erro");
			
			/* unidade */
			$u = $this->mysqli->query("
			SELECT Unidade 
			FROM TAB_Unidades
			WHERE CodUnidade = '".$this->codUnidade."'
			") or die ("Erro 2");
			$uni = $u->fetch_object();

			$info = $queryAluno->fetch_object();
			$info->unidade = utf8_encode( $uni->Unidade );

			$info->nome = ucwords(strtolower($info->nome));


			$idade = preg_split("/ /", $info->dataNascimento);
			$data_nascimento = strtotime($idade[0]." 00:00:00");
		    $data_calcula = strtotime(date('Y-m-d')." 00:00:00");
		    $old = floor(abs($data_calcula-$data_nascimento)/60/60/24/365);
			
		    $info->old = $old;
		    $info->dataNascimento = str_replace("-", "/", $idade[0]);

			$this->info = $info;
		}

		/* ==================================== */
		/* Query Modulos */
		/* ================================== */
		public function getModulos() {

			$this->getAluno();

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

			$queryModulos = $this->mysqli->query( $sql ) or die('Erro ao buscar módulos');
			
			/* ---------------------------------------------------------- */
			/* Filtering queries and setup the main modulos object */
			/* -------------------------------------------------------- */

			$modulos = Array();
			$modCods = Array();
			while($m = $queryModulos->fetch_object() ):

				$m->descricao = formatText( utf8_encode($m->descricao) );
				$modCods[] = $m->codModulo;
				array_push($modulos, $m);

			endwhile;
			
			/* ------------------------------------- */
			/* Getting Nota os modules */
			/* ----------------------------------- */
			$queryNota = $this->mysqli->query("
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
				$m->nota = $queryNota->fetch_object();
			}

			$this->modulos = $modulos;

		}
		
		/* ==================================== */
		/* Query Aulas */
		/* ================================== */

		public function doQueryAulas()	{

			global $mysqli;

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

			$queryAulas = $this->mysqli->query($sql) or die ("Erro ao buscar as Aulas.");
			$this->queryAulas = $queryAulas;

		}
		
		/* ==================================== */
		/* Frequêncy */
		/* ================================== */

		public function getFrequency() {

			$queryAulas = $this->queryAulas;
			$queryAulas->data_seek(0);

			/* ------------------------------------------- */
			/* Setup the modules and faltas object
			/* ----------------------------------------- */
			
			$this->freq->faltas = Array();
			$modulos = Array();
			while($aula = $queryAulas->fetch_object() ):

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
				$this->debug[$aula->CodModulo] = $aula;
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
			$qAulas->data_seek(0);

			/* ------------------------------------------- */
			/* Setup the modules object
			/* ----------------------------------------- */
			
			$modulos = Array();
			while($a = $qAulas->fetch_object()):

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