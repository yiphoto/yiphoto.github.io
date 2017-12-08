<?
include ("../login/session.php");
include ("../settings.php");
include ("../authorization/general.php");
?>


<html>

	<head>
		
		<title>Update PHP Point Of Sale</title>
	</head>

	<body>
		<p></p>
		<form action="changesettings.php" method="post" name="Installer">
			<div align="center">
				<font color=<? echo $hcolor ?>><h3>Php Point of Sale Updater</h3></font>
			</div>
			<p>*Indicates a requried field</p>
			<table width="527" border="0" cellspacing="2" cellpadding="0">
				<caption>
					<div align="left">
						<i><font size="2">Setup Information:</font></i></div>
				</caption>
				<tr>
					<td><b>Company Name:*</b></td>
					<td width="325"><input type="text" name="company" value="<? echo $company; ?>" size="35"></td>
				</tr>
				<tr>
					<td><b>Address:</b></td>
					<td width="325"><input type="text" name="address" value="<? echo $address; ?>" size="52"></td>
				</tr>
				<tr>
					<td><b>Phone:*</b></td>
					<td width="325"><input type="text" name="phone" value="<? echo $phone; ?>" size="24"></td>
				</tr>
				<tr>
					<td><b>E-Mail</b></td>
					<td width="325"><input type="text" name="email" value="<? echo $email; ?>" size="24"></td>
				</tr>
				<tr>
					<td><b>Datebase Host:*</b></td>
					<td width="325"><input type="text" name="server" value="<? echo $server; ?>" size="24"></td>
				</tr>
				<tr>
					<td><b>Database Name:*</b></td>
					<td width="325"><input type="text" name="database" value="<? echo $database; ?>" size="24"></td>
				</tr>
				<tr>
					<td><b>Username:*</b></td>
					<td width="325"><input type="text" name="username" value="<? echo $username; ?>" size="24"></td>
				</tr>
				<tr>
					<td><b>Password:*</b></td>
					<td width="325"><input type="password" name="password" value="<? echo $password; ?>" size="24"></td>
				</tr>
			</table>
			<br>
			<table width="550" border="0" cellspacing="2" cellpadding="0">
				<caption>
					<div align="left">
						<i><font size="2">Color Settings:</font></i></div>
				</caption>
				<tr>
					<td>
						<div align="center">
							<b><font color="#ff0033">Tables</font></b></div>
					</td>
					<td width="325"></td>
				</tr>
				<tr>
					<td><b>Background Color:*</b></td>
					<td width="325"><select name="backgroundcolor" size="1">
							<option selected value="<? echo $backgroundcolor ;?>"><? echo $backgroundcolor ;?></option>
							<option value="Aqua">Aqua</option>
							<option value="Black">Black</option>
							<option value="Blue">Blue</option>
							<option value="Fuchsia">Fuchsia</option>
							<option value="Grey">Grey</option>
							<option value="Green">Green</option>
							<option value="Lime">Lime</option>
							<option value="Maroon">Maroon</option>
							<option value="Navy">Navy</option>
							<option value="Olive">Olive</option>
							<option value="Purple">Purple</option>
							<option value="Red">Red</option>
							<option value="Silver">Silver</option>
							<option value="Teal">Teal</option>
							<option value="White">White</option>
							<option value="Yellow">Yellow</option>
						</select></td>
				</tr>
				<tr>
					<td><b>Border width (in pixels):*</b></td>
					<td width="325"><input type="text" name="borderwidth" value="<? echo $borderwidth; ?>" size="8"></td>
				</tr>
				<tr>
					<td><b>Border Style:*</b></td>
					<td width="325"><select name="borderstyle" size="1">
							<option selected value="<? echo $borderstyle ;?>"><? echo $borderstyle ;?></option>
							<option value="dotted">Dotted</option>
							<option value="dashed">Dashed</option>
							<option value="solid">Solid</option>
							<option value="double">Double</option>
							<option value="grove">Grove</option>
							<option value="ridge">Ridge</option>
							<option value="inset">Inset</option>
							<option value="outset">Outset</option>
							<option value="none">None</option>
						</select></td>
				</tr>
				<tr>
					<td><b>Text Color:*</b></td>
					<td width="325"><select name="textcolor" size="1">
							<option selected value="<? echo $textcolor ;?>"><? echo $textcolor ;?></option>
							<option value="Aqua">Aqua</option>
							<option value="Black">Black</option>
							<option value="Blue">Blue</option>
							<option value="Fuchsia">Fuchsia</option>
							<option value="Grey">Grey</option>
							<option value="Green">Green</option>
							<option value="Lime">Lime</option>
							<option value="Maroon">Maroon</option>
							<option value="Navy">Navy</option>
							<option value="Olive">Olive</option>
							<option value="Purple">Purple</option>
							<option value="Red">Red</option>
							<option value="Silver">Silver</option>
							<option value="Teal">Teal</option>
							<option value="White">White</option>
							<option value="Yellow">Yellow</option>
						</select></td>
				</tr>
				<tr>
					<td><b>Alternate Table Row Color:*</b></td>
					<td width="325"><select name="rowcolor" size="1">
							<option selected value="<? echo $rowcolor ;?>"><? echo $rowcolor ;?></option>
							<option value="D1CDF0">Light Purple</option>
							<option value="DFDFDF">Light Grey</option>
							<option value="EDBDAA">Light Red</option>
							<option value="AAAAAA">Grey</option>
							<option value="Lime">Lime</option>
								<option value="FFFFFF">White</option>
						</select></td>
				</tr>
				<tr>
					<td></td>
					<td width="325"></td>
				</tr>
				<tr>
					<td></td>
					<td width="325"></td>
				</tr>
				<tr>
					<td>
						<div align="center">
							<b><font color="#ff0033">Links and Paragraphs</font></b></div>
					</td>
					<td width="325"></td>
				</tr>
				<tr>
					<td><b>Active Link Color:*</b></td>
					<td width="325"><select name="alink" size="1">
							<option selected value="<? echo $alink ;?>"><? echo $alink ;?></option>
							<option value="Aqua">Aqua</option>
							<option value="Black">Black</option>
							<option value="Blue">Blue</option>
							<option value="Fuchsia">Fuchsia</option>
							<option value="Grey">Grey</option>
							<option value="Green">Green</option>
							<option value="Lime">Lime</option>
							<option value="Maroon">Maroon</option>
							<option value="Navy">Navy</option>
							<option value="Olive">Olive</option>
							<option value="Purple">Purple</option>
							<option value="Red">Red</option>
							<option value="Silver">Silver</option>
							<option value="Teal">Teal</option>
							<option value="White">White</option>
							<option value="Yellow">Yellow</option>
						</select></td>
				</tr>
				<tr>
					<td><b>Visited Link Color:*</b></td>
					<td width="325"><select name="vlink" size="1">
						<option selected value="<? echo $vlink ;?>"><? echo $vlink ;?></option>
							<option value="Aqua">Aqua</option>
							<option value="Black">Black</option>
							<option value="Blue">Blue</option>
							<option value="Fuchsia">Fuchsia</option>
							<option value="Grey">Grey</option>
							<option value="Green">Green</option>
							<option value="Lime">Lime</option>
							<option value="Maroon">Maroon</option>
							<option value="Navy">Navy</option>
							<option value="Olive">Olive</option>
							<option value="Purple">Purple</option>
							<option value="Red">Red</option>
							<option value="Silver">Silver</option>
							<option value="Teal">Teal</option>
							<option value="White">White</option>
							<option value="Yellow">Yellow</option>
						</select></td>
				</tr>
				<tr>
				<tr>
					<td><b>Heading Color:*</b></td>
					<td width="325"><select name="hcolor" size="1">
							<option selected value="<? echo $hcolor ;?>"><? echo $hcolor ;?></option>
							<option value="Aqua">Aqua</option>
							<option value="Black">Black</option>
							<option value="Blue">Blue</option>
							<option value="Fuchsia">Fuchsia</option>
							<option value="Grey">Grey</option>
							<option value="Green">Green</option>
							<option value="Lime">Lime</option>
							<option value="Maroon">Maroon</option>
							<option value="Navy">Navy</option>
							<option value="Olive">Olive</option>
							<option value="Purple">Purple</option>
							<option value="Red">Red</option>
							<option value="Silver">Silver</option>
							<option value="Teal">Teal</option>
							<option value="White">White</option>
							<option value="Yellow">Yellow</option>
						</select></td>
				</tr>
					<td><b>Paragraph Color:*</b></td>
					<td width="325"><select name="pcolor" size="1">
							<option selected value="<? echo $pcolor ;?>"><? echo $pcolor ;?></option>
							<option value="Aqua">Aqua</option>
							<option value="Black">Black</option>
							<option value="Blue">Blue</option>
							<option value="Fuchsia">Fuchsia</option>
							<option value="Grey">Grey</option>
							<option value="Green">Green</option>
							<option value="Lime">Lime</option>
							<option value="Maroon">Maroon</option>
							<option value="Navy">Navy</option>
							<option value="Olive">Olive</option>
							<option value="Purple">Purple</option>
							<option value="Red">Red</option>
							<option value="Silver">Silver</option>
							<option value="Teal">Teal</option>
							<option value="White">White</option>
							<option value="Yellow">Yellow</option>
						</select></td>
				</tr>
				<tr>
				<td><b>Contextual Menu?*</b></td>
				<? if($menu=="set")
				{
				?>
				 <td width="325"><input type="checkbox" checked name="ContextualMenu" value="set" ></td>
				 <?
				}
				 else
				 {
				 ?>
				 <td width="325"><input type="checkbox" name="ContextualMenu" value="set" ></td>
				 <?
				 }
				 ?>
				</tr>
			</table>
			<p></p>
			<p><input type="submit" name="Update" value="Update"><input type="reset"></p>
		</form>
		<p></p>
	</body>

</html>
<? include ("../login/obend.php"); ?>