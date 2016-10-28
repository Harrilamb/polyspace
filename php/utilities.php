<?php
	function cleanString($dirty){
		$clean=str_replace("\\", "\\\\", $dirty);
		return $clean;
	};
?>