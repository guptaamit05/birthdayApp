

  <section class="login_content">

        <?php if ($this->session->flashdata('category_success')) { ?>
            <div class="alert alert-danger"> <?= $this->session->flashdata('category_success') ?> </div>
        <?php } ?>
        <?php if ($this->session->flashdata('category_error')) { ?>
            <div class="alert alert-danger"> <?= $this->session->flashdata('category_error') ?> </div>
        <?php } ?> 
          

       <?php echo form_open('forgot-password', "class='form-horizontal'"); ?>
          <h1>Forgot Password </h1>

          <div>
            <input type="text" tabindex="1" class="form-control" value="<?= set_value("email"); ?>" autocomplete="off"  name="email" placeholder="Email"  />
          </div>
           <span class="error-message error-email"></span> 
           <span style="color: red;"><?php echo form_error('email'); ?></span>
        

          <div>
            <button name="submit" tabindex="3" value="submit" id="submit" class="btn btn-primary submit" >SUBMIT</button>

            <p class="ptag">
             <a class="forgot_pwd" href="<?= base_url("login"); ?>">Login</a>
            </p>

          </div>

       <?php echo form_close(); ?>
 </section>         

<script src="assets/js/jquery.min.js" type="text/javascript"></script>
<script src="assets/js/common_validations.js"></script>

<script>

   var timeout = 5000; // in miliseconds (3*1000)
    $('.alert').delay(timeout).fadeOut(500);

   field = {

    email: {
      name: 'email',
      title: "Email",
      validations: {
        required: true,
        email: true,
      },
    },

   
  };
  

  $('[name="email"]').on('keyup blur', function(evt) {
    validate([field.email]);
  });
    
 
// validating each field seperately
$('#submit').on('click', function(e) {

  checkValidation = validate(field);
  if(!checkValidation) {
    e.preventDefault();      
  }
});


</script>