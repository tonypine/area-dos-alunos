	<div id="rightSideBar">
		<aside id="aEvento">
			<?php
				$eventArgs = array(
						'post_type'			=>	'post',
						'category_name'		=>	'eventos',
						'posts_per_page'	=>	'1'
					);
				$eventQuery = new WP_Query( $eventArgs );
				//dump($eventQuery);	
				while ($eventQuery->have_posts()): $eventQuery->the_post();
					$pLink = $wpurl."/#/post/".basename(get_permalink());
					echo "<header>";
						echo "<h3 class='orangeDot'>Próximo evento</h3>";
						echo "<hr class='bottomLine'>";
					echo "</header>";
					echo "<a class='aThumb' href='".$pLink."'>".get_the_post_thumbnail( $post_id = get_the_ID(), $size = array(334, 220))."</a>";
					echo "<h4><a href='".$pLink."'>".get_the_title()."</a></h4>";
					echo get_the_excerpt();
					echo "<p>";
					echo "<a class='leiaMais' href='".$pLink."''>continuar lendo →</a>";
					echo "</p>";
				endwhile;
			 ?>
		</aside>
		<hr class="dotLine" />
		<aside id="acesse">
			<h3 class="blueDot">Acesse!</h3>
			<ul id="bannersList">
				<li><a href="#"><img src="<?php url(); ?>/images/banners/banner1.png" /></a></li>
				<li><a href="#"><img src="<?php url(); ?>/images/banners/banner2.png" /></a></li>
			</ul>
		</aside>
		<hr class="dotLine" />
		<aside id="facebook">
			<div id="fbLikeBox" class="fb-like-box" data-href="https://www.facebook.com/OficialMicrocampSP" data-width="220" data-show-faces="true" data-stream="false" data-header="false"></div>
		</aside>
	</div><!-- #secondary .widget-area -->

