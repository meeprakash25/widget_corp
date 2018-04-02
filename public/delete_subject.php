<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_logged_in() ?>
<?php $layout_context = "admin"; ?>

<?php find_selected_page(); ?>


<?php
$current_subject = find_subject_by_id($_GET["subject"], false);
if (!$current_subject) {
    //subject ID was missing or invalid
    //subject couldn't be found in database
    redirect_to("manage_content.php");
}

$pages_set = find_pages_for_subject($current_subject["id"]);
if(mysqli_num_rows($pages_set) > 0){
    //failure
    $_SESSION["message"] = "Can't delete a subject with pages.";
    redirect_to ("manage_content.php?subject={$current_subject["id"]}");

    redirect_to("manage_content.php?subject={$id}");
}

$id = $current_subject["id"];
$query = "DELETE FROM subjects WHERE id = {$id} LIMIT 1";
$result = mysqli_query($connection, $query);

if($result && mysqli_affected_rows($connection) == 1){
    //success
    $_SESSION["message"] = "Subject deleted.";
    redirect_to("manage_content.php");    
}else{
    //failure
    $_SESSION["message"] = "Subject deletion failed.";
    redirect_to("manage_content.php?subject={$id}");
}

?>