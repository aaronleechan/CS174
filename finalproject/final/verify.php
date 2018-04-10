<?php

function verify_session($current_page){

    session_start();
    if((isset($_SESSION['admin']))){
       //header ('Location: adminscan.php');
    }else{
        header('Location: index.php');
    }

}

?>