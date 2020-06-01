<?php 

$approve_proposals = $row_general_settings->approve_proposals;

if($approve_proposals == "yes"){ 
	$text = "Submit For Approval"; 
}else{ 
	$text = "Publish"; 
}

?>

<!-- Post a gig overview step -->
<section class="container-fluid postgig-step">
  <div class="row">
    <div class="container">
      <div class="postgig-step-container">
        <div class="postgig-step-wrapper d-flex flex-row justify-content-between" role="tablist">
          <div class="postgig-step-item active<?php if(!isset($_GET['video']) AND !isset($_GET['pricing']) and !isset($_GET['publish'])){ echo " show active"; } ?>">
            <div class="icon">
              <img alt="" class="icon-active" src="<?= $site_url; ?>/assets/img/post-a-gig/overview-icon-red.png" />
              <img alt="" class="icon-inactive" src="<?= $site_url; ?>/assets/img/post-a-gig/overview-icon-gray.png" />
            </div>
            <div class="step">
              <span>1</span>
            </div>
            <div class="title">Overview</div>
          </div>
          <!-- Each item -->
          <div class="postgig-step-item <?php if(isset($_GET['pricing']) or isset($_GET['publish'])){ echo "active"; } ?>" id="package_tab">
            <div class="icon">
              <img alt="" class="icon-active" src="<?= $site_url; ?>/assets/img/post-a-gig/packages-icon-red.png" />
              <img alt="" class="icon-inactive" src="<?= $site_url; ?>/assets/img/post-a-gig/packages-icon-gray.png" />
            </div>
            <div class="step">
              <span>2</span>
            </div>
            <div class="title">Packages</div>
          </div>
          <!-- Each item -->
          <div class="postgig-step-item <?= (isset($_GET['publish']) ? "active" : ""); ?>" id="gallery_tab">
            <div class="icon">
              <img alt="" class="icon-active" src="<?= $site_url; ?>/assets/img/post-a-gig/gallery-icon-red.png" />
              <img alt="" class="icon-inactive" src="<?= $site_url; ?>/assets/img/post-a-gig/gallery-icon-gray.png" />
            </div>
            <div class="step">
              <span>3</span>
            </div>
            <div class="title">Gallery</div>
          </div>
          <!-- Each item -->
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Post a gig overview step end -->

<!-- <nav id="tabs">

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

</nav> -->