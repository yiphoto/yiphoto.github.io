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
*	File Name: poll.php
*	Original Developers: Danny Younes - danny@miro.com.au
*				Nicole Anderson - nicole@miro.com.au
*	Date: 03-02-2003
* 	Version #: 4.0.12
*	Comments: Function displays selected weblink category and titles from the database.
**/

include('language/'.$lang.'/lang_poll.php');

class poll {
	function pollresult($pollTitle, $last_vote, $first_vote, $voters, $percentInt, $optionText, $count, $sum, $month, $pollID){
		$months = array(_JAN,_FEB,_MAR,_APR,_MAY,_JUN,_JUL,_AUG,_SEP,_OCT,_NOV,_DEC);
			$months_num = array("01","02","03","04","05","06","07","08","09","10","11","12");?>
			<FORM NAME="poll">
			
  <TABLE CELLPADDING='0' CELLSPACING='5' BORDER='0' WIDTH='400' class='newspane'>
    <TR> 
      <TD CLASS='articlehead' COLSPAN="2">&nbsp;&nbsp;<?php echo _POLL_TITLE; ?></TD>
      <td width="1"></td>
    </TR>
    <TR> 
      <TD ALIGN='right' WIDTH="109"><B><?php echo _SURVEY_TITLE; ?></B></TD>
      <TD WIDTH="290"> &nbsp; 
        <?php echo $pollTitle; ?>
      </TD>
      <td></td>
    </TR>
    <TR> 
      <TD align="right"><B><?php echo _NUM_VOTERS; ?></B></TD>
      <TD> &nbsp; 
        <?php echo $voters; ?>
      </TD>
      <td></td>
    </TR>

      <TD ALIGN="right"><B><?php echo _FIRST_VOTE; ?></B></TD>
      <TD> &nbsp; 
        <?php echo $first_vote; ?>
      </TD>
      <td></td>
    </TR>
    <TR> 
      <TD ALIGN="right"><B><?php echo _LAST_VOTE; ?></B></TD>
      <TD> &nbsp; 
        <?php echo $last_vote; ?>
      </TD>
      <td></td>
    </TR>
    <TR> 
      <TD COLSPAN="3" ALIGN="center"> 
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="48">&nbsp;</td>
            <td width="352" align="center">&nbsp;</td>
          </tr>
          <tr> 
            <td align="right"> 
              <p align="left"><?php echo _SEL_MONTH; ?>&nbsp; </p>
            </td>
            <td align="left"> 
              <select name="months" width="200" style="WIDTH:200px" onChange="document.location.href='index.php?option=surveyresult&task=Results&polls=<?php echo $pollID; ?>&month=' + this.options[selectedIndex].value">
                <option value=""><?php echo _ALL_MONTHS; ?></option>
                <?php 	for ($i = 0; $i < count($months); $i++){
						if ($month == $months_num[$i]){?>
                <option value="<?php echo $month; ?>" SELECTED> 
                <?php echo $months[$i]; ?>
                </option>
                <?php 		} else {?>
                <option value="<?php echo $months_num[$i]; ?>"> 
                <?php echo $months[$i]; ?>
                </option>
                <?php 			}
						}?>
              </select>
            </td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td> 
              <table cellpadding="1" cellspacing="0" border="0" WIDTH="100%" class="newspane">
                <tr> 
                  <td> 
                    <table cellpadding="0" cellspacing="0" border="0" WIDTH="350">
                      <?php 	if (count($percentInt) <> 0){
                      	for ($i = 0; $i < count($optionText); $i++){
                      		if ($percentInt[$i] <> ""){
                      			$percentage = $count[$i]/$sum * 100;
                      			$percentage = round($percentage, 2);
								?>
                      <tr> 
                        <td valign="top"><img src="images/polls/Col<?php echo $i+1; ?>M.gif" width="<?php echo $percentInt[$i]/2; ?>" height="15" vspace="5" hspace="0"><img src="images/polls/Col<?php echo $i+1; ?>R.gif" width="10" height="15" vspace="5" hspace="0"><br>
                          <?php echo "$optionText[$i] - $count[$i] ($percentage%)"; ?>
                        </td>
                      </tr>
                      <?php 	} else {?>
                      <tr> 
                        <td valign="top"><img src="images/polls/Col<?php echo $i+1; ?>M.gif" width="3" height="15" vspace="5" hspace="0"><img src="images/polls/Col<?php echo $i+1; ?>R.gif" width="10" height="15" vspace="5" hspace="0"><br>
                          <?php echo "$optionText[$i] - $count[$i] (0%)"; ?>
                        </td>
                        <?php 			}
                        unset($percentage);
                      	}
                      }
					else {?>
                      <tr> 
                        <td valign="bottom"><?php echo _NO_RESULTS; ?></td>
                      </tr>
                      <?php 		
						}?>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </TD>
    </TR>
  </TABLE>
			</FORM>
		<?php }
}
?>