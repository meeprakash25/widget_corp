<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php confirm_logged_in() ?>

<?php $current_admin = find_admin_by_id($_GET["admin"]); ?>
<?php
	if(!$current_admin){
		// admin id was missing or invalid
		// admin couldn't be found in database
		redirect_to("manage_admins.php");
	}
?>

<?php 
	if (isset($_POST['submit'])) {
		//process the form
		
		//validations
		$required_fields = array("username", "password");
		validate_presences($required_fields);
		
		$fields_with_max_lengths = array("username" => 20);
		validate_max_lengths($fields_with_max_lengths);
		
		// if($current_admin["hashed_password"]===$password){		
			
			if (empty($errors)) {
				
				$id=$current_admin["id"];
				$username = escape_string($_POST["username"]);
				$hashed_password = password_encrypt($_POST["password"]);
				
				// 2. Perform database update
				$query = "UPDATE admins SET ";
				$query .= "username = '{$username}', ";
				$query .= "hashed_password = '{$hashed_password}' ";
				$query .= "WHERE id = {$id} ";
				$query .= "LIMIT 1";
				$result = mysqli_query($connection, $query);
				confirm_query($result);
				if ($result && mysqli_affected_rows($connection) >= 0) {
					// Success
					$_SESSION["message"] = "Admin updated.";
					redirect_to("manage_admins.php");
				} else {
					// Failure
					$_SESSION["message"] = "Admin update failed.";
				}
			}else {
			//this is probably a get request
			}
		// }else{
		// 	$_SESSION["message"] = "passwords don't match";
		// }
} // end of: if (isset($_POST['submit']))


?>


<?php $layout_context = "admin"; ?>
<?php include("../includes/layouts/header.php"); ?>

	<div id="main">
		<div id="navigation">
	
		</div>
		<div id="page">
			<?php echo message(); ?>
			<?php echo form_errors($errors); ?>
				<h2>Edit Admin</h2>
					<form action="edit_admin.php?admin=<?php echo urldecode($current_admin["id"]); ?>" method="post">
					New Username <input type="text" name="username" value="<?php echo htmlentities($current_admin["username"]); ?>"><br><br>
					
					New Password <input type="password" name="password" value=""><br><br>

							<input type="submit" name="submit" value="Edit Admin">

				</form>
				<br>
				<a href="manage_admins.php">Cancel</a>
                
			
			</div>
	</div>

<?php include("../includes/layouts/footer.php"); ?>