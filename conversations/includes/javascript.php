<script type="text/javascript">
$(document).ready(function(){

var showMessages;
var typeStatus;

<?php if(isset($_GET["single_message_id"])){ ?>
  msgHeader(<?= $input->get("single_message_id"); ?>);
<?php } ?>

$(document).on('click', '.closeMsg', function(e){
  event.preventDefault();
  $(".specfic.col-md-3").show();
  $(".specfic.col-md-12").hide();
});

$('.closeMsg').on('click', function(){
  $(this).parents('.message-body').removeClass('active position-relative');
  $('.user-list-item').removeClass('active');
});
$('.user-list-item').on('click', function(){
  $('.user-list-item').removeClass('active');
  $(this).addClass('active');
  $('.message-body').addClass('active position-relative');
  $('.specfic.col-md-3').hide();
  $('.specfic.col-md-9,.specfic.col-md-12').show();
  $('.specfic.col-md-9').attr("class","specfic col-md-12");
  $('#msgSidebar').hide();
});

$(document).on('click', '.message-recipients', function(e){
  var message_group_id = $(this).data("id");
  addRemoveSelected(this);
  msgHeader(message_group_id);
});

function msgHeader(message_group_id){
  $("#wait").addClass("loader");
  $.ajax({
  method:'POST',
  url: "includes/msgHeader",
  data: {message_group_id:message_group_id},
  success: function(data){
    $("#msgHeader").html(data);
    showSingle(message_group_id);
  }
  });
}

function showSingle(message_group_id){
  $.ajax({
  method: "POST",
  url: "includes/showSingle",
  data: {message_group_id:message_group_id},
  success: function(server_response){
    $("#selectConversation").hide();
    $("#msgHeader").removeClass("d-none");
    $("#showSingle").html(server_response);
    $("#wait").removeClass("loader");
    if ( $(window).width() > 767) {
     // Add your javascript for large screens here 
    }else {
      // $('.specfic.col-md-3').show();
      // $('.specfic.col-md-9,.specfic.col-md-12').hide();
      // $('.specfic.col-md-9').attr("class","specfic col-md-12");
      // $('#msgSidebar').hide();
    }
  }
  });
}

$("#sub-category").hide();

$("#category").change(function(){
  $("#sub-category").show();  
  var category_id = $(this).val();
  $.ajax({
  url:"../fetch_subcategory",
  method:"POST",
  data:{category_id:category_id},
  success:function(data){
  $("#sub-category").html(data);
  }
  });
});
$('#file').change(function() {
  var i = $(this).prev('label').clone();
  var file = $('#file')[0].files[0].name;
  
  $('#file_name').html('<span>'+file+'</span>');
  // $(this).prev('label').text(file);
});
$('#file').bind('change', function() {
  var totalSize = this.files[0].size;
  var totalSizeMb = totalSize  / Math.pow(1024,2);

  $('.max-size').text(totalSizeMb.toFixed(2) + " MB");
});
$('.input-number').keyup(function(){
  var custom_btn = $('.input-number').val();
  $('#days30').val(custom_btn);
});
$(".input-number").keypress(function (e) {
  //if the letter is not digit then display error and don't type anything
  if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
    //display error message
    $("#errmsg").html("Digits Only").show().fadeOut("slow");
           return false;
  }
});

function addRemoveSelected(select){
  $(".col-md-3 .message-recipients").removeClass("selected");
  $(select).addClass("selected");
}

$('#all').click(function(){
  $(".inboxHeader .dropdown-toggle").html("All Conversations");
  $(".dropdown-menu a").attr('class','dropdown-item');
  $("#all").attr('class','dropdown-item active');
  $(".message-recipients").show();
  $(".unreadMsg").addClass("d-none");
  $(".archivedMsg").addClass("d-none");
  $(".starredMsg").addClass("d-none");
});
$('#unread').click(function(){
  $(".inboxHeader .dropdown-toggle").html("Unread");
  $(".dropdown-menu a").attr('class','dropdown-item');
  $("#unread").attr('class','dropdown-item active');
  $(".message-recipients").hide();
  $(".unread").show();
  $(".unreadMsg").removeClass("d-none");
  $(".archivedMsg").addClass("d-none");
  $(".starredMsg").addClass("d-none");
}); 
$('#starred').click(function(){
  $(".inboxHeader .dropdown-toggle").html("Starred");
  $(".dropdown-menu a").attr('class','dropdown-item');
  $("#starred").attr('class','dropdown-item active');
  $(".message-recipients").hide();
  $(".starred").show();
  $(".archivedMsg").addClass("d-none");
  $(".unreadMsg").addClass("d-none");
  $(".starredMsg").removeClass("d-none");
}); 
$('#archived').click(function(){
  $(".inboxHeader .dropdown-toggle").html("Unread");
  $(".dropdown-menu a").attr('class','dropdown-item');
  $("#archived").attr('class','dropdown-item active');
  $(".message-recipients").hide();
  $(".archived").show();
  $(".unreadMsg").addClass("d-none");
  $(".starredMsg").addClass("d-none");
  $(".archivedMsg").removeClass("d-none");
}); 
$('.search-icon').click(function(){
  $(".search-bar").removeClass("d-none");
  $(".inboxHeader .float-left").addClass("d-none");
  $(".inboxHeader .float-right").addClass("d-none");
});
$('.search-bar input').on('keyup', function() {
  var searchVal = $(this).val();
  var filterItems = $('[data-username]');
  if ( searchVal != '' ) {
    filterItems.addClass('d-none');
    $('[data-username*="' + searchVal.toLowerCase() + '"]').removeClass('d-none');
  } else {
    filterItems.removeClass('d-none');
  }
});
$('.search-bar a').click(function(){
  $(".search-bar").addClass("d-none");
  $(".search-bar input").val("");
  $(".float-left").removeClass("d-none");
  $(".float-right").removeClass("d-none");
  $('[data-username]').removeClass('d-none');
});

});
</script>