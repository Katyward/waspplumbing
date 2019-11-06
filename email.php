<?php
require 'vendor/autoload.php';
use \Mailgun\Mailgun;

if (isset($_GET['email'])) {

    $email_to = "liam@waspplumbing.com.au";
    $email_subject = "Someone contacted you from your website!";
    $from_text = 'Wasp Plumbing <admin@waspplumbing.com.au>';
  
 
    function died($error) {
 
        echo "We are very sorry, but there were error(s) found with the form you submitted. ";
 
        echo "These errors appear below.<br /><br />";
 
        echo $error."<br /><br />";
 
        echo "Please go back and fix these errors.<br /><br />";
 
        die();
 
    }
 
     
 
    // validation expected data exists
 
    if ( !isset($_GET['name']) ||
  
        !isset($_GET['email']) ||
 
        !isset($_GET['message'])
    ) {
 
        died('We are sorry, but there appears to be a problem with the form you submitted.');       
 
    }     
 
    $full_name = $_GET['name']; // required
 
    $message = $_GET['message']; // required
 
    $email_from = $_GET['email']; // required
     
 
    $error_message = "";
 
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
 
  if(!preg_match($email_exp,$email_from)) {
 
    $error_message .= 'The Email Address you entered does not appear to be valid.<br />';
 
  }
 
    $string_exp = "/^[A-Za-z .'-]+$/";
 
  if(!preg_match($string_exp,$full_name)) {
 
    $error_message .= 'The First Name you entered does not appear to be valid.<br />';
 
  }
 
  if(strlen($error_message) > 0) {
 
    died($error_message);
 
  }
 
    $email_message = $full_name." has contacted you via your website.\n\n";
 
     
 
    function clean_string($string) {
 
      $bad = array("content-type","bcc:","to:","cc:","href");
 
      return str_replace($bad,"",$string);
 
    }
    
    $email_message .= "Name: ".clean_string($full_name)."\n";
    $email_message .= "Email: ".clean_string($email_from)."\n";
    $email_message .= "Message: ".clean_string($message)."\n";

    $client = new \Http\Adapter\Guzzle6\Client();
    $mg = new Mailgun('key-64c689e9aece3d730fd41de41c1fd740', $client);
    $domain = "mg.samgregory.media";

    # First, instantiate the SDK with your API credentials and define your domain. 
    # Now, compose and send your message.
    $mg->sendMessage($domain, array('from'    => $from_text, 
                                    'to'      => $email_to, 
                                    'subject' => $email_subject, 
                                    'text'    => $email_message));

}
 
// Redirect after mail sent
header('Location: http://www.waspplumbing.com.au');

?>