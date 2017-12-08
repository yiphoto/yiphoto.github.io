<?php 
//Browser Prefs//
/**
*	Mambo Open Source Version 4.0.12
*	Dynamic portal server and Content managment engine
*	06-01-2003
*
*	Copyright (C) 2000 - 2003 Miro International Pty. Limited
*	Distributed under the terms of the GNU General Public License
*	This software may be used without warranty provided these statements are left
*	intact and a "Powered By Mambo" appears at the bottom of each HTML page.
*	This code is Available at http://sourceforge.net/projects/mambo
*
*	Site Name: Mambo Open Source Version 4.0.12
*	File Name: mod_browser_prefs.php
*	Developer: Robert Castley
*	Date: 15-02-2003
* 	Version #: 4.0.12
*	Comments:
**/

include('language/'.$lang.'/lang_mod_browser_prefs.php');
$content="<a href='javascript:window.external.addFavorite(\"$live_site\", \"$sitename\")'>"._ADD_FAV."</a><br>";
$content.="<a style='behavior:url(#default#homepage)' onClick='setHomePage(\"$live_site\")' href='#'>"._MAKE_HOME."</a><br>";
?>