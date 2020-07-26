<?php
@session_start();
if(!isset($_SESSION['admin_email'])){
echo "<script>window.open('login','_self');</script>";
}else{
?>
<div class="breadcrumbs">
  <div class="col-sm-4">
    <div class="page-header float-left">
      <div class="page-title">
        <h1><i class="menu-icon fa fa-book"></i> View Testimonials</h1>
      </div>
    </div>
  </div>
  <div class="col-sm-8">
    <div class="page-header float-right">
      <div class="page-title">
        <ol class="breadcrumb text-right">
          <li class="active"><a href="index?insert_testimonials" class="btn btn-success">
            <i class="fa fa-plus-circle text-white"></i> <span class="text-white">Add New Testimonial</span>
          </a></li>
        </ol>
      </div>
    </div>
  </div>
</div>
<div class="container">
  <div class="row">
    <!--- 2 row Starts --->
    <div class="col-lg-12">
      <!--- col-lg-12 Starts --->
      <div class="card">
        <!--- card Starts --->
        <div class="card-header">
          <!--- card-header Starts --->
          <h4 class="h4">
          All Testimonials
          </h4>
        </div>
        <!--- card-header Ends --->
        <div class="card-body">
          <!---  card-body Starts --->
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Name</th>
                <th>Designation</th>
                <th>Image</th>
                <th>Testimonial's Action</th>
              </tr>
            </thead>
            <tbody>
              
              <?php
              
              $get_testimonials = $db->select("testimonials");
              while($row_testimonials = $get_testimonials->fetch()){
              $testimonial_id = $row_testimonials->testimonial_id;
              
              $name = $row_testimonials->name;
              $designation = $row_testimonials->designation;
              $image = $row_testimonials->image;
              ?>
              
              <tr>
                
                <td><?php echo $name; ?></td>
                <td><?php echo $designation; ?></td>
                <td><?php echo $image; ?></td>
                <td>
                  <a href="index?edit_testimonial=<?php echo $testimonial_id; ?>" class="text-success">
                    Edit
                  </a> |
                  <a href="index?delete_testimonial=<?php echo $testimonial_id; ?>" class="text-success">
                    Delete
                  </a>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
        <!--- card-body Ends --->
      </div>
      <!--- card Ends --->
    </div>
    <!--- col-lg-12 Ends --->
  </div>
  <!--- 2 row Ends --->
</div>
<?php } ?>