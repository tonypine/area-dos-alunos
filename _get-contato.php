<?php

	/* load get variables */
	import_request_variables('g');
	$_s = (object) $_s;

	/* gzip file */	
	$gzfile = "cache/pages/p-contato.gz";

	if (!file_exists($gzfile)):
		@readgzfile($gzfile);
	else:

		/* cURL */
		require_once 'php/_curl.php';
		$cURL = new cURL(array(
				'url' 		=> $url . "/_model-page-contato.php",
				'data'		=> array( "slug" => $hash ) ));
		$output = $cURL->exec();

		/* write gzip file */
		if(!is_dir("cache/pages/"))
			mkdir("cache/pages/");

		$fp = gzopen($gzfile, 'w9');
		gzwrite($fp, $output);
		gzclose($fp);

		echo $output; 

	endif; ?>