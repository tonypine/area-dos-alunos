	
	<aside id="navSidebar">
		<nav id="mainNav" class="navMenu">
			<ul>
				<?php
					$menu = wp_get_nav_menu_object( 'main-menu' );
					$args = array(
							'order'			=>	"ASC",
							'orderby'		=>	"menu_order",
						);
					$menu_itens = wp_get_nav_menu_items($menu->term_id, $args);
					foreach ( (array) $menu_itens as $menu_item ) {
						echo "<li><a id='btn-".basename( $menu_item->url )."' href='".$menu_item->url."'>".$menu_item->title."</a></li>";
					}
				?>
				<li><a id="btnHome" href="index.php">Visão Geral</a></li>
				<li><a id="btnBoletim" href="#">Boletim</a></li>
				<li><a id="btnFreq" href="frequencia.php">Frequência</a></li>
				<li><a id="btnCrono" href="#">Cronograma</a></li>
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
						echo "<li><a id='secondary-item".$i."' href='".$menu_item->url."'>".$menu_item->title."</a></li>";
					}
				?>
			</ul>
		</nav>
	</aside><!-- #secondary .widget-area -->
