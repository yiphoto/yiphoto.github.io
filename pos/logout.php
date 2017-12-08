<? 
ob_start();
session_start();
$_SESSION ['Name'] = '';
header("Location: login.php");
ob_end_flush();
?>