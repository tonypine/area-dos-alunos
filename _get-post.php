<?php

	import_request_variables('g');
	$_s = (object) $_s;
	$gzfile = "cache/posts/post-".$slug.".gz";

	if (@file_exists($gzfile)):
		@readgzfile($gzfile);
	else:

		/* ======================================= */
		/* cURL */
		/* ======================================= */

			require_once 'php/_curl.php';

			$output = '';
			$cURL = new cURL(array(
					'url' 		=> $url . "/_model-post-content.php",
					'data'		=> array( 'slug' => $slug )
				));
			
			$output = $cURL->exec();

		/* ======================================= */
		/* # cURL */
		/* ======================================= */

		if(!is_dir("cache/posts/"))
			mkdir("cache/posts/");

		$fp = gzopen($gzfile, 'w9');
		gzwrite($fp, $output);
		gzclose($fp);

		echo $output;

	endif; ?>