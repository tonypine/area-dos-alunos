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
	
    <!-- uInfo TEMPLATE -->
	<script id="t_uInfo" type="text/html">
	<tbody>
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
	</tbody>
	</script>

    <!-- Paginação TEMPLATE -->
    <script type="text/html" id="paginationTemplate">
        {{# if(data.page > 1){ }}
            <a class="btnFirst" href="1">Primeira</a>
            <a class="btnPrev" href="{{ data.page - 1 }}">◄</a>
        {{# } }}

        {{# if(data.page <= 3 || data.numPages < 6) {   var pageInit = 1;   } 
            else {                                      var pageInit = data.page - 2; }         

            for(var i = pageInit; i <= 5; i++) {                    }}

                <a {{# if(data.page == i) { }} class='btnNav pAtiva' href=''
                    {{# } else { }}class="btnNav" href='{{ i }}' {{# } }}
                    >{{ i }}</a>

        {{#     if(i >= data.numPages) break;
            } }}

        {{# if(data.page < data.numPages){ }}
            <a class="btnNext" href="{{ data.page + 1 }}">►</a>
            <a class="btnLast" href="{{ data.numPages }}">Última</a>
        {{# } }}
    </script>
  
  	<script type="text/javascript" src="<?php url(); ?>/js/plugins.js"></script>
	<script type="text/javascript">

	var session = <?php echo json_encode($_SESSION); ?>;
		var url = "<?php url(); ?>";
		
		function loadScript(src, op) {
			var d = document,
				s = 'script',
				done = false;

			var js, b = d.getElementsByTagName('body')[0];

			js = d.createElement(s); 
			if(op) {
				if(op.id) {
					var id = op.id;
					if (d.getElementById(id)) return;
					js.id = id;
				} 

				if(op.cb) var cb = op.cb;
			}
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

		// load(function() {
			// loadScript('<?php url(); ?>/js/plugins.js', { 
			//     id: "plugins", 
			//     cb: function(){
			//         loadScript('<?php url(); ?>/js/myScript.js');
			//         loadScript('<?php url(); ?>/js/lightbox-min.js', { id: 'lightbox-js' });
			//     } 
			// });
			// loadScript('<?php url(); ?>/js/myScript.js');
			// loadScript('<?php url(); ?>/js/lightbox-min.js', { id: 'lightbox-js' });
			//loadScrip

		function loadS() {
			loadScript('<?php url(); ?>/js/myScript.js');
			loadScript('<?php url(); ?>/js/lightbox-min.js', { id: 'lightbox-js' });
			//loadScript('//connect.facebook.net/pt_BR/all.js#xfbml=1', { id: 'facebook-jssdk' });
		};

	</script>
		
	</body>
</html>