
<?php


function TrimUpcomingPostData(){

$link = mysqli_connect("localhost", "root", "", "birthdayapp") ;

  if(count($_POST) > 0 ){

    foreach($_POST as $k => $v){

      if(!is_array($_POST[$k])){ 

        $_POST[$k] = trim($_POST[$k]);
        $_POST[$k] = mysqli_real_escape_string($link, $_POST[$k]);
        // $_POST[$k] = addslashes($_POST[$k]);

      }   
    }   
  }
}
