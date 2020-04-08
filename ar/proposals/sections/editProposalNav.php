<!-- Post a gig overview step -->
		<section class="container-fluid postgig-step">
			<div class="row">
				<div class="container">
					<div class="postgig-step-container">
						<div class="postgig-step-wrapper d-flex flex-row justify-content-between">
							<div class="postgig-step-item active <?php if(!isset($_GET['video']) AND !isset($_GET['pricing']) and !isset($_GET['publish'])){ echo " show active"; } ?>" id="overview_tab">
								<div class="icon">
									<img alt="" class="icon-active" src="assets/img/post-a-gig/overview-icon-red.png" />
									<img alt="" class="icon-inactive" src="assets/img/post-a-gig/overview-icon-gray.png" />
								</div>
								<div class="step">
									<span>1</span>
								</div>
								<div class="title">
									نظرة عامة
								</div>
							</div>
							<!-- Each item -->
							<div class="postgig-step-item <?php if(isset($_GET['pricing']) or isset($_GET['publish'])){ echo "active"; } ?>" id="package_tab">
								<div class="icon">
									<img alt="" class="icon-active" src="assets/img/post-a-gig/packages-icon-red.png" />
									<img alt="" class="icon-inactive" src="assets/img/post-a-gig/packages-icon-gray.png" />
								</div>
								<div class="step">
									<span>2</span>
								</div>
								<div class="title">
									باقات الأسعار
								</div>
							</div>
							<!-- Each item -->
							<div class="postgig-step-item <?= (isset($_GET['publish']) ? "active" : ""); ?>" id="gallery_tab">
								<div class="icon">
									<img alt="" class="icon-active" src="assets/img/post-a-gig/gallery-icon-red.png" />
									<img alt="" class="icon-inactive" src="assets/img/post-a-gig/gallery-icon-gray.png" />
								</div>
								<div class="step">
									<span>3</span>
								</div>
								<div class="title">
									الاستوديو
								</div>
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

		<ul class="nav nav-tabs" id="nav-tab" role="tablist">

			<li class="nav-item">
				<a class="nav-link <?php if(!isset($_GET['pricing']) AND !isset($_GET['video'])){ echo "active"; } ?>" id="nav-home-tab" data-toggle="tab" href="#overview">Overview</a>
			</li>

			<li class="nav-item">
				<a class="nav-link <?php if($checkVideo==false){echo"d-none";} ?> <?= (isset($_GET['video']) ? "active" : ""); ?>" id="nav-home-tab" data-toggle="tab" href="#video">Video Settings</a>
			</li>

			<li class="nav-item">
				<a class="nav-link <?php if(isset($checkVideo) and $checkVideo==true){echo"d-none";} ?> <?= (isset($_GET['pricing']) ? "active" : ""); ?>" id="nav-home-tab" data-toggle="tab" href="#pricing">Pricing</a>
			</li>

			<li class="nav-item">
				<a class="nav-link" id="nav-home-tab" data-toggle="tab" href="#description">Description & FAQ</a>
			</li>

			<li class="nav-item">
				<a class="nav-link" id="nav-home-tab" data-toggle="tab" href="#requirements">Requirements</a>
			</li>

			<li class="nav-item">
				<a class="nav-link" id="nav-home-tab" data-toggle="tab" href="#gallery">Gallery</a>
			</li>

		</ul>

	</div>

</nav> -->