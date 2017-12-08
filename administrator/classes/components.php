<?php 
/**
*	Mambo Open Source Version 4.0.12
*	Dynamic portal server and Content managment engine
*	20-01-2003
*
*	Copyright (C) 2000 - 2003 Miro International Pty. Limited
*	Distributed under the terms of the GNU General Public License
*	This software may be used without warranty provided these statements are left
*	intact and a "Powered By Mambo" appears at the bottom of each HTML page.
*	This code is Available at http://sourceforge.net/projects/mambo
*
*	Site Name: Mambo Open Source Version 4.0.12
*	File Name: components.php
*	Original Developers: Danny Younes - danny@miro.com.au
*				Nicole Anderson - nicole@miro.com.au
*	Date: 20-01-2003
* 	Version #: 4.0.12
*	Comments:
**/

class components {
	function viewcomponents($database, $dbprefix, $componentshtml, $option){
		$query = "SELECT id, title, publish, checked_out, editor, ordering, position, module, access FROM ".$dbprefix."components ORDER BY position, ordering";
		$result = $database->openConnectionWithReturn($query);
		$i = 0;
		while ($row = mysql_fetch_object($result)){
			$id[$i] = $row->id;
			$title[$i] = $row->title;
			$publish[$i] = $row->publish;
			$checkedout[$i] = $row->checked_out;
			$editor[$i] = $row->editor;
			$ordering[$i] = $row->ordering;
			$position[$i] = $row->position;
			$module[$i] = $row->module;
			$access[$i] = $row->access;
			$i++;
		}
		
		/* Get Group Names for IDs */
		for ($g = 0; $g < count($access); $g++){
			$queryG = "SELECT name FROM ".$dbprefix."groups WHERE id='$access[$g]'";
			$resultG = $database->openConnectionWithReturn($queryG);
			while ($rowG = mysql_fetch_object($resultG)){
				$GNameSel[$g] = $rowG->name;
			}
		}
		
		$componentshtml->showComponents($id, $title, $option, $publish, $checkedout, $editor, $ordering, $position, $module, $GNameSel);
	}
	
	function addComponent($database, $dbprefix, $componentshtml, $option, $text_editor){
		$query = "SELECT ordering FROM ".$dbprefix."components WHERE position='left' ORDER BY ordering";
		$result = $database->openConnectionWithReturn($query);
		$i = 0;
		while ($row = mysql_fetch_object($result)){
			$leftorder[$i] = $row->ordering;
			$i++;
		}
		mysql_free_result($result);
		
		$query = "SELECT ordering FROM ".$dbprefix."components WHERE position='right' ORDER BY ordering";
		$result = $database->openConnectionWithReturn($query);
		$i = 0;
		while ($row = mysql_fetch_object($result)){
			$rightorder[$i] = $row->ordering;
			$i++;
		}
		mysql_free_result($result);
		
		/* Get list of groups */
		$queryG = "SELECT id, name FROM ".$dbprefix."groups ORDER BY id";
		$resultG = $database->openConnectionWithReturn($queryG);
		$g = 0;
		while ($rowG = mysql_fetch_object($resultG)){
			$Gid[$g] = $rowG->id;
			$Gname[$g] = $rowG->name;
			$g++;
		}
		
		$componentshtml->addComponent($leftorder, $rightorder, $option, $text_editor, $Gid, $Gname);
	}
	
	function saveComponent($database, $dbprefix, $title, $content, $position, $order, $access){
		if (($title == "") || ($content == "")){
			print "<SCRIPT> alert('Please complete the Title and Content fields'); window.history.go(-1); </SCRIPT>\n";
			exit();
		}
		
		$query = "SELECT title FROM ".$dbprefix."components WHERE title='$title'";
		$result = $database->openConnectionWithReturn($query);
		$num = mysql_num_rows($result);
		if ($num > 0){
			print "<SCRIPT> alert('There is a component already with that title, please try again!'); window.history.go(-1); </SCRIPT>\n";
		}
		
		$query = "INSERT INTO ".$dbprefix."components SET title='$title', position='$position', ordering='$order', checked_out_time='00:00:00', publish='no', access='$access'";
		$database->openConnectionNoReturn($query);
		
		$query = "SELECT ordering, id, title FROM ".$dbprefix."components WHERE ordering >= '$order' AND position='$position' ORDER BY ordering";
		$result = $database->openConnectionWithReturn($query);
		$numItems = mysql_num_rows($result);
		for ($i = 0; $i < $numItems; $i++){
			list($ordering, $id, $titleComponent) = mysql_fetch_row($result);
			if ($titleComponent <> $title){
				$ordering++;
				$query = "UPDATE ".$dbprefix."components SET ordering='$ordering' WHERE id='$id'";
				$database->openConnectionNoReturn($query);
			}
		}
		
		$query = "SELECT id FROM ".$dbprefix."components WHERE title='$title'";
		
		$result = $database->openConnectionWithReturn($query);
		while($row = mysql_fetch_object($result)){
			$id = $row->id;
		}
		
		mysql_free_result($result);
		
		$query = "INSERT INTO ".$dbprefix."component_module SET content='$content', componentid='$id'";
		$database->openConnectionNoReturn($query);
		
		$query = "SELECT MAX(id) AS maximum FROM ".$dbprefix."components";
		$result = $database->openConnectionWithReturn($query);
		while ($row = mysql_fetch_object($result)){
			$max = $row->maximum;
		}
			?>
			<SCRIPT>document.location.href="index2.php?option=Components"</SCRIPT>
			<?php }
			
		function editComponent($componentshtml, $database, $dbprefix, $option, $componentid, $myname, $text_editor){
			if ($componentid == ""){
				print "<SCRIPT> alert('Select a component to edit'); window.history.go(-1);</SCRIPT>\n";
				}
			
			$query = "SELECT title, checked_out, editor FROM ".$dbprefix."components WHERE id='$componentid'";
			$result = $database->openConnectionWithReturn($query);
			while ($row = mysql_fetch_object($result)){
				$checked = $row->checked_out;
				$title = $row->title;
				$editor = $row->editor;
				}
			$stringcmp = strcmp($editor,$myname);
			if (($checked == 1) && ($stringcmp <> 0)){
				print "<SCRIPT>alert('The component $title is currently being edited by another administrator'); document.location.href='index2.php?option=$option'</SCRIPT>\n";
				exit(0);
				} 
			
			$date = date("H:i:s");
			$query = "UPDATE ".$dbprefix."components SET checked_out='1', checked_out_time='$date', editor='$myname' WHERE id='$componentid'";
			$database->openConnectionNoReturn($query);
				
			$query = "SELECT ordering FROM ".$dbprefix."components WHERE position='left' ORDER BY ordering";
			$result = $database->openConnectionWithReturn($query);
			$i = 0;
			while ($row = mysql_fetch_object($result)){
				$leftorder[$i] = $row->ordering;
				$i++;
				}
			mysql_free_result($result);
			
			$query = "SELECT ordering FROM ".$dbprefix."components WHERE position='right' ORDER BY ordering";
			$result = $database->openConnectionWithReturn($query);
			$i = 0;
			while ($row = mysql_fetch_object($result)){
				$rightorder[$i] = $row->ordering;
				$i++;
				}
			mysql_free_result($result);
			
			$query = "SELECT ordering, title, position, module FROM ".$dbprefix."components WHERE id='$componentid'";
			$result = $database->openConnectionWithReturn($query);
			while ($row = mysql_fetch_object($result)){
				$ordering = $row->ordering;
				$title = $row->title;
				$position = $row->position;
				$module = $row->module;
				
				if ($module == ""){
					$query2 = "SELECT content FROM ".$dbprefix."component_module WHERE componentid='$componentid'";
					$result2 = $database->openConnectionWithReturn($query2);
					while ($row2 = mysql_fetch_object($result2)){
						$content = $row2->content;
						}
					}
				}
			
			/* Get list of groups */	
			$queryG = "SELECT id, name FROM ".$dbprefix."groups ORDER BY id";
			$resultG = $database->openConnectionWithReturn($queryG);
			$g = 0;
			while ($rowG = mysql_fetch_object($resultG)){
			$Gid[$g] = $rowG->id;
			$Gname[$g] = $rowG->name;
			$g++;
			}			
			
			/* Get currently applied group */
			$queryG = "SELECT access FROM ".$dbprefix."components WHERE id=$componentid";
			$resultG = $database->openConnectionWithReturn($queryG);
			$i = 0;
			while ($rowG = mysql_fetch_object($resultG)){
			  $GIDSel[$i] = $rowG->access;		
			}
			
			$componentshtml->editComponent($componentid, $title, $content, $position, $option, $leftorder, $rightorder, $ordering, $module, $text_editor, $Gid, $Gname, $GIDSel);
			}
			
		function saveeditcomponent($html, $database, $dbprefix, $title, $content, $position, $show, $componentid, $order, $original, $myname, $module, $access){
			if (($title == "") || (($content == "") && (!isset($module)))){
				print "<SCRIPT> alert('Please complete the title and content fields'); window.history.go(-1); </SCRIPT>\n";
				}
				
			if ($show == ""){
				$show = "false";
				}
			else {
				$show = "true";
				}
			
			$query = "SELECT * FROM ".$dbprefix."components WHERE id='$componentid' AND checked_out=1 AND editor='$myname'";
			$result = $database->openConnectionWithReturn($query);
			if (mysql_num_rows($result) > 0){
				if ($original < $order){
					$query = "SELECT id, ordering FROM ".$dbprefix."components WHERE ordering>='$original' AND ordering<='$order' AND position='$position' ORDER BY ordering ";
					$result = $database->openConnectionWithReturn($query);
					$i = 0;
					while ($row = mysql_fetch_object($result)){
						$id[$i] = $row->id;
						$changeorder[$i] = $row->ordering;
						$i++;
						}
					}
				elseif ($original > $order){
					$query = "SELECT id, ordering FROM ".$dbprefix."components WHERE ordering<'$original' AND ordering>='$order' AND position='$position' ORDER BY ordering";
					$result = $database->openConnectionWithReturn($query);
					$i = 0;
					while ($row = mysql_fetch_object($result)){
						$id[$i] = $row->id;
						$changeorder[$i] = $row->ordering;
						$i++;
						}
					}
				
					
				if ($original < $order){
					for ($i = 0; $i < count($id); $i++){
						$query = "UPDATE ".$dbprefix."components SET ordering=ordering-1 WHERE id='$id[$i]'";
						$database->openConnectionNoReturn($query);
						}
					}
				elseif ($original > $order){
					for ($i = 0; $i < count($id); $i++){
						$query = "UPDATE ".$dbprefix."components SET ordering=ordering+1 WHERE id='$id[$i]'";
						$database->openConnectionNoReturn($query);
						}
					}
	
				$query = "UPDATE ".$dbprefix."components SET title='$title', position='$position', ordering='$order', checked_out=0, checked_out_time='00:00:00', editor=NULL, access='$access' WHERE id='$componentid'";
				$database->openConnectionNoReturn($query);

				$query = "UPDATE ".$dbprefix."component_module SET content='$content' WHERE componentid=$componentid";
				$database->openConnectionNoReturn($query);

				?>
				<SCRIPT>document.location.href="index2.php?option=Components"</SCRIPT>
				<?php 
	}
	else {
		print "<SCRIPT>alert('Your job has timed out, too bad'); document.location.href='index2.php?option=$option'</SCRIPT>\n";
	}
}

function removecomponent($database, $dbprefix, $option, $cid){
	if (count($cid) == 0){
		print "<SCRIPT> alert('Select a component to delete'); window.history.go(-1);</SCRIPT>\n";
	}
	
	$query = "SELECT id, checked_out FROM ".$dbprefix."components WHERE id='$cid[0]'";
	$result = $database->openConnectionWithReturn($query);
	while ($row = mysql_fetch_object($result)){
		$id = $row->id;
		$checked = $row->checked_out;
	}
	
	if ($checked == 1){
		print "<SCRIPT>alert('This component cannot be deleted because it is being edited by another administrator'); document.location.href='index2.php?option=$option';</SCRIPT>\n";
		exit(0);
	} elseif ($id <= 9){
		print "<SCRIPT>alert('This component cannot be deleted because it is a Mambo component'); document.location.href='index2.php?option=$option';</SCRIPT>\n";
		exit(0);
	}
	
	for ($i = 0; $i < count($cid); $i++){
		$query = "SELECT position FROM ".$dbprefix."components WHERE id='$cid[$i]'";
		$result = $database->openConnectionWithReturn($query);
		list($deleteposition)=mysql_fetch_array($result);
		
		$query = "DELETE FROM ".$dbprefix."components WHERE id='$cid[$i]'";
		$database->openConnectionNoReturn($query);
		$query = "DELETE FROM ".$dbprefix."component_module WHERE componentid='$cid[$i]'";
		$database->openConnectionNoReturn($query);
		
		
		if ($deleteposition=="right"){
			$query = "SELECT id FROM ".$dbprefix."components WHERE position='right' ORDER BY ordering";
			$result = $database->openConnectionWithReturn($query);
			$b = 1;
			while ($row = mysql_fetch_object($result)){
				$query = "UPDATE ".$dbprefix."components SET ordering='$b' WHERE id='$row->id'";
				$database->openConnectionNoReturn($query);
				$b++;
			}
		}else{
			$query = "SELECT id FROM ".$dbprefix."components WHERE position='left' ORDER BY ordering";
			$result = $database->openConnectionWithReturn($query);
			$b = 1;
			while ($row = mysql_fetch_object($result)){
				$query = "UPDATE ".$dbprefix."components SET ordering='$b' WHERE id='$row->id'";
				$database->openConnectionNoReturn($query);
				$b++;
			}
		}
	}
	print "<SCRIPT>document.location.href='index2.php?option=$option';</SCRIPT>\n";
}

function publishComponent($database, $dbprefix, $option, $cid, $componentid, $title, $content, $position, $order, $original){
	if (count($cid) > 0){
		$query = "SELECT checked_out, editor FROM ".$dbprefix."components WHERE id='$cid[0]'";
		$result = $database->openConnectionWithReturn($query);
		while ($row = mysql_fetch_object($result)){
			$checked = $row->checked_out;
			$editor = $row->editor;
		}
		
		if ($checked == 1){
			print "<SCRIPT>alert('This component cannot be unpublished because it is being edited by $editor'); document.location.href='index2.php?option=$option';</SCRIPT>\n";
			exit(0);
		}
		
		for ($i = 0; $i < count($cid); $i++){
			$query = "UPDATE ".$dbprefix."components SET publish='1' WHERE id='$cid[$i]'";
			$database->openConnectionNoReturn($query);
		}
	}
	elseif (isset($componentid)){
		if ($original < $order){
			$query = "SELECT id, ordering FROM ".$dbprefix."components WHERE ordering>='$original' AND ordering<='$order' AND position='$position' ORDER BY ordering ";
			$result = $database->openConnectionWithReturn($query);
			$i = 0;
			while ($row = mysql_fetch_object($result)){
				$id[$i] = $row->id;
				$changeorder[$i] = $row->ordering;
				$i++;
			}
		}
		elseif ($original > $order){
			$query = "SELECT id, ordering FROM ".$dbprefix."components WHERE ordering<'$original' AND ordering>='$order' AND position='$position' ORDER BY ordering";
			$result = $database->openConnectionWithReturn($query);
			$i = 0;
			while ($row = mysql_fetch_object($result)){
				$id[$i] = $row->id;
				$changeorder[$i] = $row->ordering;
				$i++;
			}
		}
		
		
		if ($original < $order){
			for ($i = 0; $i < count($id); $i++){
				$query = "UPDATE ".$dbprefix."components SET ordering=ordering-1 WHERE id='$id[$i]'";
				$database->openConnectionNoReturn($query);
			}
		}
		elseif ($original > $order){
			for ($i = 0; $i < count($id); $i++){
				$query = "UPDATE ".$dbprefix."components SET ordering=ordering+1 WHERE id='$id[$i]'";
				$database->openConnectionNoReturn($query);
			}
		}
		
		$query = "UPDATE ".$dbprefix."components SET publish='1', editor=NULL, checked_out=0, checked_out_time='00:00:00', title='$title', ordering='$order' WHERE id='$componentid'";
		$database->openConnectionNoReturn($query);
	}
	else {
		print "<SCRIPT> alert('Select a component to publish'); window.history.go(-1);</SCRIPT>\n";
	}
	print "<SCRIPT>document.location.href='index2.php?option=$option';</SCRIPT>\n";
}

function unpublishComponent($database, $dbprefix, $option, $componentid, $cid){
	if (count($cid) > 0){
		$query = "SELECT checked_out FROM ".$dbprefix."components WHERE id='$cid[0]'";
		$result = $database->openConnectionWithReturn($query);
		while ($row = mysql_fetch_object($result)){
			$checked = $row->checked_out;
		}
		
		if ($checked == 1){
			print "<SCRIPT>alert('This component cannot be unpublished because it is being edited by another administrator'); document.location.href='index2.php?option=$option';</SCRIPT>\n";
			exit(0);
		}
		
		for ($i = 0; $i < count($cid); $i++){
			$query = "UPDATE ".$dbprefix."components SET publish='0' WHERE id='$cid[$i]'";
			$database->openConnectionNoReturn($query);
		}
	}
	elseif (isset($componentid)) {
		$query = "UPDATE ".$dbprefix."components SET publish='0' WHERE id='$componentid'";
		$database->openConnectionNoReturn($query);
		
		$query = "UPDATE ".$dbprefix."components SET editor=NULL, checked_out=0, checked_out_time='00:00:00'";
		$database->openConnectionNoReturn($query);
	}
	else {
		print "<SCRIPT> alert('Select a component to unpublish'); window.history.go(-1);</SCRIPT>\n";
		exit(0);
	}
	print "<SCRIPT>document.location.href='index2.php?option=$option';</SCRIPT>\n";
}
}
?>
