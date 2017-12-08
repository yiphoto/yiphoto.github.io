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
*	File Name: contacthtml.php
*	Original Developers: Danny Younes - danny@miro.com.au
*				Nicole Anderson - nicole@miro.com.au
*	Date: 03-02-2003
* 	Version #: 4.0.12
*	Comments: Function displays selected weblink category and titles from the database.
**/

include_once('language/'.$lang.'/lang_contact.php' );

class contact {
		function contactpage($id, $companyname, $ACN, $address, $suburb, $state, $country, $postcode, $telephone, $fax, $email_to, $absolute_path, $lang, $sitename){?>
				<SCRIPT LANGUAGE='JAVASCRIPT'>
				<!--
				
				function validate(){
					if ((document.emailForm.from.value=='') || (document.emailForm.text.value=='') || (document.emailForm.name.value=='')){
						alert("<?php echo _CONTACT_FORM_NC; ?>");
						}
					else {
						document.emailForm.action = 'contact.php'
						document.emailForm.submit();
						}
					}
				//-->
				</SCRIPT>
				
<TABLE CELLPADDING='0' CELLSPACING='0' BORDER='0' WIDTH='100%' class="newspane" align="center">
  <TR> 
    <TD WIDTH='100%'> 
      <TABLE CELLPADDING='0' CELLSPACING='5' BORDER='0' WIDTH='100%'>
        <TR> 
          <TD CLASS='articlehead'><?php echo(_CONTACT_TITLE);?></TD>
        </TR>
        <?php if (trim($companyname)!=""){?>
        <TR> 
          <TD> 
            <?php echo $companyname;?>
          </TD>
        </TR>
        <?php }
		if (trim($ACN)!=""){?>
        <TR> 
          <TD> 
            <?php echo $ACN;?>
          </TD>
        </TR>
        <?php }
		if (trim($address)!=""){?>
        <TR> 
          <TD> 
            <?php echo $address;?>
          </TD>
        </TR>
        <?php }
		if ((trim($suburb)!="") || (trim($state)!="") || (trim($postcode)!="")){?>
        <TR> 
          <TD> 
            <?php echo "$suburb $state $postcode";?>
          </TD>
        </TR>
        <?php }
		if (trim($country)!=""){?>
        <TR> 
          <TD> 
            <?php echo $country;?>
          </TD>
        </TR>
        <?php }
		if (trim($telephone)!=""){?>
		<TR>
          <TD><?php echo (_TELEPHONE);
            	echo $telephone;
		?>
          </TD>
        </TR>
        <?php }
		if (trim($fax)!=""){?>
        <TR>
          <TD><?php echo (_FACSIMILE);
            	echo $fax;
		?>
          </TD>
        </TR>
        <?php }?>
        <TR> 
          <TD>&nbsp;</TD>
        </TR>
        <FORM NAME='emailForm' ACTION='contact.php' TARGET=_top METHOD='POST'>
          <TR> 
            <TD WIDTH='100%'><?php echo(_NAME_PROMPT);?><BR>
              <INPUT TYPE='text' NAME='name' SIZE='30' class="inputbox" VALUE=''>
            </TD>
          </TR>
          <TR> 
            <TD WIDTH='100%'><?php echo(_EMAIL_PROMPT);?><BR>
              <INPUT TYPE='text' NAME='from' SIZE='30' class="inputbox" VALUE=''>
            </TD>
          </TR>
          <TR> 
            <TD WIDTH='100%'><?php echo(_MESSAGE_PROMPT);?></TD>
          </TR>
          <TR> 
            <TD valign='top'> 
              <TEXTAREA COLS='45' ROWS='8' NAME='text' class="inputbox" wrap="VIRTUAL"></TEXTAREA>
            </TD>
          </TR>
          <TR> 
            <TD HEIGHT='20' VALIGN='bottom'> 
              <INPUT TYPE="hidden" NAME="email_to" value="<?php echo $email_to;?>">
							<INPUT TYPE="hidden" NAME="lang" value="<?php echo $lang; ?>">
							<INPUT TYPE="hidden" NAME="absolute_path" value="<?php echo $absolute_path; ?>">
							<INPUT TYPE="hidden" NAME="sitename" value="<?php echo $sitename; ?>">
              <INPUT TYPE="hidden" NAME="op" value="sendmail">
              <INPUT TYPE='button' NAME='send' VALUE='<?php echo(_SEND_BUTTON); ?>' class="button" onClick='validate()'>
            </TD>
          </TR>
        </FORM>
      </TABLE>
    </TD>
  </TR>
</TABLE>
				<?php }
		}
?>
