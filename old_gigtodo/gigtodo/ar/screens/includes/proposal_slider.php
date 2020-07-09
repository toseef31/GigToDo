<div id="gigsSingleCarousel" class="carousel slide" data-ride="carousel">
  <div class="carousel-inner">
  	<?php if(!empty($proposal_video)){ ?>
  	<div class="carousel-item active">
  		<?php if($proposal_video_type == "uploaded"){ ?>
  			<?php if(!empty($jwplayer_code)){ ?>
  			<script type="text/javascript" src="<?php echo $jwplayer_code; ?>"></script>
  			<div class="d-block w-100" id="player"></div>
  			<script type="text/javascript">
  				var player = jwplayer('player');
  				player.setup({
  					file: "<?php echo $show_video; ?>",
  					image: "<?php echo $show_img1; ?>"
  				});
  			</script>
  			<?php }else{ ?>
  			<video class="embed-responsive embed-responsive-16by9"  style="background-color:black;" controls>
  				<source class="embed-responsive-item" src="<?php echo $show_video; ?>" type="video/mp4">
  				<source src="<?php echo $show_video; ?>" type="video/ogg">
  			</video>
  			<?php } ?>
  		<?php }elseif($proposal_video_type == "embedded"){ ?>
  		<div class="embed-responsive embed-responsive-16by9">
  		  <?= $proposal_video; ?>
  		</div>
  		<?php } ?>
  	</div>
  	<?php } ?>
  	<div class="carousel-item <?php if(empty($proposal_video)){ echo "active"; }?>">
  		<img class="img-fluid d-block w-100" src="<?= $site_url; ?>/proposals/<?php echo $show_img1; ?>">
  	</div>
  	<?php if(!empty($proposal_img2)){ ?>
  	<div class="carousel-item">
  		<img class="img-fluid d-block w-100" src="<?= $site_url; ?>/proposals/<?php echo $show_img2; ?>">
  	</div>
  	<?php } ?>
  	<?php if(!empty($proposal_img3)){ ?>
  	<div class="carousel-item"><!-- carousel-item Starts -->
  		<img class="img-fluid d-block w-100" src="<?= $site_url; ?>/proposals/<?php echo $show_img3; ?>">
  	</div><!-- carousel-item Ends -->
  	<?php } ?>
  	<?php if(!empty($proposal_img4)){ ?>
  	<div class="carousel-item"><!-- carousel-item Starts -->
  		<img class="img-fluid d-block w-100" src="<?= $site_url; ?>/proposals/<?php echo $show_img4; ?>">
  	</div><!-- carousel-item Ends -->
  	<?php } ?>
  </div>
  <a class="carousel-control-prev" href="#gigsSingleCarousel" role="button" data-slide="prev">
    <i class="fal fa-angle-left"></i>
  </a>
  <a class="carousel-control-next" href="#gigsSingleCarousel" role="button" data-slide="next">
    <i class="fal fa-angle-right"></i>
  </a>
</div>
<div class="owl-carousel owl-theme">
	
  <div class="item" data-target="#gigsSingleCarousel" data-slide-to="0">
    <img class="img-fluid d-block" src="<?= $site_url; ?>/proposals/<?php echo $show_img1; ?>" width="100%" />
  </div>
  <?php if(!empty($proposal_img2)){ ?>
  <div class="item" data-target="#gigsSingleCarousel" data-slide-to="1">
    <img class="img-fluid d-block" src="<?= $site_url; ?>/proposals/<?php echo $show_img2; ?>" width="100%" />
  </div>
	<?php } ?>
	<?php if(!empty($proposal_img3)){ ?>
  <div class="item" data-target="#gigsSingleCarousel" data-slide-to="2">
    <img class="img-fluid d-block" src="<?= $site_url; ?>/proposals/<?php echo $show_img3; ?>" width="100%" />
  </div>
	<?php } ?>
	<?php if(!empty($proposal_img4)){ ?>
  <div class="item" data-target="#gigsSingleCarousel" data-slide-to="3">
    <img class="img-fluid d-block" src="<?= $site_url; ?>/proposals/<?php echo $show_img4; ?>" width="100%" />
  </div>
	<?php } ?>
</div>

<!-- <div id="myCarousel" class="carousel slide">
  <ol class="carousel-indicators">
		<?php if(!empty($proposal_video)){ ?>
		<li data-target="#myCarousel" data-slide-to="0"  class="active"></li>
		<?php } ?>
		<li data-target="#myCarousel" data-slide-to="1" <?php if(empty($proposal_video)){ echo "class='active'"; } ?>></li>
		<?php if(!empty($proposal_img2)){ ?>
		<li data-target="#myCarousel" data-slide-to="2"></li>
		<?php } ?>
		<?php if(!empty($proposal_img3)){ ?>
		<li data-target="#myCarousel" data-slide-to="3"></li>
		<?php } ?>
		<?php if(!empty($proposal_img4)){ ?>
		<li data-target="#myCarousel" data-slide-to="4"></li>
		<?php } ?>
	</ol>
	<div class="carousel-inner">
		<?php if(!empty($proposal_video)){ ?>
		<div class="carousel-item active">
			<?php if($proposal_video_type == "uploaded"){ ?>
				<?php if(!empty($jwplayer_code)){ ?>
				<script type="text/javascript" src="<?php echo $jwplayer_code; ?>"></script>
				<div class="d-block w-100" id="player"></div>
				<script type="text/javascript">
					var player = jwplayer('player');
					player.setup({
						file: "<?php echo $show_video; ?>",
						image: "<?php echo $show_img1; ?>"
					});
				</script>
				<?php }else{ ?>
				<video class="embed-responsive embed-responsive-16by9"  style="background-color:black;" controls>
					<source class="embed-responsive-item" src="<?php echo $show_video; ?>" type="video/mp4">
					<source src="<?php echo $show_video; ?>" type="video/ogg">
				</video>
				<?php } ?>
			<?php }elseif($proposal_video_type == "embedded"){ ?>
			<div class="embed-responsive embed-responsive-16by9">
			  <?= $proposal_video; ?>
			</div>
			<?php } ?>
		</div>
		<?php } ?>
		<div class="carousel-item <?php if(empty($proposal_video)){ echo "active"; }?>">
			<img class="d-block w-100" src="<?php echo $show_img1; ?>">
		</div>
		<?php if(!empty($proposal_img2)){ ?>
		<div class="carousel-item">
			<img class="d-block w-100" src="<?php echo $show_img2; ?>">
		</div>
		<?php } ?>
		<?php if(!empty($proposal_img3)){ ?>
		<div class="carousel-item"> -->
			<!-- carousel-item Starts -->
			<!-- <img class="d-block w-100" src="<?php echo $show_img3; ?>">
		</div> -->
		<!-- carousel-item Ends -->
		<!-- <?php } ?>
		<?php if(!empty($proposal_img4)){ ?>
		<div class="carousel-item"> -->
			<!-- carousel-item Starts -->
			<!-- <img class="d-block w-100" src="<?php echo $show_img4; ?>">
		</div> -->
		<!-- carousel-item Ends -->
		<!-- <?php } ?>
	</div>
	<a class="carousel-control-prev slide-nav slide-right" href="#myCarousel" data-slide="prev"> -->
		<!--<span class="carousel-control-prev-icon carousel-icon"></span>-->
		<!-- <img src="../../images/left-arrow.png">
	</a>
	<a class="carousel-control-next slide-nav slide-left" href="#myCarousel" data-slide="next"> -->
		<!--<span class="carousel-control-next-icon carousel-icon"></span>-->
		<!-- <img src="../../images/right-arrow.png">
	</a>
</div> -->