<?php

	import_request_variables('g');
	$_s = (object) $_s;
	$gzfile = "cache/posts/post-".$slug.".gz";

	if (file_exists($gzfile) && (int) date("d", filemtime($gzfile)) == (int) date("d")):
		@readgzfile($gzfile);
	else:

		/* ======================================= */
		/* cURL */
		/* ======================================= */
			
			// Aqui entra o action do formulário - pra onde os dados serão enviados
			$cURL = curl_init();

			// ?appid=YahooDemo&query=persimmon&results=10

			$file = $url . "/_model-post-content.php";
			curl_setopt_array($cURL, array(
					// CURLOPT_URL				=>	"http://search.yahooapis.com/WebSearchService/V1/webSearch",
					CURLOPT_URL				=>	$file,
					CURLOPT_POST            =>  false,
					CURLOPT_VERBOSE         =>  false,
					// CURLOPT_POSTFIELDS      =>  "appid=YahooDemo&query=persimmon&results=10",
					CURLOPT_POSTFIELDS      =>  array(
													'slug' => $slug
												),
					CURLOPT_HEADER			=> 	false,
					CURLOPT_RETURNTRANSFER  =>  true
				));

			$output = curl_exec($cURL);
			// $error 	= curl_error($cURL);
			curl_close($cURL);

		/* ======================================= */
		/* # cURL */
		/* ======================================= */

		if(!is_dir("cache/posts/"))
			mkdir("cache/posts/");

		$fp = gzopen($gzfile, 'w9');
		gzwrite($fp, $output);
		gzclose($fp);

		echo $output;

	endif;?>