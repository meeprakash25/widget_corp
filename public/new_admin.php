<?php require_once "../includes/session.php";?>
<?php require_once "../includes/db_connection.php";?>
<?php require_once "../includes/functions.php";?>
<?php require_once "../includes/validation_functions.php";?>
<?php confirm_logged_in() ?>

<?php 
if (isset($_POST['submit'])) {
    //process the form
    
    //validations
    $required_fields = array("username", "password");
    validate_presences($required_fields);

    $fields_with_max_lengths = array("username" => 30);
    validate_max_lengths($fields_with_max_lengths);

    // $fields_with_max_lengths = array("content" => 100);
    // validate_max_lengths($fields_with_max_lengths);

    if (empty($errors)) {
        //perform create

        $username = escape_string($_POST["username"]);
        $hashed_password = password_encrypt($_POST["password"]); //no need to escape this
        
        // 2. Perform database query
        $query  = "INSERT INTO admins (";
        $query .= "username, hashed_password";
        $query .= ") VALUES (";
        $query .= "'{$username}','{$hashed_password}'";
        $query .= ")";
        $result = mysqli_query($connection, $query);
        echo $query;
        if ($result && mysqli_affected_rows($connection) >= 0) {
            // Success
            $_SESSION["message"] = "Admin created";
            redirect_to("manage_admins.php");
        } else {
            // Failure
            $_SESSION["message"] = "Admin creation failed.";
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
			<h2>Add Admin</h2>
			<form action="new_admin.php" method="post">
                Username <input type="text" name="username" value=""><br><br>

                Password <input type="password" name="password" value=""><br><br>

                        <input type="submit" name="submit" value="Add Admin">

            </form>
            <br>
				<a href="manage_admins.php">Cancel</a>
		</div>
	</div>

<?php include "../includes/layouts/footer.php";?>