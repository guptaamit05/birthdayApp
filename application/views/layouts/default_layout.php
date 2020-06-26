<?php header('Content-Type: text/html; charset=utf-8'); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

   <title>Birthday App </title>

    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/custom.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet" type="text/css">

    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrapp.js"></script>
</head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">

              <a href="#" class="site_title" ><b>Birthday App</b></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
                <img src="assets/image/img.jpg" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Welcome,</span>
                <h2><?php echo $this->session->userdata("user_name") ?></h2>
                
              </div>
              <div class="clearfix"></div>
            
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
                 	<?php if($this->session->userdata('activation') == 'not_active'){ }else{ $this->view('layouts/leftnav'); }?>            
            <!-- /sidebar menu -->

          </div>
        <!--</div>-->

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>         
    
              <ul class="nav navbar-nav navbar-right">                

                  <li role="presentation" class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                      <i class="fa fa-envelope-o"></i>
                      <span class="badge bg-green"></span>
                    </a>                

                         
                  </li>

  	              <li>
  						
        						<a href="<?php echo site_url('reset-password'); ?>"><i class="ace-icon fa fa-cog"></i>Settings</a>
        						
        					</li>
  					
        					<li>
        						<a href="<?php echo base_url();?>logout">	<i class="ace-icon fa fa-power-off"></i>Logout</a>
        					</li>
             </ul>
						
				    
            </nav>
          </div>
        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">          

              <div class="clearfix"></div>
                              
                 <div class="row top_tiles">
                    <!-- PAGE CONTENT BEGINS -->
          						<?php echo $contents;?>
          					<!-- PAGE CONTENT ENDS -->
              	</div>

          </div>
        </div>
        <!-- /page content -->

      
      </div> 
    </div>


 
  </body>
</html>

