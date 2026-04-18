<style type="text/css">
    .spaceTot label.form-label {
    display: none;
    }
    .spaceArr label.form-label {
    display: none;
    }
    .spaceCurr label.form-label {
    display: none;
    }
    
    .form-error p {
    color: #ff8080;
    font-size: 12px;
    }
    label.form-label{
     display: table-cell;   
    float:left;
    width: 246px;
    
    }
    .container {
    display: table;
    width: 100%
}
    .controls {
    display: table-cell;
    overflow: hidden;
    padding: 0 4px 0 6px
}
input {
    width: 100%;
}



</style>
<div class="content-wrapper" style="min-height: 970.3px; height: auto !important;">
    <section class="content-header">
        <h1>Change Password</h1>
        <!-- <ol class="breadcrumb">
            <li><a href="<?=base_url('admin/index')?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            
            <li class="active">Change Password</li>
        </ol> -->
    </section>

    <?php if(validation_errors()){?>
                <!-- Alert message -->
                  <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo validation_errors();?>
                  </div>
                <!--/ Alert message -->
              <?php }?>  
<section class="content" style="height: auto !important; min-height: 0px !important;">
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Change Password</h3>
                    </div>
                    
                    <?php if($this->session->flashdata('success')):?>
                    <div class="alert alert-success alert-dismissible fade in">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>
                        <strong>Success: </strong><?=$this->session->flashdata('success');?>
                    </div>
                    <?php endif; 
                    if($this->session->flashdata('error')):?>
                    <div class="alert alert-danger alert-dismissible fade in">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>
                        <strong>Error: </strong><?=$this->session->flashdata('error');?>
                    </div>
                    <?php endif; ?>
                    <?php if(isset($update_msg)): ?>
                <div class="alert alert-success" style="background-color: #eee1d1;margin-top:10px;">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                   <?php echo $update_msg;?>
                     </div>
                 <?php endif; ?> 
                    <div class="box-body">
        <form action="" method="post" name="typicaltypes" id="typicaltypes" enctype="multipart/form-data" novalidate="novalidate">

                            <div class="container">
                                <div class="form-group">
                                <label for="title" class="form-label">New Password</label>
                           <div class="controls">
                                <input type="password" name="password" id="password" value="" class="form-control" size="54" placeholder="New Password">
                            </div>
                        </div>
                            </div>
                           <div class="container">
                                <div class="form-group">
                                <label for="title" class="form-label">Confirm Password</label>
                                 <div class="controls">
                                <input type="password" name="cfmpassword" id="cfmpassword" value="" class="form-control" size="54" placeholder="Confirm Password">

                                <div class="registrationFormAlert" id="divCheckPasswordMatch">
                                </div>
                        </div>
                            </div>
                             <div class="" style="float: right;">
                                         
                                <input type="submit" class="btn btn-primary" value="Submit">
                                
                                <!-- <a href="<?=base_url($routeUrl)?>" class="btn btn-primary"><i class="fa fa-arrow-circle-left"></i> Back</a> -->
                            </div>
             </form>
         </div>
     </div>
 </div>
</div>
</section>
</div>

</div>
<script type="text/javascript">
    function checkPasswordMatch() {
    var password = $("#password").val();
    var confirmPassword = $("#cfmpassword").val();

    if (password != confirmPassword)
        $("#divCheckPasswordMatch").html("Passwords do not match!");
    //alert("Passwords do not match!");
    else
        $("#divCheckPasswordMatch").html("Passwords match.");
    //alert("Passwords match!");
}

$(document).ready(function () {
   $("#password, #cfmpassword").keyup(checkPasswordMatch);
});
</script>