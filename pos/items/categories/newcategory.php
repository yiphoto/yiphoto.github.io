<?
ob_start();
session_start();
if($_SESSION['Name']=='' )
{
	header("Location: ../../login.php");
	exit;
}
include ("../../settings.php");
include ("../../authorization/items.php");

?>


<html>

	<head>
		<LINK REL=stylesheet HREF="../../stylesheets/stylesheet.php" TYPE="text/css"> 
		
		
		<title>New Category</title>
	</head>

	<body>
		<h3 align="center">New Category</h3><br>
		<form action="addcategory.php" method="post" name="New Category">
			<table width="342" cellspacing="2" cellpadding="0" STYLE="border-width: 0;">
				<tr height="18" STYLE="border-width: 0;">
					<td width="156" height="18" STYLE="border-width: 0;">
						<div align="left">
							<b>Add Category:</b></div>
					</td>
					<td width="175" height="18" STYLE="border-width: 0;"><input type="text" name="Category" size="28"></td>
					
				</tr>
			</table>
			<p><input type="submit" name="Add Category" value="Add Category"></p>
		</form>
		<p></p>
	</body>

</html>
<?php 
ob_end_flush(); 
?> 