<?php 	/* ======================================= */
		/* cURL */
		/* ======================================= */
		
		class cURL {
			
			public $curl 		= null;
			public $url 		= 'undefined';
			public $data 	= 'undefined';
			public $output 		= 'undefined';

			function __construct($args = array()) {

				// Aqui entra o action do formulário - pra onde os dados serão enviados
				$this->curl 	= curl_init();
				$this->url 		= $args['url'];
				$this->data = $args['data'];

				$this->setOpt();

			}

			public function setOpt() {

				curl_setopt_array($this->curl, array(
						CURLOPT_URL				=>	$this->url,
						CURLOPT_POST            =>  false,
						CURLOPT_VERBOSE         =>  false,
						CURLOPT_POSTFIELDS      =>  $this->data,
						CURLOPT_HEADER			=> 	false,
						CURLOPT_RETURNTRANSFER  =>  true
					));

			}

			public function exec() {

				$output = curl_exec($this->curl);
				// $error 	= curl_error($cURL);
				curl_close($this->curl);

				return $output;

			}


		}

		/* ======================================= */
		/* # cURL */
		/* ======================================= */ ?>