

<html>

	<head>
		
		<title>Install PHP Point Of Sale</title>
	</head>

	<body>
		<form action="makeinstall.php" method="post" name="Installer">
			<div align="center">
				<h2>Php Point of Sale Installer</h2>
			</div>
			<p>*Indicates a requried field</p>
			<table width="527" border="0" cellspacing="2" cellpadding="0">
				<caption>
					<div align="left">
						<i><font size="2">Setup Information:</font></i></div>
				</caption>
				<tr>
					<td><b>Company Name:*</b></td>
					<td width="325"><input type="text" name="company" size="35"></td>
				</tr>
				<tr>
					<td><b>Address:</b></td>
					<td width="325"><input type="text" name="address" size="52"></td>
				</tr>
				<tr>
					<td><b>Phone:*</b></td>
					<td width="325"><input type="text" name="phone" size="24"></td>
				</tr>
				<tr>
					<td><b>E-Mail</b></td>
					<td width="325"><input type="text" name="email" size="24"></td>
				</tr>
				<tr>
					<td><b>Datebase Host:*</b></td>
					<td width="325"><input type="text" name="server" size="24"></td>
				</tr>
				<tr>
					<td><b>Database Name:*</b></td>
					<td width="325"><input type="text" name="database" size="24"></td>
				</tr>
				<tr>
					<td><b>Username:*</b></td>
					<td width="325"><input type="text" name="username" size="24"></td>
				</tr>
				<tr>
					<td><b>Password:*</b></td>
					<td width="325"><input type="password" name="password" size="24"></td>
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
							<option selected value="Silver">Silver</option>
							<option value="Aqua">Aqua</option>
							<option value="Black">Black</option>
							<option value="Blue">Blue</option>
							<option value="Fuchsia">Fuchsia</option>
							<option value="Grey">Grey</option>
							<option value="Green">Green</option>
							<option value="Lime">Lime</option>
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
					<td width="325"><input type="text" name="borderwidth" size="8" value="3"></td>
				</tr>
				<tr>
					<td><b>Border Style:*</b></td>
					<td width="325"><select name="borderstyle" size="1">
							<option selected value="solid">Solid</option>
							<option value="dotted">Dotted</option>
							<option value="dashed">Dashed</option>
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
							<option selected value="Black">Black</option>
							<option value="Aqua">Aqua</option>
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
							<option selected value="#DFDFDF">Light Grey</option>
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
							<option selected value="Blue">Blue</option>
							<option value="Aqua">Aqua</option>
							<option value="Black">Black</option>
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
							<option selected value="Black">Black</option>
							<option value="Aqua">Aqua</option>
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
							<option selected value="Navy">Navy</option>
							<option value="Aqua">Aqua</option>
							<option value="Black">Black</option>
							<option value="Blue">Blue</option>
							<option value="Fuchsia">Fuchsia</option>
							<option value="Grey">Grey</option>
							<option value="Green">Green</option>
							<option value="Lime">Lime</option>
							<option value="Maroon">Maroon</option>
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
							<option selected value="Black">Black</option>
							<option value="Aqua">Aqua</option>
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
				 <td width="325"><input type="checkbox" value="set" name="ContextualMenu"></td>
				</tr>
			</table>
			<p>*Important, when you first login your username is:<b>admin</b> and your password is:<b>pointofsale</b></p>
				 

			<p><input type="submit" name="Install" value="Install"><input type="reset"></p>
		</form>
		<p></p>
	</body>

</html>