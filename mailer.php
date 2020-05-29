<?php
//===================================================================
//do not edit anything above or below the lines
//input sanitizing to prevent injection - only process POST requests!!
//jason young 21/12/2018
//===================================================================



if($_SERVER["REQUEST_METHOD"]=="POST"){
    //remove white space from fields and get them
    $name = strip_tags(trim($_POST["name"]));
}

$name = str_replace(array("\r","\n"),array("",""),$name);
$email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
$message = trim($_POST["message"]);
$phone = strip_tags(trim($_POST["phone"]));
$selected_val = $_POST['need'];

// check data was sent to mailer
if (empty($name) or empty($message) or ! filter_var($email,FILTER_VALIDATE_EMAIL)){
    //set 400 response code & exit (bad request)
    http_response_code(400);
    echo "Oops! There was a problem with your submission.\n Please complete the form and try again";
    exit;
}

//set recipient email
$recipient = "vivienne.elizabeth94@gmail.com";
//set subject heading
$subject = "New HarpEvents enquiry from $name";
//set mail content
$email_content = "Name: $name\n";
$email_content.= "Phone: $phone\n\n";
$email_content.= "Query: $selected_val\n\n";
$email_content.= "Email: $email\n\n";
$email_content.= "Message: \n$message\n";
//set mail header
$email_headers = "Reply-To: $name <$email>";
//send mail
if(mail($recipient, $subject, $email_content, $email_headers)){
//set 200 response code (okay)
    http_response_code(200);
    echo "Thank you! Your message has been sent";
} else{
//set 500 response code (internal server error)
    http_response_code(500);
    echo "Oops! Something went wrong and we couldn't send your message";};
    if($_SERVER["REQUEST_METHOD"]!=="POST"){

        //set a 403 response code (forbidden) // not a POST request
            http_response_code(403);
            echo "There was a problem with your submission, Please try again";
        
        }
?>

