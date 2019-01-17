<?php

    // check if user is coming from request
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        // assign variables
        $user   = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
        $email  = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $cell   = filter_var($_POST['cellphone'], FILTER_SANITIZE_NUMBER_INT);
        $msg    = filter_var($_POST['message'], FILTER_SANITIZE_STRING);

        // Creat error variables
        $userError   = '';
        $emailError  = '';
        $msgError    = '';

        if(strlen($user) < 4){
            $userError = "<div class='alert alert-danger'>Username must be at least <strong>4 characters</strong></div>";
        }

        if(empty($email)){
            $emailError = "<div class='alert alert-danger'>Email can't be <strong>empty</strong></div>";
        }

        if(strlen($msg) < 10){
            $msgError = "<div class='alert alert-danger'>Message must be at least <strong>10 characters</strong></div>";
        }

        // Creat variable to check if there's some error, use this var to preserve field data after click on submit
        $formErrors = false;

        if(!empty($userError) || !empty($emailError) || !empty($msgError)){
            $formErrors = true;
        }

        // if there's no errors send the msg with php function : mail(To, Subject, Message, Headers, Parameters)
        
        $myEmail = "zoubeirwarrache@gmail.com";
        $subject = "Contact Form";
        $headers = "From : " . $email . '\r\n';

        if(empty($userError) && empty($emailError) && empty($msgError)){

            mail($myEmail, $subject, $msg, $headers);
            $success = "<div class='alert alert-success'>We have received your message</div>";
            header("refresh:3 , url=http://localhost/contact/index.php");
        }   
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Contact</title>
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/contact.css">

</head>
<body>

    <!-- Start Form -->
    <div class="container">
        <h1 class="text-center">Contact Me</h1>
        <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST" class="contact-form">
            <?php
                if(isset($success)){
                    echo $success;
                }
            ?>
            <div class="form-group">
                <input type="text" name="username" class="form-control username" placeholder="Type your username" value="<?php if( isset($formErrors) && $formErrors==true){echo $user;} ?>">
                <i class="fas fa-user fa-fw"></i>
                <span class="asterisx">*</span>
                <div class='alert alert-danger custom-alert'>Username must be at least <strong>4 characters</strong></div>
                <?php
                    if(!empty($userError)){
                        echo $userError;
                    }
                ?>
            </div>

            <div class="form-group">
                <input type="email" name="email" class="form-control email" placeholder="Type a valid email" value="<?php if( isset($formErrors) && $formErrors==true){echo $email;} ?>">
                <i class="fas fa-envelope fa-fw"></i>
                <span class="asterisx">*</span>
                <div class='alert alert-danger custom-alert'>Email can't be <strong>empty</strong></div>
                <?php
                    if(!empty($emailError)){
                        echo $emailError;
                    }
                ?>
            </div>

            <div class="form-group">
                <input type="text" name="cellphone" class="form-control" placeholder="Type your cell phone" value="<?php if(isset($formErrors) && $formErrors==true){echo $cell;} ?>">
                <i class="fas fa-phone fa-fw"></i>
            </div>

            <div class="form-group">
                <textarea class="form-control message" name="message" placeholder="Your Message"><?php if( isset($formErrors) && $formErrors==true){echo $msg;}?></textarea>
                <span class="asterisx">*</span>
                <div class='alert alert-danger custom-alert'>Message must be at least <strong>10 characters</strong></div>
                <?php
                    if(!empty($msgError)){
                        echo $msgError;
                    }
                ?>
            </div>

            <input class="btn btn-success" type="submit" value="Send Message">
            <i class="fas fa-paper-plane fa-fw"></i>
            
        </form>
    </div>
    <!-- End Form -->

    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/contact.js"></script>
</body>
</html>