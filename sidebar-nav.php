<?php $site = get_bloginfo( 'wpurl' ); ?>
	<aside id="navSidebar">
		<nav id="mainNav" class="navMenu">
			<ul>
				<li>
					<!-- -->
					<a id="btn-home" href="<?php echo get_bloginfo( 'wpurl' ); ?>/#/visao-geral"><div class="icon"></div>Visão Geral</a>
					
				</li>
				<?php
					$menu = wp_get_nav_menu_object( 'main-menu' );
					$args = array(
							'order'			=>	"ASC",
							'orderby'		=>	"menu_order",
						);
					$menu_itens = wp_get_nav_menu_items($menu->term_id, $args);
					foreach ( (array) $menu_itens as $menu_item ) {
						echo "<li><a id='btn-".basename( $menu_item->url )."' href='".$site."/#/".basename($menu_item->url)."'><div class='icon'></div>".$menu_item->title."</a></li>";
					}
				?>
			</ul>
		</nav>
		<hr class="dotLine" />
		<nav id="subNav" class="navMenu">
			<ul>
				<?php
					$menu = wp_get_nav_menu_object( 'secondary-menu' );
					$args = array(
							'order'			=>	"ASC",
							'orderby'		=>	"menu_order",
						);
					$menu_itens = wp_get_nav_menu_items($menu->term_id, $args);
					$i = 0;
					foreach ( (array) $menu_itens as $menu_item ) {
						$i = $i + 1;
						$basename = split($site, $menu_item->url); $basename = $basename[1];
						$basename = preg_replace("/\/$/", "$1", $basename);
						$basename = preg_replace("/^\//", "$1", $basename);
						// echo "<!-- ". var_dump( $basename )." -->";
						echo "<li><a id='secondary-item".$i."' href='".$site."/#/".$basename."'>".$menu_item->title."</a></li>";
					}
				?>
			</ul>
		</nav>
	</aside><!-- #secondary .widget-area -->
