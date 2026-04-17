<!DOCTYPE html>
<html>
  <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"><html xmlns="http://www.w3.org/1999/xhtml">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta charset="UTF-8">


<!-- JQuery engine script-->

<!-- JQuery WYSIWYG plugin script -->

<!-- JQuery tablesorter plugin script-->

<!-- JQuery pager plugin script for tablesorter tables -->
<title> Nashik Municipal Corporation </title>
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> -->

<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css" media="all">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/font-awesome.min.css" media="all">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/ionicons.min.css" media="all">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/AdminLTE.min.css" media="all">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
    folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/_all-skins.min.css" media="all">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css" media="all">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/datatables.min.css" media="all">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap-datepicker.min.css" media="all">
<script src="<?php echo base_url();?>assets/js/jquery.js"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/bootstrap-datepicker.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/sweetalert.min.js"></script>
    <!-- SlimScroll -->
    <script src="<?php echo base_url();?>assets/js/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="<?php echo base_url();?>assets/js/fastclick.js"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url();?>assets/js/adminlte.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/datatables.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script language="javascript" type="text/javascript" src="<?php echo base_url();?>assets/tinymce/tinymce.min.js"></script>
     <script src="<?php echo base_url();?>assets/javascript/ui/jquery.ui.core.js"></script>
  <script src="<?php echo base_url();?>assets/javascript/ui/jquery.ui.widget.js"></script>
  
  <script  src="<?php echo base_url();?>assets/javascript/jquery.corner.js"></script> 
    <script>
      $(document).ready(function(){
        $('.navbar .dropdown').mouseover(function(){
          $(this).find('.clsMainMenu').stop(true, false).slideDown(500);
        });
        $('.navbar .dropdown').mouseleave(function(){
          $(this).find('.clsMainMenu').stop(true, false).slideUp(200);
        });
        
      });
    </script>


<!-- DataTables JS -->
      
</head>
  <?php
    ini_set('display_errors', 1);
    $page = $this->uri->segment(2);
    $action = $this->uri->segment(3); 
    //echo "page=>".$page.", action=>".$action; exit;
    $this->load->helper("widgets"); 
    $menus = getMenuDetails();
    //log_message('menu',$menus);
    //echo '<pre>';print_r($menus);echo '</pre>';exit;
  ?>
  <!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
  <body class="hold-transition skin-blue layout-top-nav">
    <div class="wrapper">
      <header class="main-header">
        <section class="top-bar">
          <div class="col-xs-6 col-sm-6"><img src="<?php echo base_url('assets/images/logo.png');?>" class="img-responsive" /></div>
          
          
          <div class="navbar-custom-menu col-xs-4 col-sm-6 m-top">
            <ul class="nav navbar-nav pull-right">
                         <li class="dropdown user user-menu">
                <!-- Menu Toggle Button -->
                     <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <!-- The user image in the navbar-->
                       <img src="<?php echo base_url();?>assets/images/user2-160x160.jpg" class="user-image" alt="User Image">
                  <!-- hidden-xs hides the username on small devices so only the image appears. -->
                  <!-- <span><?php echo $_SESSION['logged_in']['name']; ?></span> -->
                       <span class="hidden-xs">&nbsp;</span>
                       </a>
                      <ul class="dropdown-menu">
                  <!-- The user image in the menu -->
                        <li class="user-header" style="color: rgba(28, 27, 27, 0.8);">
                         
                          
                          <p style="color: rgba(28, 27, 27, 0.8);;">
                           Welcome <?php echo $this->session->userdata('name'); ?>
                          </p>
                          <div class="pull-left" >
                              <a href="<?php echo base_url('admin/change-password');?>" class="btn btn-default btn-flat" style="color: rgba(28, 27, 27, 0.8);">Change Password</a>
                          </div>
                          <div class="pull-right" s>
                            <a href="<?php echo base_url('admin/login/logout')?>" class="btn btn-default btn-flat" style="color: rgba(28, 27, 27, 0.8);">Sign out</a>
                          </div>
                        </li>
                  
                  <!-- Menu Footer-->
                          
                </ul>
            </li>
                    </ul>
                  
                </div>
           
            
          
        </section>
        <nav class="navbar w3_megamenu" role="navigation">
          <div class="navbar-header">
            <button type="button" data-toggle="collapse" data-target="#defaultmenu" class="navbar-toggle"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
          </div><!-- end navbar-header -->
          <?php //echo "<pre>"; print_r($menus); exit;?>
          <div id="defaultmenu" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              
              <li><a href="#">Home</a></li> 
              <!-- Mega Menu -->
              
              <?php /*
                foreach($menus as $cName => $aDetails){
                  //echo "<pre>"; print_r($aDetails[0]->order_no); exit;
                  if($cName == "More Link"){
                  ?>
                  <li class="dropdown w3_megamenu-fw"><a href="#" data-toggle="dropdown" class="dropdown-toggle"><?=$cName;?> <b class="caret"></b></a>
                    <ul class="dropdown-menu fullwidth clsMainMenu">
                      <li class="w3_megamenu-content withoutdesc">
                        <div class="row">
                          <?php 
                            
                                foreach($aDetails as $controllerName => $actionDetails){ 
                            ?>
                            
                            <div class="col-sm-3">
                              <h3 class="title"><?=$controllerName;?></h3>
                              <ul class="">
                                <?php 
                                  $megaMenuCnt =0;
                                  foreach($actionDetails as $aDetail){ 
                                  ?>
                                  <li><a href="<?=base_url('admin/'.$aDetail->aRouteUrl);?>"><?=$aDetail->action_value;?></a></li>
                                  <?php 
                                    $megaMenuCnt++;
                                  } 
                                ?>
                              </ul>
                            </div>
                            
                          <?php } ?>  
                        </div>
                      </li>
                    </ul>
                  </li>
                  <?php
                  }
                  else{
                    if(count($aDetails) > 1){
                      if($cName == "Report1" || $cName == "MIS Report"){
                        ?>
                        <li class="dropdown w3_megamenu-fw"><a href="#" data-toggle="dropdown" class="dropdown-toggle"><?=$cName;?> <b class="caret"></b></a>
                          <ul class="dropdown-menu clsMainMenu">
                        <li class="w3_megamenu-content withoutdesc">
                          <div class="row">
                            <div class="col-sm-12"><h3 class="title"><?=$cName;?></h3></div>
                            <div class="col-sm-3">
                              <ul class="">
                                <?php 
                                  $megaMenuCnt =0;
                                  foreach($aDetails as $aDetail){ 
                                    if($megaMenuCnt % 7 == 0 && $megaMenuCnt > 0){
                                      echo "</ul></div><div class='col-sm-3'><ul class=''>";
                                    }
                                  ?>
                                  <li><a href="<?=base_url('admin/'.$aDetail->aRouteUrl);?>"><?=$aDetail->action_value;?></a></li>
                                  <?php 
                                    $megaMenuCnt++;
                                  } 
                                ?>
                              </ul>
                            </div>
                          </div>
                        </li>
                      </ul>
                      </li>
                      <?php
                      }
                      else{
                      ?>
                      <li class="dropdown"><a href="#" data-toggle="dropdown" class="dropdown-toggle"><?=$cName;?> <b class="caret"></b></a>
                        <ul class="dropdown-menu clsMainMenu">
                          <?php //echo "<pre>";print_r($aDetails);die; 
                          foreach($aDetails as $aDetail){ ?>
                            <li><a href="<?=base_url('admin/'.$aDetail->aRouteUrl);?>"><?=$aDetail->action_value;?></a></li>
                          <?php } ?>
                        </ul>
                      </li>
                      <?php
                      }
                    }
                    else{
                    ?>
                    <li><a href="<?=base_url('admin/'.$aDetails[0]->aRouteUrl);?>"><?=$aDetails[0]->controller_value;?></a></li>
                    <?php
                    }
                  }
                } */
              ?>
                
               <?php
                 $username = $this->session->userdata('username');
                 if (strtolower(trim($username)) === 'admin' || strtolower(trim($username)) === 'team1') {
               ?>
               <li><a href="<?=base_url();?>/admin/misreport/ledger_report_new">Ledger Report</a></li>
               <?php } ?>
               <!--<li><a href="<?=base_url();?>/admin/misreport/broad_sheet_report">Borad Sheet Report</a></li>-->
               <li><a href="<?=base_url();?>/admin/monthly-record">Edit Month Wise Deduction Record</a></li>
               <li><a href="<?=base_url('admin/edit-missing-month-year-records')?>">Pending Month & Year Records</a></li>
               <li><a href="<?=base_url();?>/admin/misreport/deduction_report">Deduction Report</a></li>
               <li><a href="<?=base_url();?>/admin/dcps-deduction-record">Edit Employee Wise Deduction Record</a></li>
               
               <li><a href="<?=base_url();?>/admin/add-edit-master-record">Add Master</a></li>
               
               <li class="dropdown"><a href="#" data-toggle="dropdown" class="dropdown-toggle">Team tasks <b class="caret"></b></a>
                 <ul class="dropdown-menu">
                   <li><a href="<?=base_url('admin/team-wise-tasks/team/1')?>">Team 1</a></li>
                   <li><a href="<?=base_url('admin/team-wise-tasks/team/2')?>">Team 2</a></li>
                   <li><a href="<?=base_url('admin/team-wise-tasks/team/3')?>">Team 3</a></li>
                   <li><a href="<?=base_url('admin/team-wise-tasks/team/4')?>">Team 4</a></li>
                   <li><a href="<?=base_url('admin/team-wise-tasks/team/5')?>">Team 5</a></li>
                   <li><a href="<?=base_url('admin/team-wise-tasks/team/6')?>">Team 6</a></li>
                   <li><a href="<?=base_url('admin/team-wise-tasks/team/7')?>">Team 7</a></li>
                   <li><a href="<?=base_url('admin/team-wise-tasks/team/8')?>">Team 8</a></li>
                   <li><a href="<?=base_url('admin/team-wise-tasks/team/9')?>">Team 9</a></li>
                   <li><a href="<?=base_url('admin/team-wise-tasks/team/10')?>">Team 10</a></li>
                   <li><a href="<?=base_url('admin/team-wise-tasks/team/11')?>">Team 11</a></li>
                   <li><a href="<?=base_url('admin/team-wise-tasks/team/12')?>">Team 12</a></li>
                 </ul>
               </li>
               
            </ul><!-- end nav navbar-nav -->
            
            <!-- end nav navbar-nav navbar-right -->
          </div><!-- end #navbar-collapse-1 -->
          
        </nav><!-- end navbar navbar-default w3_megamenu -->
      </header>                                                                                               
