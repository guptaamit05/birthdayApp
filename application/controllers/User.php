<?php

defined('BASEPATH') or exit('No direct script access allowed');


/* CLASS:  USER */
class User extends CI_Controller 
{

    public function __construct()   // CONSTRUCTOR FUNCTION
    {

        parent::__construct();  

        $this->load->library("session");

        // IF USER IS  NOT LOGIN THAN REDIRECT TO LOGIN PAGE
        if(!$this->session->userdata("user_id")){

            redirect("login");
        }
    }


     // FUNCTION:  TO GET THE DATE IN YYYY-MM-DD H:i:s FORMAT
    public function get_YmdHis(){
      
      $date = date("Y-m-d H:i:s");
      return $date;
    }



    /*FUNCTION NAME: ResetPassword
      DESCRIPTION:   THIS FUNCTION WILL RESET THE PASSWORD OF USER 
      CREATED BY:    AG
      CREATED DATE:  25 JUNE 2020 */
    public function ResetPassword(){

        $user_id= $this->session->userdata("user_id");
        $submit = $this->input->post('submit');

        if ($submit) {

            $this->form_validation->set_rules('old_password', 'Old password', 'required');
            $this->form_validation->set_rules('UserPass', 'New password', 'required');

            if ($this->form_validation->run() === TRUE) {

                $old_password = $this->input->post('old_password');
                $check_oldpass = base64_encode($old_password);
                $UserPass = $this->input->post('UserPass');
                $new_pass = base64_encode($UserPass);
                                         
                if ($onerow = $this->Model->getOneRowData("tbl_user", array("user_id"=>$user_id))) {

                    $old_pass = $onerow['password'];
                  
                    if ($old_pass == $check_oldpass) {

                        $update_data = array("password"=>$new_pass);                       
                      
                        if ($this->Model->updateData("tbl_user", array("user_id"=>$user_id), $update_data) ) {

                            $this->session->set_flashdata('category_success', 'New password updated successfully');
                            redirect('reset-password');
                        } else {

                            $this->session->set_flashdata('category_error', 'Something went wrong!');
                            redirect('reset-password');
                        }
                    } else {

                        $this->session->set_flashdata('category_error', 'Old Password is wrong');
                        redirect('reset-password');
                    }
                } else {

                    $this->session->set_flashdata('category_error', 'invalid data provided!');
                    redirect('reset-password');
                }
                
            }
        }

        header("Access-Control-Allow-Origin: *");
        $data = array();
        $this->template->set('title', 'resetPassword');
        $this->template->admin_load('default_layout', 'contents', 'change_password', $data, true);
    }


   /* FUNCTION NAME:   dashboard
   DESCRIPTION:        THIS FUNCTION WILL SHOW THE DASHBOARD DATA OF USER
   CREATED BY:         AG  
   CREATED DATE:       25 JUNE 2020 */
   public function dashboard(){

        $user_id = $this->session->userdata('user_id');         
        $data = array();
        header("Access-Control-Allow-Origin: *");
       
        $this->template->set('title', 'Dashboard');
        $this->template->admin_load('default_layout', 'contents', 'home', $data);
    }


    /* FUNCTION NAME: allUsers
       DESCRIPTION:   THIS FUNCTION WILL SHOW ALL USERS WHO REGISTERED
       CREATED BY:    AG 
       CREATED DATE:  25 JUNE 2020 */
    public function allUsers(){

        $user_id = $this->session->userdata('user_id');         
        $data = array();
        header("Access-Control-Allow-Origin: *");
       
        $data['all_users'] = $this->Model->getAllRowData("tbl_user", array("user_id !="=>$user_id));
        $this->template->set('title', 'AllUsers');
        $this->template->admin_load('default_layout', 'contents', 'all_users', $data);
    }




    /* FUNCTION NAME: sendMessage
       DESCRIPTION:   THIS FUNCTION WILL SEND THE MESSAGE TO USER WHEN HIS/HER BIRTHDAY WILL COME
       CREATED BY:    AG 
       CREATED DATE:  25 JUNE 2020 */
    public function sendMessage($toid = ""){

        $user_id = $this->session->userdata('user_id');         
        $data = array();
        header("Access-Control-Allow-Origin: *");

        if(!empty($toid)){

            $post = $this->input->post();
            if(!empty(trim($post['message']))){

                $insert = array("user_id"=>$user_id,
                                "wished_to"=>$toid,
                                "message"=>$post['message'],
                                "wished_year"=>date("Y"),
                                "created_date"=>$this->get_YmdHis()
                               );

                if($this->Model->insertData("tbl_wished_list", $insert)){

                    $this->session->set_flashdata('category_success', 'Message sent successfully');
                    redirect('all-users');

                }else{
                     $this->session->set_flashdata('category_error', 'Something went wrong to send message');
                    redirect('all-users');
                }
            }else{
                
                $this->session->set_flashdata('category_error', 'Message is required');
                redirect('all-users');
            }   
        }

    }


    /* FUNCTION NAME: userWishedList
       DESCRIPTION:   THIS FUNCTION WILL SHOW THE LIST OF USER WHO MESSAGE ME ON MY BIRTHDAY
       CREATED BY:    AG 
       CREATED DATE:  25 JUNE 2020 */
    public function userWishedList(){

        $user_id = $this->session->userdata('user_id');         
        $data = array();
        header("Access-Control-Allow-Origin: *");
        
        $data['all_wishes'] = $this->Model->getJoinData($user_id);
        // echo "<pre>"; print_r($data); die;
        $this->template->set('title', 'WishList');
        $this->template->admin_load('default_layout', 'contents', 'user_wished_list', $data);

    }

  

     /* FUNCTION NAME: logout
        DESCRIPTION:   THIS FUNCTION WILL CLEAR THE SESSION OF USER AND LOG OUT THEM.
        CREATED BY:    AG 
        CREATED DATE:  25 JUNE 2020 */
    public function logout(){

        $this->session->sess_destroy();    // CLEAR ALL SESSION DATA
        redirect('login');
    }

   


}
