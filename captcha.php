<?php
ob_start();
session_start();

function generateCaptcha(){
    $captcha = rand(1000, 9999);
     // Generate a random 4-digit captcha
    $_SESSION['captcha'] = $captcha; 
   // Store the captcha value in session
    return $captcha; // Return the generated captcha

  
}
if (isset($_GET['action']) && $_GET['action'] == 'generateCaptcha') {
  $text = generateCaptcha();
  echo  $text;
}





