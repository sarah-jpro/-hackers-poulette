<?php
try
{
	// On se connecte à MySQL
	$conn = new PDO('mysql:host=localhost;dbname=hackers-poulette;charset=utf8;port=3307', 'root', 'root');
}
catch(Exception $e)
{
	// En cas d'erreur, on affiche un message et stop
        die('Erreur : '.$e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="assets\sass\style.css"rel="stylesheet"/>
    <link rel="icon" href="assets/img/hackers-poulette-logo.png">
    <title>Hackers Poulette</title>
</head>
<body>
    <header>
        <div class="header">
            <h1>Hackers Poulette</h1>
            <div class="logo"><img src="assets\image\hackers-poulette-logo.png" alt="logo-hackers-poulette" width="200" >
            </div>
        </div>
    </header>  
    <main>
        <div class="container-main">
            <form method="post">
                <div class="row">
                    <div class="col-25">
                        <label for="Name">Name :</label>
                    </div> 
                    <div class="col-75">   
                        <input type="text" id="name" name="name" placeholder="Enter your name" size="30" aria-required="true" required/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="lastname">Lastname :</label>
                    </div>
                    <div class="col-75">      
                        <input type="text" id="lastname"name="lastname" placeholder="Enter your lastname" size="30" aria-required="true" required/>
                    </div>
                </div>
                <div class="row"> 
                    <div class="col-25">   
                        <label for="country" name="Country:">Country:</label>
                    </div>
                    <div class="col-75">
                        <select id="country" name="country" aria-required="true" required>
                            <option value="belgium" aria-label="belgium">Belgium</option>
                            <option value="spain" aria-label="spain">Spain</option>
                            <option value="italy" aria-label="italy">Italy</option>
                        </select>
                    </div>                  
                </div>
                    <div class="row">
                        <div class="col-25"> 
                            <label id="gender" aria-required="true" required>Gender :</label>
                        </div>   
                        <div class="col-75">
                            <input type="radio" name="gender" value="man" />Man
                            <input type="radio" name="gender" value="woman" />Woman
                        </div>        
                    </div>
                <div class="row">
                    <div class="col-25">
                        <label for="email">Email address : </label>
                    </div> 
                    <div class="col-75">   
                        <input type="text" name="email" placeholder="Enter your email" class="input" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" aria-required="true">
                    </div> 
                </div>       
                <div class="row">
                    <div class="col-25">
                        <label for="subject"aria-required="true" >Subject :</label>
                    </div>
                    <div class="col-75">    
                        <input type="radio"  name="subject" value="info" />Information<br/>
                        <input type="radio" name="subject" value="request" />Request<br />
                        <input type="radio" name="subject" value="other" />Other
                    </div>
                    <div class="row"> 
                        <div class="col-25">   
                            <label for="message">Message:</label>
                        </div>
                        <div class="col-75">
                            <textarea id="message" name="message" rows="5" cols="40" placeholder="Write your message here." aria-required="true"  aria-label="Write your message here" pattern="[a-zA-Z0-9._%+-]" required></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <input type="submit" value="SUBMIT" aria-label="submit"/>
                    </div>
                </div>    
            </form>
        </div>   
    </main>
    <?php

    // Vérification du remplissage des champs
    $msg_erreur = "Error. Please check the form
    <br/><br/>";
    $msg_ok = "Yours informations are send.Thank you";
    $message = $msg_erreur;

    //vérifier que certains champs obligatoires sont bien remplis,
    if (empty($_POST['name'])) 
    $message .= "Your name?<br/>";
    if (empty($_POST['lastname'])) 
    $message .= "Your lastname?<br/>";
    if (empty($_POST['country'])) 
    $message .= "Your country?<br/>";
    if (empty($_POST['gender'])) 
    $message .= "Your gender?<br/>";
    if (empty($_POST['email'])) 
    $message .= "Your email?<br/>";
    if (empty($_POST['subject'])) 
    $message .= "Your subject?<br/>";
    if (empty($_POST['message'])) 
    $message .= "Your message?<br/>";

    $name = isset($_POST['name'])?$_POST['name']:NULL;
    $lastname = isset($_POST['lastname'])?$_POST['lastname']:NULL;
    $country = isset($_POST['country'])?$_POST['country']:NULL;
    $gender = isset($_POST['gender'])?$_POST['gender']:NULL;
    $email = isset($_POST['email'])?$_POST['email']:NULL;
    $subject = isset($_POST['subject'])?$_POST['subject']:NULL;
    $message = isset($_POST['message'])?$_POST['message']:NULL;
    

    $statement = $conn -> prepare("INSERT INTO form (name, lastname, country, gender, email, subject, message) VALUES (:name, :lastname, :country, :gender, :email, :subject, :message)");

    $statement -> execute([
        'name' => $name,
        'lastname' => $lastname,
        'country' => $country,
        'gender' => $gender,
        'email' => $email,
        'subject' => $subject,
        'message' => $message,
    ]);  

?> 
<?php
    //Sanitised
    $options = array(
        'name' => htmlspecialchars($name),
        'lastname' => htmlspecialchars($lastname),
        'email' => FILTER_SANITIZE_EMAIL,
        'country' => htmlspecialchars($country),
        'message' => htmlspecialchars($message),
    );

    $result = filter_input_array(INPUT_POST, $options);
?>    
<?php   
    //valided
    $errors = array();

    if (false === filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "This address is invalid.";
    }
?>
    <!-- Copyright -->
    <footer>
        <div class="footer" > 
            <p>&copy 2022 Copyright-Sarah</p> 
            <div class="ft-logo">
                <a href="#"><img src="assets\image\github (1).png" alt="logo_github" width="50" height="auto"></a>
                <a href="#"><img src ="assets\image\linkedin.png" alt="logo_linkedin"width="50" height="auto"></a>
            </div>
        </div>
    </footer>
    </body>
</html>
