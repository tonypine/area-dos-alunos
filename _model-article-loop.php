<?php

	$i = 0;
	function showPost() {

		global $numPosts, $i, $url;

		$pLink = $url."/#/post/".basename(get_permalink());
		$i++;

		$c = get_the_category();
		$c = array_slice( $c, 0, 5 );

		$output .= "<article class='excerpt-article'>";
			$output .= "<h3><a href='". $pLink ."'>". get_the_title() ."</a></h3>";
			$output .= "<div class='excerpt-info'>";
				$output .= "<span class='date'>". get_the_date() ."</span>";
				$output .= "<span class='cat'>Categoria: ";

					$iCat = 0;
					$catLength = (int) sizeof($c);
					foreach ($c as $cat) {
						$iCat++;
						$output .= "<a href='".$url."/#/category/".basename(get_category_link($cat->term_id ))."'>".$cat->name."<a/>";
						if($iCat < $catLength) $output .= ", ";
					}

				$output .= "</span>";
			$output .= "</div>";
			$output .= "<div class='excerpt-text'>";
				$output .= get_the_excerpt();
			$output .= "</div>";
			
			if(has_post_thumbnail()):
				$output .= "<a class='excerpt-thumb' href='". $pLink ."' title='". get_the_title() ."'>";
					$output .= get_the_post_thumbnail( $post_id = get_the_ID(), $size = 'excerpt-thumb', $attr = '' );
				$output .= "</a>";
			endif;
			
			$output .= "<a class='leiaMais' href='". $pLink ."'>continuar lendo →</a>";
		$output .= "</article>";
		if($i < $numPosts) $output .= "<hr>"; 

		return $output;

	} ?>