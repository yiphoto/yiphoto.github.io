<?php 
//Mambo userlist//

/**
*    Users List Module for Mambo Open Source Version 4.0
*    Dynamic portal server and Content managment engine
*    24-12-2002
*
*    Copyright (C) 2002 Emir Sakic
*    Distributed under the terms of the GNU General Public License
*    This software may be used without warranty provided these statements are left intact.
*
*    Site Name: Mambo Open Source Version 4.0
*    File Name: com_userlist.php
*    Original Developers: Emir Sakic - saka@hotmail.com
*    Date: 24/12/2002
*    Version #: 1.5
*    Comments:
**/

/* SET YOUR VARIABLES HERE */
$rows_per_page = 30;                // set how many rows per page you want displayed
$pages_in_list = 10;                // set how many pages you want displayed in the menu
$email_displayed = 0;                // set this value to 1 if you want users emails to be displayed

$color1 = "#CCCCCC";                // table style colors
$color2 = "#DDDDDD";
$color3 = "#E8E8E8";

$query_string_def = "option=com_userlist";    // set your query string (after "?" in address field)

// Translation can be done here
$has_str = "has";
$reg_users_str = "registrated users";
$javascr_search_alert_str = "Please enter a value to search!";
$search_str = "Find User";
$enter_email_str = "Enter users Email, Name or Username";
$enter_name_str = "Enter users Name or Username";
$search_button_str = "Search";
$show_all_str = "Show All Users";
$you_searched_email_str = "You searched by Email";
$results_found_str = "results found";
$id_num_str = "id#";
$name_str = "Name";
$username_str = "Username";
$email_str = "Email";
$secret_str = "secret";
$you_searched_name_str = "You searched by Name";
$page_str = "Page";

/* NO CHANGES BELOW THIS LINE (unless you know what you are doing) */
$version = "1.5";                    // script version
?>

<!-- Users List Mambo Module by Emir Sakic, http://www.sakic.net-->

<style>
<!--
td.class1 { font: 7.5pt Verdana, Arial, Helvetica, sans-serif; background: <?php echo $color1;?>; }
td.class2 { font: 7.5pt Verdana, Arial, Helvetica, sans-serif; background: <?php echo $color2;?>; }
td.class3 { font: 7.5pt Verdana, Arial, Helvetica, sans-serif; background: <?php echo $color3;?>; }
.list { font: 7.5pt Verdana, Arial, Helvetica, sans-serif; }
a.list:link { color: #000000; font-size: 7.5pt; text-decoration: underline; }
a.list:visited { color: #000000; font-size: 7.5pt; text-decoration: underline; }
a.list:active { color: #000000; font-size: 7.5pt; text-decoration: underline; }
a.list:hover { color: #999999; font-size: 7.5pt; text-decoration: none; }
input.list { color:#000000; background-color: white; border: 1px solid #000000; font-size:7.5pt; font-family: Verdana, Arial, Helvetica, sans-serif; }
-->
</style>
<?php 
// Performing SQL query
$query="SELECT id FROM ".$dbprefix."users";
$result=$database->openConnectionWithReturn($query);

// Make sure that we recieved some data from our query
$num_of_rows = mysql_num_rows ($result) or die ("The query: '$query' did not return any data");

print "<table width=100%>
    <tr>
        <td align=\"center\" class=\"class1\">
            <b>$sitename $has_str: $num_of_rows $reg_users_str</b></td>
    </tr>\n";

if ($action=="search") {?>
<script language="JavaScript">
<!--
function validate(){
    if ((document.form.search=="") || (document.form.search.value=="")){
        alert('<?php echo $javascr_search_alert_str;?>');
        return false;
        }
    else {
        return true;
        }
    }
//-->
</script>
<table width=100%>
  <tr>
    <td align=center class="class1"><table><tr><td class="class1"><b><?php echo $search_str;?></b></td></tr></table></td>
  </tr>
  <tr>
    <td align=center class="class2"><br>
      <form name="form" method="post" action="<?php echo $PHP_SELF,"?",$query_string_def;?>&action=search" onSubmit="return validate()">
        <table border="0" cellspacing="1" cellpadding="1">
          <tr>
            <?php if ($email_displayed) {?>
            <td align="right"><?php echo $enter_email_str;?>:&nbsp;</td>
            <?php } else {?>
            <td align="right"><?php echo $enter_name_str;?>:&nbsp;</td>
            <?php }?>
            <td>
              <input type="text" name="search" maxlength="100" class="list">
            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>
              <input type="submit" name="Submit" value="<?php echo $search_button_str;?>" class="list">
            </td>
          </tr>
        </table>
      </form>
    </td>
  </tr>
  <tr>
    <td align=center class="class1"><b><a href="<?php echo $PHP_SELF,"?",$query_string_def;?>" class="list"><?php echo $show_all_str;?></a></b></td>
  </tr>
</table>
<span class="list"><br></span>
<SCRIPT LANGUAGE="JavaScript">
<!--
document.form.search.select();
document.form.search.focus();
//-->
</SCRIPT>
    <?php 
if (isset($search)){
	$query = "SELECT * FROM ".$dbprefix."users WHERE email='$search'";
	$result = mysql_query($query) or die("Search failed");
	
	// Check if search for # returned any data
	$num_of_rows = mysql_num_rows ($result);
	
	if ($num_of_rows && $email_displayed) {
		
		// Display the results in HTML
		print "<table width=100%>
    <tr>
        <td align=center colspan=4 class=\"class1\">$you_searched_email_str: <b>$search</b>. <b>$num_of_rows</b> $results_found_str.</td>
    </tr>\n";
		
		print "\t<tr>\n";
		print "\t\t<td align=center class=\"class1\"><b>$id_num_str</b></td>\n";
		print "\t\t<td align=center class=\"class1\"><b>$name_str</b></td>\n";
		print "\t\t<td align=center class=\"class1\"><b>$username_str</b></td>\n";
		print "\t\t<td align=center class=\"class1\"><b>$email_str</b></td>\n";
		print "\t</tr>\n";
		// Use mysql_fetch_row to retrieve the results
		for ($count = 1; $row = mysql_fetch_row ($result); ++$count)
		{
			print "\t<tr>\n";
			$evenodd = $count % 2;
			if ($evenodd == 0) {
				$cclass = "class2";
			} else {
				$cclass = "class3";
			}
			print "\t\t<td width=\"3%\" align=\"right\" class=\"$cclass\">$row[0]</td>\n";
			print "\t\t<td width=\"29%\" class=\"$cclass\">$row[1]</td>\n";
			print "\t\t<td width=\"29%\" class=\"$cclass\">$row[2]</td>\n";
			if ($email_displayed) {
				print "\t\t<td width=\"29%\" class=\"$cclass\"><a href=mailto:$row[3] class=\"list\">$row[3]</a></td>\n";
			} else {
				print "\t\t<td width=\"29%\" class=\"$cclass\">$secret_str</td>\n";
			}
			print "\t</tr>\n";
			print "\t</table>\n";
		}//end for
		
	} else {
		
		// Query string
		$query = "SELECT * FROM ".$dbprefix."users ORDER BY name";
		
		// Performing SQL query
		$result = mysql_query($query) or die("Query failed");
		
		// Make sure that we recieved some data from our query
		$num_of_rows = mysql_num_rows ($result) or die ("The query: '$query' did not return any data");
		
		// Display the results in HTML
		print "<table width=100%>
    <tr>
        <td align=center colspan=4 class=\"class1\">$you_searched_name_str: <b>$search</b></td>
    </tr>\n";
		
		print "\t<tr>\n";
		print "\t\t<td align=center width=\"6%\" class=\"class1\"><b>$id_num_str</b></td>\n";
		print "\t\t<td align=center width=\"34%\" class=\"class1\"><b>$name_str</b></td>\n";
		print "\t\t<td align=center width=\"30%\" class=\"class1\"><b>$username_str</b></td>\n";
		print "\t\t<td align=center width=\"30%\" class=\"class1\"><b>$email_str</b></td>\n";
		print "\t</tr>\n";
		// Use mysql_fetch_row to retrieve the results
		$rowcount = 0;
		for ($count = 1; $row = mysql_fetch_row ($result); ++$count)
		{
			$occured = stristr($row[1], $search);    // case insensitive
			$occured2 = stristr($row[2], $search);    // case insensitive
			if ($occured || $occured2) {
				$rowcount++;
				$evenodd = $rowcount % 2;
				print "\t<tr>\n";
				if ($evenodd == 0) {
					$cclass = "class2";
				} else {
					$cclass = "class3";
				}
				print "\t\t<td align=\"right\" class=\"$cclass\">$row[0]</td>\n";
				print "\t\t<td class=\"$cclass\">$row[1]</td>\n";
				print "\t\t<td class=\"$cclass\">$row[2]</td>\n";
				if ($email_displayed) {
					print "\t\t<td class=\"$cclass\"><a href=mailto:$row[3] class=\"list\">$row[3]</a></td>\n";
				} else {
					print "\t\t<td align=\"center\" class=\"$cclass\">$secret_str</td>\n";
				}
				print "\t</tr>\n";
			}
		}//end for
		print "</table>\n";
	}
	
}

} else {
	
	print "<tr>
    <td align=\"center\" class=\"class1\"><table><tr><td><a href=\"$PHP_SELF?$query_string_def&action=search\" class=\"list\"><b>$search_str</b></a></td></tr></table></td>
  </tr>\n";
	
	// Calculate # of pages
	$pages = ceil($num_of_rows / $rows_per_page);
	
	if (empty($action)) $action = 1;
	
	$from = ($action-1) * $rows_per_page;
	
	// Performing SQL query again
	$query = "SELECT * FROM ".$dbprefix."users LIMIT $from, $rows_per_page";
	$result = mysql_query($query)
	or die("Query failed");
	
	print "\t<tr>
        <td align=right width=100% class=\"class3\">$page_str: ";
	
	if (empty($poffset)) $poffset = 0;
	
	$from = $poffset*10;
	
	if (empty($prev)) $prev = 0;
	
	if ($poffset>0) {
		$prev = $poffset-1;
		$prev_action = (($poffset-1)*10)+1;
		print "<a href=\"$PHP_SELF?$query_string_def&action=1&poffset=0\" class=\"list\"><<</a> \n";
		print "<a href=\"$PHP_SELF?$query_string_def&action=$prev_action&poffset=$prev\" class=\"list\"><</a> \n";
	}
	
	for ($i = $from+1; $i <= $from+$pages_in_list; $i++) {
		if (($i-1)<$pages) {
			$poffset = floor(($i-1)/10); //round down
			if ($i == $action) {
				print "<b>$i</b></a> ";
			} else {
				print "<a href=\"$PHP_SELF?$query_string_def&action=$i&poffset=$poffset\" class=\"list\">$i</a> ";
			}
		}
	}
	
	if (($i-1)<$pages) {
		$next = $poffset+1;
		$next_action = $i;
		print " <a href=\"$PHP_SELF?$query_string_def&action=$next_action&poffset=$next\" class=\"list\">></a>\n";
		$max_poffset = floor($pages/$pages_in_list-0.1);
		$max_action = $max_poffset*$pages_in_list + 1;
		print " <a href=\"$PHP_SELF?$query_string_def&action=$max_action&poffset=$max_poffset\" class=\"list\">>></a>";
	}
	
	print "\t\t</td>\n\t</tr>\n</table>\n\n";
	
	print "<table width=100%>\n";
	print "\t<tr>\n";
	print "\t\t<td width=\"6%\" align=center class=\"class1\"><b>#</b></td>\n";
	print "\t\t<td width=\"34%\" align=center class=\"class1\"><b>$name_str</b></td>\n";
	print "\t\t<td width=\"30%\" align=center class=\"class1\"><b>$username_str</b></td>\n";
	print "\t\t<td width=\"30%\" align=center class=\"class1\"><b>$email_str</b></td>\n";
	print "\t</tr>\n";
	// Use mysql_fetch_row to retrieve the results
	for ($count = 1; $row = mysql_fetch_row ($result); ++$count)
	{
		$evenodd = $count % 2;
		if ($evenodd == 0) {
			$cclass = "class2";
		} else {
			$cclass = "class3";
		}
		$nr=($action-1)*$rows_per_page+$count;
		print "\t<tr>\n";
		print "\t\t<td align=right class=\"$cclass\">$nr</td>\n";
		print "\t\t<td class=\"$cclass\">$row[1]</td>\n";
		print "\t\t<td class=\"$cclass\">$row[2]</td>\n";
		if ($email_displayed) {
			print "\t\t<td class=\"$cclass\"><a href=mailto:$row[3] class=\"list\">$row[3]</a></td>\n";
		} else {
			print "\t\t<td align=center class=\"$cclass\">$secret_str</td>\n";
		}
		print "\t</tr>\n";
	}
	print "</table>\n";
}//end else
?>
<p align="center" class="small"><font color="#999999">Users List v<?php echo $version?>. Copyright &copy; 2001-2002 by
<a href="http://www.sakic.net" target=_blank class="list">Saka</a>.</font></p>
<span class="list"><br></span>

<!-- Users List Mambo Module by Emir Sakic, http://www.sakic.net-->