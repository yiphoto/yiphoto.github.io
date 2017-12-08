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
		
		
		
		<title>New Brand</title>
	</head>
	

	<body>
		<h3 align="center">New Brand</h3><br>
		<form action="addbrand.php" method="post" name="New Brand">
			<table width="336" cellspacing="2" cellpadding="0" STYLE="border-width: 0;"> 
				<tr height="18" STYLE="border-width: 0;">
					<td width="150" height="18" STYLE="border-width: 0;">
						<div align="left">
							<b>Add Brand:</b></div>
					</td>
					<td width="175" height="18" STYLE="border-width: 0;"><input type="text" name="Brand" size="28"></td>
					
				</tr>
			</table>
			<p><input type="submit" name="Add Brand" value="Add Brand"></p>
		</form>
		<p></p>
	</body>

</html>
<?php 
ob_end_flush(); 
?> 