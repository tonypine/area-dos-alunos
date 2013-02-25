	
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
					echo "<h3 class='orangeDot'>Próximo evento</h3>";
					echo "<a class='aThumb' href='".get_permalink()."'>".get_the_post_thumbnail( $post_id = get_the_ID(), $size = 'excerpt-event-thumb')."</a>";
					echo "<h4><a href='".get_permalink()."'>".get_the_title()."</a></h4>";
					echo "<p>".get_the_excerpt()."</p>";
					echo "<a class='leiaMais' href='".get_permalink()."''>continuar lendo →</a>";
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

