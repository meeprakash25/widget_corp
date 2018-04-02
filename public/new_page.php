<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php confirm_logged_in() ?>

<?php find_selected_page(); ?>


<?php
//can't add a new page unless we have a subject as a prent!
if (!$current_subject) {
    //subject ID was missing or invalid
    //subject couldn't be found in database
    redirect_to("manage_content.php");
}
?>

<?php 
if (isset($_POST['submit'])) {
    //process the form
    
    //validations
    $required_fields = array("menu_name", "position",  "content","visible");
    validate_presences($required_fields);

    $fields_with_max_lengths = array("menu_name" => 30);
    validate_max_lengths($fields_with_max_lengths);

    // $fields_with_max_lengths = array("content" => 100);
    // validate_max_lengths($fields_with_max_lengths);

    if (empty($errors)) {
        //perform create

        //make sure you add the subject_id!
        $subject_id = (int)$current_subject["id"];
        $menu_name = escape_string($_POST["menu_name"]);
        $position = (int)$_POST["position"];
        $visible = (int)$_POST["visible"];
        $content = escape_string($_POST["content"]);
        
        // 2. Perform database query
        $query  = "INSERT INTO pages (";
        $query .= "subject_id, menu_name, position, visible, content";
        $query .= ") VALUES (";
        $query .= "{$subject_id},'{$menu_name}', {$position}, {$visible}, '{$content}'";
        $query .= ")";
        $result = mysqli_query($connection, $query);
        if ($result && mysqli_affected_rows($connection) >= 0) {
            // Success
            $_SESSION["message"] = "Page created";
            redirect_to("manage_content.php?subject=" . urlencode($current_subject["id"]));
        } else {
            // Failure
            $_SESSION["message"] = "Page creation failed.";
        }
    }
} else {
    //this is probably a get request
} // end of: if (isset($_POST['submit']))
?>
<?php $layout_context = "admin"; ?>
<?php include("../includes/layouts/header.php"); ?>
	<div id="main">
		<div id="navigation">
			<?php echo navigation($current_subject, $current_page); ?>
		</div>
		<div id="page">
            <?php echo message(); ?>
			<?php echo form_errors($errors); ?>
			<h2>Create Page</h2>
			<form action="new_page.php?subject=<?php echo urldecode($current_subject["id"]); ?>" method="post">
                <p>Menu name: <input type="text" name="menu_name" value="">
                </p>
                
                <p>Position: <select name="position">
                                    <?php 
                                        $page_set = find_pages_for_subject($current_subject["id"], false);
                                        $page_count = mysqli_num_rows($page_set);
                                        for ($count = 1; $count <= $page_count + 1; $count++) {
                                            echo "<option value=\"$count\">$count</option>";
                                        }
									?>
								</select>
				</p>
				
				<p>Visible: 
                            <input type="radio" name="visible" value="0"/>No
							 &nbsp;
							 <input type="radio" name="visible" value="1"/>Yes
                </p>
                <p>Content: <br>
                            <textarea type="text" name="content" id="content" cols="80" rows="8"></textarea>
                </p>
				<input type="submit" name="submit" value="Create Page">				
			</form>
			<br>
            <a href="manage_content.php?subject=<?php echo urlencode($current_subject["id"]); ?>">Cancel</a>
		</div>
	</div>

<?php include("../includes/layouts/footer.php"); ?>