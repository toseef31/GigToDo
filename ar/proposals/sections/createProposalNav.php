<?php 

$approve_proposals = $row_general_settings->approve_proposals;

if($approve_proposals == "yes"){ 
	$text = "Submit For Approval"; 
}else{ 
	$text = "Publish"; 
}

?>
<nav id="tabs">

	<div class="container">

		<div class="breadcrumb flat mb-0 nav" role="tablist">
			<a class="nav-link active" href="#overview">Overview</a>
			
			<a class="nav-link <?php if($checkVideo==false){echo"d-none";} ?> <?= (isset($_GET['video']) ? "active" : ""); ?>" href="#video">Video Settings</a>

			<a class="nav-link <?php if(isset($_GET['pricing']) or isset($_GET['publish'])){ echo "active"; } ?> <?php if(isset($checkVideo) and $checkVideo==true){echo"d-none";} ?>" href="#pricing">Pricing</a>

			<a class="nav-link <?= (isset($_GET['publish']) ? "active" : ""); ?>" href="#description">Description & FAQ</a>
			<a class="nav-link <?= (isset($_GET['publish']) ? "active" : ""); ?>" href="#requirements">Requirements</a>
			<a class="nav-link <?= (isset($_GET['publish']) ? "active" : ""); ?>" href="#gallery">Gallery</a>
			<a class="nav-link <?= (isset($_GET['publish']) ? "active" : ""); ?>" href="#publish"><?= $text; ?></a>
		</div>

	</div>

</nav>