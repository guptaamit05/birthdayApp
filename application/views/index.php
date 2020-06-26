

  <section class="login_content">

        <?php if ($this->session->flashdata('category_success')) { ?>
            <div class="alert alert-success"> <?= $this->session->flashdata('category_success') ?> </div>
        <?php } ?>
        <?php if ($this->session->flashdata('category_error')) { ?>
            <div class="alert alert-danger"> <?= $this->session->flashdata('category_error') ?> </div>
        <?php } ?> 
          

       <?php echo form_open('login', "class='form-horizontal'"); ?>
          <h1>Login </h1>
          <div>

            <input type="text" tabindex="1" class="form-control" autocomplete="off"  value="<?= set_value("username"); ?>" name="username" placeholder="Username"  />

          </div>
           <span class="error-message error-username"></span> 
           <span style="color: red;"><?php echo form_error('username'); ?></span>
       

          <div>
            <input type="password" tabindex="2" class="form-control" value="<?= set_value("password"); ?>"  autocomplete="off"  name="password" placeholder="Password"  />
          </div>
           <span class="error-message error-password"></span> 
           <span style="color: red;"><?php echo form_error('password'); ?></span>
        

          <div>

            <button name="submit" tabindex="3" value="submit" id="submit" class="btn btn-primary submit" >LOGIN</button>

            <p class="ptag">
             <a class="forgot_pwd" href="<?= base_url("forgot-password"); ?>">Forgot Password</a>
            </p>
            

             <p class="ptag">
             <b>Not Register yet? </b> <a class="forgot_pwd" href="<?= base_url("register-user"); ?>"> SignUp</a>
            </p>
          </div>
       <?php echo form_close(); ?>
 </section>         

<script src="assets/js/jquery.min.js" type="text/javascript"></script>
<script src="assets/js/common_validations.js"></script>

<script>

   var timeout = 3000; // in miliseconds (3*1000)
    $('.alert').delay(timeout).fadeOut(300);

   field = {

    username: {
      name: 'username',
      title: "Username",
      validations: {
        required: true,
      },
    },

    password: {
      name: 'password',
      title: "Password",
      validations: {
        required: true,
      },
    },
   
  };
  

  $('[name="username"]').on('keyup blur', function(evt) {
    validate([field.username]);
  });
    
  $('[name="password"]').on('keyup blur', function(evt) {
      validate([field.password]);
  });



// validating each field seperately
$('#submit').on('click', function(e) {

  checkValidation = validate(field);
  if(!checkValidation) {
    e.preventDefault();      
  }
});


</script>