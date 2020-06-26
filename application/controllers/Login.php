<?php

defined('BASEPATH') or exit('No direct script access allowed');

// FILE TO PERFORM THE SEND MAIL OPERATION
require APPPATH . 'third_party/PHPMailer/PHPMailerAutoload.php';


// CLASS:  LOGIN
class Login extends CI_Controller 
{

    // CONSTRUCTOR DEFINATION
    public function __construct()
    {

        parent::__construct();

        // load session library
        $this->load->library("session");

        // IF USER IS ALREADY LOGIN THAN REDIRECT TO DASHBOARD
        if(!empty($this->session->userdata("user_id"))){

            redirect("dashboard");
        }
    }




    // FUNCTION:  TO GET THE DATE IN YYYY-MM-DD H:i:s FORMAT
    public function get_YmdHis(){
      
      $date = date("Y-m-d H:i:s");
      return $date;
    }


    /*FUNCTION NAME: RegisterNewUser
      DESCRIPTION:   THIS FUNCTION WILL REGISTER NEW USER
      CREATED BY:    AG
      CREATED DATE:  25 JUNE 2020 */
    public function RegisterNewUser(){

        header("Access-Control-Allow-Origin: *");
        $post = $this->input->post();

        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('username', 'Username', 'required|is_unique[tbl_user.username]');
        $this->form_validation->set_rules('email', 'Email', 'required|is_unique[tbl_user.email]');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('dob', 'DOB', 'required');
        $this->form_validation->set_message("is_unique", "%s is already exist");
        if ($this->form_validation->run() === TRUE) {

            $first_name = $post['first_name'];
            $username = $post['username'];
            $email = $post['email'];
            $dob = $post['dob'];
            $password = base64_encode($post['password']);
           
            $insert_data = array("first_name"=>$first_name,
                                 "last_name"=>$post['last_name'],
                                 "email"=>$email,
                                 "dob"=>$dob,                               
                                 "password" =>$password,
                                 "username"=>$username,
                                 "created_date"=>$this->get_YmdHis()
                                );

            // echo "<pre>"; print_r($insert_data); die;
            if($this->Model->insertData("tbl_user", $insert_data)){
                           
                $this->session->set_flashdata('category_success', 'Successfully Registered. You can login now');
                redirect('login');
                
            } else {
                $this->session->set_flashdata('category_error', 'Something went wrong to register new user');
                redirect('login');
            }
        }

        $data = array();
        $this->template->set('title', 'Register');
        $this->template->admin_load('default_login_layout', 'contents', 'register', $data);

    }


  /*FUNCTION NAME: index
    DESCRIPTION:   THIS FUNCTION SHOW THE DASHBOARD OF LOGGED IN USER
    CREATED BY:    AG
    CREATED DATE:  25 JUNE 2020 */
    public function index()
    {

        header("Access-Control-Allow-Origin: *");
        $post = $this->input->post();

       // $this->form_validation->set_rules('username', 'username', 'required|is_unique[tbl_user.username]');
        $this->form_validation->set_rules('password', 'Password', 'required');
        if ($this->form_validation->run() === TRUE) {

            $username = $post['username'];
            $password = base64_encode($post['password']);
           
            if($onerow = $this->Model->getOneRowData("tbl_user", array("username"=>$username, "password"=>$password))){
            
                $this->session->set_userdata('user_id', $onerow['user_id']);                  
                $this->session->set_userdata('user_name', $onerow['username']);

                // ====== NOW SEND MAIL TO USER IF HE HAS BIRTHDAY TODAY============
                $getd =  $this->Model->getOneRowData("tbl_send_mail", array("user_id"=>$onerow['user_id'], "wished_year"=>date("Y")));
                if(empty($getd)){               

                    $get_month_date = date("m-d", strtotime($onerow['dob']));                    
                    if($get_month_date == date("m-d")){

                        if($this->send_mail($onerow['email'], "", "has_birthday")){

                            $insert_d = array("user_id"=>$onerow['user_id'],
                                              "wished_year"=>date("Y"),
                                              "created_date"=>$this->get_YmdHis()
                                            );

                            $this->Model->insertData("tbl_send_mail", $insert_d);
                        }
                    }
                }
                //========================= END HERE ========================================
               // echo $this->session->userdata("user_id"); die;
                $this->session->set_flashdata('category_success', 'Successfully Login');
                redirect('dashboard');
                
            } else {
                $this->session->set_flashdata('category_error', 'Invalid username or password');
                redirect('login');
            }
        }

        $data = array();
        $this->template->set('title', 'Welcome');
        $this->template->admin_load('default_login_layout', 'contents', 'index', $data);
    }



     /*FUNCTION NAME: forgotPassword
       DESCRIPTION:   THIS FUNCTION WILL SEND THE PASSWORD OF USER TO HIS/HER REGISTERED EMAIL ADDRESS
       CREATED BY:    AG
       CREATED DATE:  25 JUNE 2020 */
    public function forgotPassword(){

        header("Access-Control-Allow-Origin: *");
        $data = array();
        $post = $this->input->post();

        $this->form_validation->set_rules('email', 'Email', 'required');
        if ($this->form_validation->run() === TRUE) {

            $email = $post['email'];       
            if($oneuser = $this->Model->getOneRowData("tbl_user", array("email"=>$email))){
                    
                $pwd = base64_decode($oneuser['password']);
                $emaill = $oneuser['email'];
                if($this->send_mail($emaill, $pwd, "forgot_password")){

                    $this->session->set_flashdata('category_error', 'Password has been send to registered email. Please check your mail');
                    redirect('forgot-password');
                }else{

                    $this->session->set_flashdata('category_error', 'Something went wrong to send mail');
                    redirect('forgot-password');
                }                
                
            } else {
                $this->session->set_flashdata('category_error', 'Email does not exist');
                redirect('forgot-password');
            }
        }

        $this->template->set('title', 'Welcome');
        $this->template->admin_load('default_login_layout', 'contents', 'forgot_password', $data);
    }




 /*FUNCTION NAME: send_mail
   DESCRIPTION:   THIS FUNCTION WILL SEND THE MAIL. 
   CREATED BY:    AG
   CREATED DATE:  25 JUNE 2020 */
   function send_mail($email, $old_pwd, $type=""){


        $mail = new PHPMailer;

        $mail->isSMTP();                           
        $mail->Host = 'smtp.gmail.com';             // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                     // Enable SMTP authentication
        $mail->Username = 'testingsendmail521@gmail.com';          // SMTP username
        $mail->Password = 'testingq1*q1*q1*'; // SMTP password
        $mail->SMTPSecure = 'tls';             // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                     // TCP port to connect to
        
        // $mail->addReplyTo('testingsendmail521@gmail.com', 'Protonshub');
        $mail->addAddress($email);   // Add a recipient
        // $mail->addCC('ccc@example.com');
        // $mail->addBCC('bcc@example.com'); 

        $mail->isHTML(true);  // Set email format to HTML

        if($type == "has_birthday"){

            $mail->setFrom('testingsendmail521@gmail.com', 'Happy Birthday From ProtonsHub.com');
            $bodyContent = '<h1>“Wishing you a day filled with happiness and a year filled with joy. Happy birthday!”</h1>';
            $bodyContent .= '<p>Hope your special day brings you all that your heart desires <b>Protonshub</b></p>';

            $mail->Subject = 'Protonshub wish you a very HaPpY BiRthDay...';
            $mail->Body    = $bodyContent;
        }

        if($type == "forgot_password"){
            
            $mail->setFrom('testingsendmail521@gmail.com', 'Forgot Password Request');

            $bodyContent = '<h1>We have Received your forgot password request here is your password</h1>';
            $bodyContent .= '<p><b>Your Password: '.$old_pwd.'</b></p>';

            $mail->Subject = 'You have requested for forgot password';
            $mail->Body    = $bodyContent;

        }
       
        if(!$mail->send()) {

            return false;
            // echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {

            return true;
            // echo 'Message has been sent';
        }
    }


}
