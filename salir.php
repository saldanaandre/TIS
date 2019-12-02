<?php
	session_start();
	session_destroy();
	//unset($_SESSION['dni']);

	header("location:one.html");

?>