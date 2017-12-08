<?php 
/**
*	Mambo Open Source Version 4.0.12
*	Dynamic portal server and Content managment engine
*	03-02-2003
*
*	Copyright (C) 2000 - 2003 Miro International Pty. Limited
*	Distributed under the terms of the GNU General Public License
*	This software may be used without warranty provided these statements are left
*	intact and a "Powered By Mambo" appears at the bottom of each HTML page.
*	This code is Available at http://sourceforge.net/projects/mambo
*
*	Site Name: Mambo Open Source Version 4.0.12
*	File Name: gallery.php
*	Original Developers: Danny Younes - danny@miro.com.au
*				Nicole Anderson - nicole@miro.com.au
*	Date: 03-02-2003
* 	Version #: 4.0.12
*	Comments:
**/
?>
<html>
<head>
	<title>Mambo Open Source - Image Gallery</title>
<!-- frames -->
<FRAMESET  ROWS="88%,*">
    <FRAMESET  COLS="18%,*">
        <FRAME NAME="navigation" SRC="navigation.php?directory=<?php echo $directory;?>&Itemid=<?php echo $Itemid;?>" MARGINWIDTH="0" MARGINHEIGHT="0" SCROLLING="no" FRAMEBORDER="0" NORESIZE>
        <FRAME NAME="images" SRC="index.php?directory=<?php echo $directory;?>&Itemid=<?php echo $Itemid;?>" MARGINWIDTH="0" MARGINHEIGHT="0" SCROLLING="auto" FRAMEBORDER="0">
    </FRAMESET>
    <FRAME NAME="imagecode" SRC="imagecode.php" MARGINWIDTH="0" MARGINHEIGHT="0" SCROLLING="no" FRAMEBORDER="0" NORESIZE>
</FRAMESET>
	
</head>

<body BGCOLOR="#FFFFFF">

</body>
</html>