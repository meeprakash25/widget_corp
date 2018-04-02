<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_logged_in() ?>
<?php $layout_context = "admin"; ?>

<?php find_selected_page(); ?>


<?php
$current_page = find_page_by_id($_GET["page"], false);
if (!$current_page) {
    //page ID was missing or invalid
    //page couldn't be found in database
    redirect_to("manage_content.php");
}

$id = $current_page["id"];
$query = "DELETE FROM pages WHERE id = {$id} LIMIT 1";
$result = mysqli_query($connection, $query);

if($result && mysqli_affected_rows($connection) == 1){
    //success
    $_SESSION["message"] = "Page deleted.";
    redirect_to("manage_content.php?subject=" . $current_page["id"]);    
}else{
    //failure
    $_SESSION["message"] = "Subject deletion failed.";
    redirect_to("manage_content.php?subject={$id}");
}

?>