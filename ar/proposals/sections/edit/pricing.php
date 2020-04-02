<?php

@session_start();

if(isset($_POST['proposal_id'])){
  require_once("../../../includes/db.php");
  $proposal_id = $input->post('proposal_id');

  $edit_proposal = $db->select("proposals",array("proposal_id"=>$proposal_id));
  $row_proposal = $edit_proposal->fetch();
  $d_proposal_price = $row_proposal->proposal_price;
  $d_proposal_status = $row_proposal->proposal_status;
}

?>
<h5 class="font-weight-normal float-left" style="display: none;">Pricing</h5>
<div class="float-right switch-box" style="display: none;">
  <span class="text">Fixed Price :</span>
  <label class="switch">
    <?php if($d_proposal_price == "0" or isset($_POST["fixedPriceOff"])){ ?>
      <input type="checkbox" class="pricing">
    <?php }else if($d_proposal_price != "0" and !isset($_POST["fixedPriceOff"])){ ?>
      <input type="checkbox" class="pricing" checked="">
    <?php } ?>
    <span class="slider"></span>
  </label>
</div>

<div class="clearfix"></div>

<!-- <hr class="mt-0"> -->

<div class="form-group row proposal-price justify-content-center" style="display: none;">
<div class="col-md-7">
<div class="input-group">
<span class="input-group-addon font-weight-bold">
<?= $s_currency; ?>
</span>
<input type="number" class="form-control" form="pricing-form" name="proposal_price" min="0" value="<?= $d_proposal_price; ?>">
</div>
<small>If you want to use packages, you need to set this field value to 0. </small>
</div>
</div>

<div class="packages"><?php include("packages.php"); ?></div>

<!-- <div class="form-group row add-attribute justify-content-center">
  <div class="col-md-7">
    <div class="input-group">
      <input class="form-control form-control-sm attribute-name" placeholder="Add New Attribute" name="">
      <button class="btn btn btn-success input-group-addon insert-attribute" >
        <i class="fa fa-cloud-upload"></i> &nbsp;Insert 
      </button>
    </div>
  </div>
</div> -->

<div class="card rounded-0" style="display: none;">
  <div class="card-body bg-light pt-3 pb-0">
  <h6 class="font-weight-normal">My Proposal Extras</h6>
  <a data-toggle="collapse" href="#insert-extra" class="small text-success">+ Add Extra</a>
   <div class="tabs accordion mt-2" id="allTabs"><!--- All Tabs Starts --->
      <?php include("extras.php"); ?>
    </div><!--- All Tabs Ends --->
  </div>
</div>

<div class="form-group mt-4 mb-0" style="display: none;"><!--- form-group Starts --->
<a href="#" class="btn btn-secondary float-left back-to-overview">Back</a>
<input class="btn btn-success float-right" type="submit" form="pricing-form" value="Save & Continue">
</div><!--- form-group Starts --->

<script>
$(document).ready(function(){

<?php if($d_proposal_price == "0" or isset($_POST["fixedPriceOff"])){ ?>
  $('.proposal-price').hide();
<?php }else if($d_proposal_price != "0" and !isset($_POST["fixedPriceOff"])){ ?>
  $('.packages').show();
  $('.add-attribute').show();
<?php } ?>

$('.back-to-overview').click(function(){
  <?php if($d_proposal_status == "draft"){ ?>
    $("input[type='hidden'][name='section']").val("overview");
    $('#pricing').removeClass('show active');
    $('#overview').addClass('show active');
    $('#tabs a[href="#pricing"]').removeClass('active');
  <?php }else{ ?>
    $('.nav a[href="#overview"]').tab('show');
  <?php } ?>
});

$("table").on('click','.delete-attribute',function(event){
  $('#wait').addClass("loader");
  event.preventDefault();
  var attribute_name = $(this).data("attribute");
  var proposal_id = <?= $proposal_id; ?>;
  $(this).parent().parent().remove();
  $.ajax({
    method: "POST",
    url: "ajax/delete_attribute",
    data: { proposal_id : proposal_id, attribute_name: attribute_name },
    success:function(data){
      $('#wait').removeClass("loader");
    }
  });
});

$(".insert-attribute").on('click', function(event){
  $('#wait').addClass("loader");
  event.preventDefault();
  var attribute_name = $('.attribute-name').val();
  $.ajax({
  method: "POST",
  url: "ajax/insert_attribute",
  data: { attribute_name : attribute_name, proposal_id: <?= $proposal_id; ?> },
  success:function(data){
    if(data == "error"){
      $('#wait').removeClass("loader");
      swal({type: 'warning',text: 'You Must Need To Give A Name To Attribute Before Inserting It.'});
    }else{
      $('#wait').removeClass("loader");
      $('.attribute-name').val("");
      result = $.parseJSON(data);
      var form_data = new FormData(document.querySelector(".pricing-form"));
      form_data.append('proposal_id',<?= $proposal_id; ?>);
      $.ajax({
        method: "POST",
        url: "ajax/save_pricing",
        data: form_data,
        async: false,cache: false,contentType: false,processData: false
      }).done(function(data){
        // this code makes problem
        $.ajax({
          method: "POST",
          url: "sections/edit/pricing",
          data: { proposal_id: <?= $proposal_id; ?>,fixedPriceOff:1 },
          success:function(show_data){
            $("#pricing").html(show_data);
          }
        });
      });
    }
  }
  });

});

$(".pricing-form").submit(function(event){
  event.preventDefault();
  var form_data = new FormData(this);
  form_data.append('proposal_id',<?= $proposal_id; ?>);
  $('#wait').addClass("loader");
  $.ajax({
  method: "POST",
  url: "ajax/save_pricing",
  data: form_data,
  async: false,cache: false,contentType: false,processData: false
  }).done(function(data){
    $('#wait').removeClass("loader");
    if(data == "error"){
      swal({type: 'warning',text: 'You Must Need To Fill Out All Fields Before Updating The Details.'});
    }else{
      swal({
        type: 'success',
        text: 'Details Saved.',
        timer: 1000,
        onOpen: function(){
            swal.showLoading()
        }
      }).then(function(){
        $("input[type='hidden'][name='section']").val("gallery");
        <?php if($d_proposal_status == "draft"){ ?>
          $('#pricing').removeClass('show active');
          $('#gallery').addClass('show active');
          $('#gallery_tab').addClass('active');
        <?php }else{ ?> $('#gallery_tab').tab('show'); <?php } ?>
      });
    }
  });
});

});
</script>