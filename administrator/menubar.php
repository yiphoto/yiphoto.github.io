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
*	File Name: menubar.php
*	Original Developers: Danny Younes - danny@miro.com.au
*				Nicole Anderson - nicole@miro.com.au
*	Date: 03-02-2003
* 	Version #: 4.0.12
*	Comments:
**/
require_once("includes/auth.php");

/* Each browser has its own defined layer i.e. PC => ie & Netscape, MAC => ie & Netscape */
if (phpversion() <= "4.2.1") {
	$browse = getenv("HTTP_USER_AGENT");
} else {
	$browse = $_SERVER['HTTP_USER_AGENT'];
}
/* Is browser Internet Explorer and is it windows based */
	if ((preg_match("/MSIE/i", "$browse")) && (preg_match("/windows/i", "$browse"))){?>
			<DIV ID="menubar" STYLE="position:relative; HEIGHT:65px; TOP:0px; LEFT:0px; WIDTH:100%; z-index:0" >
<?php 		}
/* Is browser Netscape and is it window based */
	elseif ((preg_match("/Mozilla/i", "$browse")) && (preg_match("/windows/i", "$browse"))){?>
			<LAYER ID="menubar" HEIGHT="65" TOP="0" LEFT="0" z-index="0" VISIBILITY="show" WIDTH="100%">
<?php 		}
/* Is browser Internet Explorer and is it MAC based */
	elseif ((preg_match("/MSIE/i", "$browse")) && (preg_match("/mac/i", "$browse"))){?>
			<DIV ID="menubar" STYLE="position:relative; WIDTH:100%;HEIGHT:65px;TOP:0px;LEFT:0px;">
<?php 		}
/* Is browser Netscape and is it MAC based */
	else {?>
			<LAYER ID="menubar" HEIGHT="5" TOP="0" LEFT="0" WIDTH="100%" z-index="0">
<?php 		}

/* Display correct menu bar for chosen menu item */
switch ($option){
	case "Components":
	include("menubar/components.php");
	break;
	case "News":
	if ($act == "categories"){
		include("menubar/category.php");
	}
	else {
		include("menubar/news.php");
	}
	break;
	case "Articles":
	if ($act == "categories"){
		include("menubar/category.php");
	}
	else {
		include("menubar/articles.php");
	}
	break;
	case "Faq":
	if ($act == "categories"){
		include("menubar/category.php");
	}
	else {
		include("menubar/faq.php");
	}
	break;
	case "Newsflash":
	include("menubar/newsflash.php");
	break;
	case "Survey":
	include("menubar/survey.php");
	break;
	case "top10":
	include("menubar/blank.php");
	break;
	case "Weblinks":
	if ($act == "categories"){
		include("menubar/category.php");
	}
	else {
		include("menubar/weblinks.php");
	}
	break;
	case "Current":
	include("menubar/banners.php");
	break;
	case "Finished":
	include("menubar/banners.php");
	break;
	case "Clients":
	include("menubar/bannerClient.php");
	break;
	case "Users":
	include("menubar/users.php");
	break;
	case "Administrators":
	include("menubar/administrators.php");
	break;
	case "MenuSections":
	include("menubar/menusections.php");
	break;
	case "SubSections":
	include("menubar/subsections.php");
	break;
	case "newsfeeds":
	include("menubar/newsfeeds.php");
	break;
	case "contact":
	include("menubar/contact.php");
	break;
	case "systemInfo":
	include("menubar/systemInfo.php");
	break;
	case "Forums":
	if ($act == "threads"){
		include("menubar/threads.php");
	}else {
		include("menubar/forum.php");
	}
	break;
	default:
	include("menubar/blank.php");
		}?>
	
	
	
	<?php if (preg_match("/MSIE/i", "$browse")){?>
		</DIV>
		<?php 
}
	elseif (preg_match("/Mozilla/i", "$browse")){?>
		</LAYER>
		<?php }?>
		
	<?php if (preg_match("/MSIE/i", "$browse")){?>
		<BR>
		<?php 
	}
	elseif (preg_match("/Mozilla/i", "$browse")){?>
		<BR><BR><BR><BR><BR>
		<?php }?>