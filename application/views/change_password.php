<div class="main-content">
	<div class="main-content-inner">
		<div class="page-header">
			<h1>
				Update Password
			</h1>
		</div><!-- /.page-header -->
		
		<?php if ($this->session->flashdata('category_success')) { ?>

		<div class="alert alert-success"> <?= $this->session->flashdata('category_success') ?> </div>

		<?php } ?>

		<?php if ($this->session->flashdata('category_error')) { ?>

		<div class="alert alert-danger"> <?= $this->session->flashdata('category_error') ?> </div>

		<?php } ?>	
        <div class="box-all">

       			
			<?php echo form_open('reset-password','class= "form-horizontal" role="form"');?>
			<div class="row mrgin">
				<div class="col-sm-12 col-md-6">
	                <div class="form-group">
						<label class="col-sm-4 control-label no-padding-right" for="form-field-1"> <?php echo $this->lang->line('Username'); ?>User Name </label>						

						<div class="col-sm-8">
							<input type="text" name="" id="form-field-1" value="<?= $this->session->userdata('user_name') ?>" placeholder="UserName" class="form-control" readonly>
						</div>
					</div>	
				</div>
				<br> 
			</div>
			<div class="row mrgin">
	            <div class="col-sm-12 col-md-6">								
					<div class="form-group "> 
	       <label class="col-sm-4 control-label no-padding-right" for="form-field-1"> Old Password </label>
	         <div class="col-sm-8">

					<input type="password" name="old_password" value="<?php if(($this->input->post('old_password'))) { echo $this->input->post('old_password'); } ?>" class="form-control" autocomplete="new-password">
							<!-- <div class="col-sm-3"> -->
					<?php echo form_error('old_password'); ?>
					<span class="error-message error-old_password"></span> 
							  <!-- </div> -->
			  </div> <br>   
					
					</div>
	            </div>
	        </div>
	            
	            
			<div class="row mrgin">
				<div class="col-sm-12 col-md-6">	
					<div class="form-group form-area clearfix">
						<label class="col-sm-4 control-label no-padding-right no-left" for="form-field-1"> New Password</label>

						<div class="col-sm-8">
							<input type="password" name="UserPass"  class="form-control" value="<?php if(($this->input->post('UserPass'))) { echo $this->input->post('UserPass'); } ?>" />
	                        <?php echo form_error('UserPass'); ?>	
	                        <span class="error-message error-UserPass"></span> 										
						</div>
					</div>
				</div>
	        </div>
	    </div>
		<div class="clearfix form-actions btn-area">

			<input type="submit" class="btn-sm btn-primary submit-sm" name="submit" id="submit"  value="Submit" >
              
		</div>
	<?php echo form_close();?>
		
<!-- ========================================================================			 -->
		
<script src="assets/js/common_validations.js"></script>


<script>
  

   field = {

    UserPass: {
      name: 'UserPass',
      title: "New Password",

      validations: {
        required: true,
        
      },
     
    },

    old_password: {
      name: 'old_password',
      title: "Old Password",
      validations: {
        required: true,
      },
    },
   
  };
  

  $('[name="UserPass"]').on('keyup blur', function(evt) {
    validate([field.UserPass]);
  });
    
  $('[name="old_password"]').on('keyup blur', function(evt) {
      validate([field.old_password]);
  });



// validating each field seperately
$('#submit').on('click', function(e) {

  checkValidation = validate(field);
  if(!checkValidation) {
    e.preventDefault();      
  }
});


</script>														
																