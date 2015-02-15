<?php
// Check for empty fields
if(empty($_POST['fname'])     ||
   empty($_POST['lname'])     ||
   empty($_POST['company'])   ||
   empty($_POST['email'])     ||
   empty($_POST['phone'])     ||
   empty($_POST['message'])   ||
   !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)) 
   {
   echo "No arguments Provided!";
   return false;
   }

$fname = $_POST['fname'];
$lname = $_POST['lname'];
$company = $_POST['company'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$message = $_POST['message'];
$url = $_POST['url'];
$youremail = 'noreply@agilepond.com';


$data = array(
   "oid" => "00Do0000000HFOs",
   "retURL" => "http://www.yourdomain.com",
   "first_name" => $fname,
   "last_name" => $lname,
   "company" => $company,
   "email" => $email,
   "phone" => $phone,
   "description" => $message,
   "lead_source" => "Web"
);  

   if( $email && !preg_match( "/[\r\n]/", $email) ) {
         $headers = "From: $email\n";
         $headers .= "Reply-To: $email";     
     } else {
         $headers = "From: $youremail"; 
     }
   
   if($url == ''){   
   $to = 'tom+noreply@agilepond.com'; 
   $email_subject = "Website Contact Form: $fname";
   $email_body = "You have received a new message from your website contact form.\n
   \n"."Here are the details:\n
   \nName: $fname\n
   \nEmail: $email\n
   \nPhone: $phone\n
   \nMessage:\n$message";

   mail($to,$email_subject,$email_body,$headers);
   post_to_url("https://www.salesforce.com/servlet/servlet.WebToLead?encoding=UTF-8", $data);
   return true;
   }
  

function post_to_url($sfurl, $data) {
   $fields = '';
   foreach($data as $key => $value) { 
      $fields .= $key . '=' . $value . '&'; 
   }
   rtrim($fields, '&');

   $post = curl_init();

   curl_setopt($post, CURLOPT_URL, $sfurl);
   curl_setopt($post, CURLOPT_POST, count($data));
   curl_setopt($post, CURLOPT_POSTFIELDS, $fields);
   curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);

   $result = curl_exec($post);

   curl_close($post);
}
      
?>