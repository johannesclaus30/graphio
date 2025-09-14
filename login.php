<?php

$User_Email = $User_Password = "";
$User_EmailErr = $User_PasswordErr = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(empty($_POST["User_Email"])) {
        $User_EmailErr = "Email is required!";
    } else {
        $User_Email = $_POST["User_Email"];
    }

    if(empty($_POST["User_Password"])) {
        $User_PasswordErr = "Password is required!";
    } else {
        $User_Password = $_POST["User_Password"];
    }

    if($User_Email && $User_Password) {
        include("connections.php");
        $check_email = mysqli_query($connections, "SELECT * FROM user WHERE User_Email='$User_Email'");
        $check_email_row = mysqli_num_rows($check_email);

        if($check_email_row > 0) {
            while($row = mysqli_fetch_assoc($check_email)) {
                
                $User_ID = $row["User_ID"];

                $User_PasswordDB = $row["User_Password"];
                $User_Type = $row["User_Type"];

                if($User_Password == $User_PasswordDB) {

                    session_start();
                    $_SESSION["User_ID"] = $User_ID;

                    if($User_Type == "1") {
                        echo "<script>window.location.href='user.php';</script>";
                    } else {
                        echo "<script>window.location.href='admin';</script>";
                    }
                } else {
                    $User_PasswordErr = "Password is incorrect!";
                }
            }
        } else {
            $User_EmailErr = "Email is not registered!";
        }
    }
}
?>

<style>
.error {
    color: #fafafa;
    font-family: "Poppins", sans-serif;
    font-size: 15px;
    margin-top: 5px;
}
</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="login2.css">
</head>
<body>
    <div class="login">
    <div class="upper-header-blue">
        <div class="welcome-to-graphio">
        <div class="welcome-to">Welcome to</div>
        <img class="graphio-logo-white" src="logos/graphio_logo_white.png" />
        </div>

        <form method="POST" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="login-fields">
            <div class="email">
                <div class="email-txt">Email</div>
                <input type="text" class="email-field" name="User_Email" value="<?php echo $User_Email; ?>">
                <span class="error"><?php echo $User_EmailErr; ?></span>
            </div>
            <div class="password">
                <div class="password-txt">Password</div>
                <input type="password" class="password-field" name="User_Password" value="">
                <span class="error"><?php echo $User_PasswordErr; ?></span>
            </div>
            <button type="submit" class="login-button">
                <div class="login-txt">Log in</div>
            </button>
        </form>
        
        <div class="signup-text">
            <div class="don-t-have-an-account">Don’t have an account?</div>
            <div><a href="signup.php" class="signup-txt">Sign Up</a></div>
        </div>
        </div>
    </div>

    <div class="your-creations">
        <div class="frame-10">
        <div class="your-creations-deserved-to-be-in-the-spotlight">
            Your Creations, Deserved to be in the Spotlight
        </div>
        <div class="upload-designs">
            <div class="upload-designs2">Upload Designs</div>
            <div class="rectangle-3"></div>
        </div>
        </div>
        <img class="picture-frame-01" src="elements/Picture_Frame.png" />
    </div>
    <div class="footer">
        <div class="frame-14">
        <img
            class="graphio-studio-logo-white"
            src="logos/graphio_logo_white.png"
        />
        <div class="frame-13">
            <div class="about-graphio-studio">About graphio.studio</div>
            <div class="privacy-policy">Privacy policy</div>
            <div class="terms-conditions">Terms &amp; Conditions</div>
            <div class="help-center">Help Center</div>
            <div class="company">Company</div>
            <div class="contact-us">Contact us</div>
            <div class="products">Products</div>
            <div class="services">Services</div>
            <div class="marketplace">Marketplace</div>
        </div>
        </div>
    </div>
    </div>
</body>
</html>