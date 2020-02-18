<nav id="tabs">

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

</nav>