<?php require_once("includes/DB.php"); ?>
<?php require_once("includes/Function.php"); ?>
<?php require_once("includes/Sessions.php"); ?>
<?php 
$_SESSION["TrakingURL"] =  $_SERVER["PHP_SELF"];
Confirm_Login(); ?>
<?php 
if (isset($_GET['id'])) {
	$SearchQueryParametr = $_GET['id'];
	global $ConnectingDB;
	$Admin = $_SESSION["AdminName"];
	$sql = "UPDATE comments SET status='OFF', approvedby='$Admin' WHERE id='$SearchQueryParametr'";
	$Execuet = $ConnectingDB->query($sql);
	if ($Execuet) {
		$_SESSION['SuccessMessage'] = "Comment Dis-Approved Successfully !";
		Redirect_to("Comments.php");
	}else {
		$_SESSION['ErrorMessage'] = "Something Went Wrong. Try Agane!";
		Redirect_to("Comments.php");
	}
}

 ?>