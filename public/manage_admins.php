<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_logged_in() ?>
<?php $layout_context = "admin"; ?>
<?php include("../includes/layouts/header.php"); ?>

<?php $admin_set = find_all_admins(); ?>

	<div id="main">
		<div id="navigation">
        <br>
		<a href="admin.php">&laquo; Main Menu</a>
	
		</div>
		<div id="page">
			<?php echo message(); ?>
                <h2>Manage Admins</h2>               
                <div class="table">
                    <table>
                        <tr>
                            <th>Username</th>
                            <th>Actions</th>
                        </tr>
                        <?php while($admin = mysqli_fetch_assoc($admin_set)){ ?>
                        <tr>
                            <td>   
                                <?php echo htmlentities($admin["username"]); ?>
                                <br>
                                <?php //echo htmlentities($admin["hashed_password"]); ?>
                            </td>
                            <td>
                                <a href="edit_admin.php?admin=<?php echo urldecode($admin["id"]);  ?>">Edit</a>
                                &nbsp;
                                <a href="delete_admin.php?admin=<?php echo urlencode($admin["id"]);  ?>" onclick="return confirm('Are you sure?');">Delete</a>
                            </td>
                        
                        </tr>
                        <?php } ?>
                    </table>
                </div>
            <a href="new_admin.php">Add a new admin</a>
            <hr>
            <?php 

            // $password = "secret";
            // $hash_format = "$2y$11$";
            // $salt = "salt22charactersormore";
            // echo "Length: " . strlen($salt);
            // $format_and_salt = $hash_format . $salt;

            // $hash = crypt($password, $format_and_salt);
            // echo "<br>";
            // echo $hash;

            // $hash2 = crypt("secret", $hash);
            // echo "<br>";
            // echo $hash2;

            ?>
                    
		</div>
	</div>

<?php include("../includes/layouts/footer.php"); ?>