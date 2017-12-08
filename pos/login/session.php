<? 
ob_start();
session_start();
if(!$_SESSION ['Name'])
{
	header("Location: ../login.php");
	exit;
}

?>

