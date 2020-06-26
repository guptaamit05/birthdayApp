

  <section class="login_content" style="padding-top: 40px;">

        <?php if ($this->session->flashdata('category_success')) { ?>
            <div class="alert alert-success"> <?= $this->session->flashdata('category_success') ?> </div>
        <?php } ?>
        <?php if ($this->session->flashdata('category_error')) { ?>
            <div class="alert alert-danger"> <?= $this->session->flashdata('category_error') ?> </div>
        <?php } ?> 
        


       <?php echo form_open('register-user', "class='form-horizontal'"); ?>
          <h1>SIGN UP </h1>

           <div>
            <input type="text" tabindex="1" class="form-control" autocomplete="off"  value="<?= set_value("first_name"); ?>" name="first_name" placeholder="First Name"  />
          </div>
           <span class="error-message error-first_name"></span> 
           <span class="alert1" style="color: red;"><?php echo form_error('first_name'); ?></span>



           <div>
            <input type="text" tabindex="2" class="form-control" autocomplete="off"  value="<?= set_value("last_name"); ?>" name="last_name" placeholder="Last Name"  />
          </div>
           <span class="error-message error-last_name"></span> 
           <span class="alert1" style="color: red;"><?php echo form_error('last_name'); ?></span>


           <div>
            <input type="text" tabindex="3" class="form-control Date1" value="<?= set_value("dob"); ?>"  autocomplete="off"  name="dob" placeholder="DOB"  />
          </div>
           <span class="error-message error-dob"></span> 
           <span class="alert1" style="color: red;"><?php echo form_error('dob'); ?></span>



           <div>
            <input type="text" tabindex="3" class="form-control" value="<?= set_value("email"); ?>"  autocomplete="off"  name="email" placeholder="Email"  />
          </div>
           <span class="error-message error-email"></span> 
           <span class="alert1" style="color: red;"><?php echo form_error('email'); ?></span>




          <div>
            <input type="text" tabindex="4" class="form-control" autocomplete="off"  value="<?= set_value("username"); ?>" name="username" placeholder="Username"  />
          </div>
           <span class="error-message error-username"></span> 
           <span class="alert1" style="color: red;"><?php echo form_error('username'); ?></span>


          <div>
            <input type="password" tabindex="5" class="form-control" value="<?= set_value("password"); ?>"  autocomplete="off"  name="password" placeholder="Password"  />
          </div>
           <span class="error-message error-password"></span> 
           <span class="alert1" style="color: red;"><?php echo form_error('password'); ?></span>
          
          

          <div>

            <button name="submit" tabindex="6" value="submit" id="submit" class="btn btn-primary submit" >SIGN UP</button>

            <p class="ptag">
             <a class="forgot_pwd" tabindex="7"  href="<?= base_url("login"); ?>">Login</a>
            </p>
          
          </div>
       <?php echo form_close(); ?>
 </section>         

<script src="assets/js/jquery.min.js" type="text/javascript"></script>

  <script src="assets/js/date_js_picker.js"></script>
  <link href="assets/css/date_css_picker.css" rel="stylesheet">

<script src="assets/js/common_validations.js"></script>


<script>

   var timeout = 5000; // in miliseconds (3*1000)
    $('.alert').delay(timeout).fadeOut(500);
    $('.alert1').delay(timeout).fadeOut(500);

   field = {

    dob: {
      name: 'dob',
      title: "DOB",
      validations: {
        required: true,
      },
    },
    first_name: {
      name: 'first_name',
      title: "First Name",
      validations: {
        required: true,
      },
    },

    email: {
      name: 'email',
      title: "Email",
      validations: {
        required: true,
        email: true,
      },
    },

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
  

  $('[name="first_name"]').on('keyup blur', function(evt) {
    validate([field.first_name]);
  });

  $('[name="dob"]').on('keyup change blur', function(evt) {
    validate([field.dob]);
  });

  $('[name="email"]').on('keyup blur', function(evt) {
    validate([field.email]);
  });

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


 $(".Date1").datepicker({
      endDate: "today",
      autoclose: true,
      format: 'yyyy-mm-dd'
    });


</script>