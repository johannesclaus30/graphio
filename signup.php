<?php

include("connections.php");

$User_Name = $User_Email = $User_Password = $User_ConfirmPassword = $User_Type = "";
$User_NameErr = $User_EmailErr = $User_PasswordErr = $User_ConfirmPasswordErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["User_Name"])) {
        $User_NameErr = "Name is required!";
    } else {
        $User_Name = $_POST["User_Name"];
    }

    if (empty($_POST["User_Email"])) {
        $User_EmailErr = "Email is required!";
    } else {
        $User_Email = $_POST["User_Email"];
    }

    if (empty($_POST["User_Password"])) {
        $User_PasswordErr = "Password is required!";
    } else {
        $User_Password = $_POST["User_Password"];
    }

    if (empty($_POST["User_ConfirmPassword"])) {
        $User_ConfirmPasswordErr = "Confirm Password is required!";
    } else {
        $User_ConfirmPassword = $_POST["User_ConfirmPassword"];
    }

    if ($User_Name && $User_Email && $User_Password && $User_ConfirmPassword) {
        $check_email = mysqli_query($connections, "SELECT * FROM user WHERE User_Email='$User_Email'");
        $check_email_row = mysqli_num_rows($check_email);

        if($check_email_row > 0) {
            $User_EmailErr = "Email is already registered!";
        } else {
            $query = mysqli_query($connections, "INSERT INTO user (User_Name, User_Email, User_Password, User_Type) VALUES ('$User_Name','$User_Email','$User_Password','1')");

            echo "<script language='javascript'>alert('New Record has been inserted!')</script>";
            echo "<script>window.location.href='login.php';</script>";
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
    <title>Create Graphio Account | Sign Up</title>
    <link rel="stylesheet" href="signup2.css">
</head>
<body>
    <div class="signup">
    <div class="upper-header-blue">
        <div class="welcome-to-graphio">
        <div class="welcome-to">Welcome to</div>
        <img class="graphio-logo-white" src="logos/graphio_logo_white.png" />
        </div>

        <form method="POST" action="<?php htmlspecialchars("PHP_SELF"); ?>">
        <div class="signup-fields">
            <div class="name">
                <div class="name-txt">Name</div>
                <input type="text" name="User_Name" class="name-field" value="<?php echo $User_Name; ?>">
                <span class="error"><?php echo $User_NameErr; ?></span>
            </div>
            <div class="email">
                <div class="email-txt">Email</div>
                <input type="text" name="User_Email" class="email-field" value="<?php echo $User_Email; ?>">
                <span class="error"><?php echo $User_EmailErr; ?></span>
            </div>
            <div class="password">
                <div class="password-txt">Password</div>
                <input type="password" name="User_Password" class="password-field" value="<?php echo $User_Password; ?>">
                <span class="error"><?php echo $User_PasswordErr; ?></span>
            </div>
            <div class="confirm-password">
                <div class="confirm-password-txt">Confirm Password</div>
                <input type="password" name="User_ConfirmPassword" class="confirm-password-field" value="<?php echo $User_ConfirmPassword; ?>">
                <span class="error"><?php echo $User_ConfirmPasswordErr; ?></span>
            </div>
            <button type="submit" class="signup-button">
                <div class="signup-lbl">Signup</div>    
            </button>
        </form>

        <div class="login">
            <div class="already-have-an-account">Already have an account?</div>
            <div class="log-in">Log In</div>
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