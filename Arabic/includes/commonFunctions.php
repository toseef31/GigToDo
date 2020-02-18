<?php

function redirect($url){
	echo "<script>window.open('$url','_self');</script>";
}

function successRedirect($text,$url){
	echo "<script>alert_success('$text','$url');</script>";
}

function messageRedirect($text,$url){
	echo "<script>
	alert('$text');
	window.open('$url','_self');
	</script>";
}

function showMessage($text){
	echo "<script>alert('$text')</script>";
}