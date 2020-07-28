<?php

session_start();

require_once("includes/db.php");

require_once("functions/functions.php");

switch($_REQUEST['zAction']){

	default:
		get_category_proposals();
	break;
	
	case "get_search_proposals":
		get_search_proposals();
		// print_r($_REQUEST['zAction']);
	break;
	
	case "get_search_proposals_sidebar":
		get_search_proposals_sidebar();
		// print_r($_REQUEST['zAction']);
	break;
	
	case "get_search_price_proposals":
		get_search_price_proposals();
		// print_r($_REQUEST['zAction']);
	break;
	
	case "get_category_pagination":
		get_category_pagination();
	break;

}
