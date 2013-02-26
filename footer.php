<?php $base = 'Sistema/Aluno2/'; ?>			
			<footer id="main">
				<div id="fooIn">
				<p style="float: left">ACESSE TAMBÉM  ^_^</p> 
					<ul id="fooIcons" class="cf">
						<li><a id="icoMcsp" href="#">MicrocampSP</a></li>
						<li><a id="icoWeb" href="#">Blog WebDesign</a></li>
						<li><a id="icoInf" href="#">Blog Informática</a></li>
						<li><a id="icoTI" href="#">Blog TI</a></li>
						<li><a id="icoABC" href="#">Blog ABC</a></li>
						<li><a id="icoHard" href="#">Blog Hardware</a></li>
					</ul>
				</div>
			</footer><!-- #colophon -->
		</div><!-- #mainContainer -->
	
        <script type="text/javascript">
            var gOverride = {
              urlBase: 'http://gridder.andreehansson.se/releases/latest/',
              gColor: '#EEEEEE',
              gColumns: 12,
              gOpacity: 0.35,
              gWidth: 10,
              pColor: '#ff0000',
              pHeight: 22,
              pOffset: 0,
              pOpacity: 0.45,
              center: true,
              gEnabled: false,
              pEnabled: true,
              setupEnabled: true,
              fixFlash: true,
              size: 960
            };
        </script>
	
		<!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
		<script>window.jQuery || document.write('<script src="js/libs/jquery-1.7.1.min.js"><\/script>')</script>

		<script type="text/javascript">

			function loadScript(src, id, callback) {
				var d = document,
					s = 'script',
					done = false;
				var js, fjs = d.getElementsByTagName(s)[0];
				if (d.getElementById(id)) return;
				js = d.createElement(s); js.id = id;
				js.src = src;
                js.type = 'text/javascript';
                js.charset = 'utf-8';
                js.onload = js.onreadstatechange = function() {
                    if (!done && (!this.readyState || this.readyState == 'loaded' || this.readyState == 'complete')) {
                        done = true;
                        js.onload = js.onreadystatechange = null;
                            if (callback) {
                                callback();
                            }
                        }
                }
				fjs.parentNode.insertBefore(js, fjs);
			}

			var url = "<?php url(); ?>";

            loadScript('<?php url(); ?>/js/myScript.js?v=1');
            loadScript('<?php url(); ?>/js/lightbox-min.js?v=1', 'lightbox-js');
            loadScript('//connect.facebook.net/pt_BR/all.js#xfbml=1','facebook-jssdk');

        </script>
		
	</body>
</html>