<?php require_once "../includes/session.php";?>
<?php require_once "../includes/db_connection.php";?>
<?php require_once "../includes/functions.php";?>
<?php require_once "../includes/validation_functions.php";?>
<?php 
    if(logged_in()){
        $_SESSION["message"] = "You are already logged in";
        redirect_to("admin.php");
    }
?>

<?php 
$username = "";
if (isset($_POST['submit'])) {
    //process the form
    
    $username = escape_string($_POST["username"]);
    $password = escape_string($_POST["password"]); //no need to escape this

    //validations
    $required_fields = array("username", "password");
    validate_presences($required_fields);

    $fields_with_max_lengths = array("username" => 30);
    validate_max_lengths($fields_with_max_lengths);

    // $fields_with_max_lengths = array("content" => 100);
    // validate_max_lengths($fields_with_max_lengths);

    if (empty($errors)) {
        //perform create

        
        $found_admin = attempt_login($username, $password);

        if ($found_admin) {
            // Success
            //mark user as logged in
            $_SESSION["admin_id"] = $found_admin["id"];// using session is secure than using cookie bacause session is stored in serverside unlike cookie
            $_SESSION["username"] = $found_admin["username"];
            redirect_to("admin.php");
        } else {
            // Failure
            $_SESSION["message"] = "Username/password not found.";
        }
    }
} else {
    //this is probably a get request
} // end of: if (isset($_POST['submit']))
?>

<?php $layout_context = "admin";?>
<?php include "../includes/layouts/header.php";?>
	<div id="main">
		<div id="navigation">

		</div>
		<div id="page">
            <?php echo message(); ?>
			<?php echo form_errors($errors); ?>
			<h2>Admin Login</h2>
			<form action="login.php" method="post">
                Username <input type="text" name="username" value="<?php echo htmlentities($username); ?>"><br><br>
                    
                Password <input type="password" name="password" value=""><br><br>
                        

                         <input type="submit" name="submit" value="Login">

            </form>
            <!-- <br>
				<a href="manage_admins.php">Cancel</a> -->
		</div>
	</div>

<?php include "../includes/layouts/footer.php";?>