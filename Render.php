<?php

class Render {
	
	public static function renderFile($file, $data) {
		ob_start();
		extract($data, EXTR_OVERWRITE);
		require_once($file.".php");
		$data = ['content' => ob_get_contents()];
		extract($data, EXTR_OVERWRITE);
		ob_end_flush();
	}
}
