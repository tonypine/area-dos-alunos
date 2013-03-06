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
	
	<script id="t_uInfo" type="text/html">
		<tr>
			<td>{{ nome }}</td>
			<td>Curso: Informática</td>
		</tr>
		<tr>
			<td>{{ old }} anos</td>
			<td>Módulo: 4 Desenho Digital</td>
		</tr>
		<tr>
			<td><a href="" class="blueLink">editar perfil</a></td>
			<td>Unidade: {{ unidade }}</td>
		</tr>
	</script>

	<script type="text/javascript">
    <?php global $session; ?>
    var session = <?php echo json_encode($_SESSION); ?>;

		var url = "<?php url(); ?>";
        
        function loadScript(src, op) {
            var d = document,
                s = 'script',
                done = false;
            
            if(op) {
              var id = op.id,
                  cb = op.cb; }

            var js, b = d.getElementsByTagName('body')[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;

            js.src = src;
            js.type = 'text/javascript';

            /* on load */
            js.onload = js.onreadystatechange = function() {
                if ( !done && (!this.readyState || this.readyState === "loaded" || this.readyState === "complete") ) {
                    done = true;

                    // Handle memory leak in IE
                    js.onload = js.onreadystatechange = null;

                    if(cb)
                        cb();
                }
            };

            b.insertBefore(js, b.firstChild);
        }

        function load(f, o) {
            if(!o)
                var o = window;
            // Check for browser support of event handling capability
            if (o.addEventListener)
            o.addEventListener("load", f, false);
            else if (o.attachEvent)
            o.attachEvent("onload", f);
            else o.onload = f;
        }

        load(function() {
            loadScript('<?php url(); ?>/js/plugins.js', { 
                id: "plugins", 
                cb: function(){
                    loadScript('<?php url(); ?>/js/myScript.js');
                    loadScript('<?php url(); ?>/js/lightbox-min.js', { id: 'lightbox-js' });
                } 
            });
            // loadScript('//connect.facebook.net/pt_BR/all.js#xfbml=1', { id: 'facebook-jssdk' });
        });

    </script>
		
	</body>
</html>