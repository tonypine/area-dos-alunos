<?php

	$p_hash = $hash === "default" 	? '' : $hash.'/' ;
	$p_slug = $slug === "" 			? '' : $slug.'/' ;

	/* ======================================== */
	/* generate paginação */
	/* ====================================== */

	$paginacao = '';
    $currentPage = $p;
    $numPages = $q->max_num_pages;

	if($numPages > 1):
		$paginacao .= "<div id='paginacao'>";

			if($currentPage > 1):
				$paginacao .= "<a class='btnFirst' href='". $url ."/#/". $p_hash . $p_slug ."1'>Primeira</a>";
				$paginacao .= "<a class='btnPrev' href='". $url ."/#/". $p_hash . $p_slug . ($currentPage-1) ."'>◄</a>";
			else:
				$paginacao .= "<a class='btnFirst pDisabled' href='javascript:void();'>Primeira</a>";
				$paginacao .= "<a class='btnPrev pDisabled' href='javascript:void();'>◄</a>";
			endif;

			if($currentPage <= 3 || $numPages <= 5):
				$pageInit = 1;
			elseif(($numPages - $currentPage) < 2):
				$pageInit = $currentPage - 4 + ($numPages - $currentPage);
			else:
				$pageInit = $currentPage - 2;
			endif;

			for($i = $pageInit; $i <= 4 + $pageInit; $i++):

				$paginacao .= "<a ";
				if($currentPage == $i):
					$paginacao .= "class='btnNav pAtiva' href='". $url ."/#/". $p_hash . $p_slug ."'";
				else:
					$paginacao .= "class='btnNav' href='". $url ."/#/". $p_hash . $p_slug . $i ."'";
				endif;
				$paginacao .= ">". $i ."</a>";

				if($i >= $numPages) break;

			endfor;

			if($currentPage < $numPages):
				$paginacao .= "<a class='btnNext' href='". $url ."/#/". $p_hash . $p_slug . ($currentPage+1) ."'>►</a>";
				$paginacao .= "<a class='btnLast' href='". $url ."/#/". $p_hash . $p_slug . $numPages ."'>Última</a>";
			else:
				$paginacao .= "<a class='btnNext pDisabled' href='javascript:void();'>►</a>";
				$paginacao .= "<a class='btnLast pDisabled' href='javascript:void();'>Última</a>";
			endif;

		$paginacao .= "</div>";

	endif; ?>