<?php

	class gzip {

		public $status 	= '';
		public $dir 	= '';
		public $file 	= '';
		public $content = '';

		function __construct($args = array()) {
			foreach($args as $k => $v):
				$this->$k = $v;
			endforeach;
		}

		public function write() {

			/* write gzip file */
			if(!is_dir("cache/"))
				mkdir("cache/");

			if(!is_dir("cache/".$this->dir."/"))
				mkdir("cache/".$this->dir."/");

			if( $fp = gzopen($this->file, 'w9') ):
				gzwrite($fp, $this->content);
				gzclose($fp);
				$this->status = 'Arquivo de cache gravado com sucesso.';
			else:
				$this->status = 'Não foi possível abrir o arquivo.';
			endif;
		}
	} 
?>