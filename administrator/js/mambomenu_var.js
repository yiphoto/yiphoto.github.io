/******************************************************
*	(c) Ger Versluis 2000 version 9.10 14 October 2002 *
*	You may use this script on non commercial sites.   *
*	For info write to menus@burmees.nl		           *
*	You may remove all comments for faster loading	   *		
*******************************************************/

var NoOffFirstLineMenus=5;
var LowBgColor="#999999";
var HighBgColor="#999999";
var FontLowColor="#FFFFFF";
var FontHighColor="#CCFF00";
var BorderColor="#676767";
var BorderWidthMain=0;
var BorderWidthSub=1;
var BorderBtwnMain=1;
var BorderBtwnSub=0;
var FontFamily="arial, Helvetica, sans-serif";
var FontSize=8;
var FontBold=1;
var FontItalic=0;
var MenuTextCentered="left";
var MenuCentered="left";
var MenuVerticalCentered="top";
var ChildOverlap=.0;
var ChildVerticalOverlap=.0;
var StartTop=2;
var StartLeft=82;
var VerCorrect=0;
var HorCorrect=0;
var LeftPaddng=5;
var TopPaddng=2;
var FirstLineHorizontal=1;
var MenuFramesVertical=1;
var DissapearDelay=1000;
var UnfoldDelay=100;
var TakeOverBgColor=1;
var FirstLineFrame="";
var SecLineFrame="";
var DocTargetFrame="";
var TargetLoc="";
var MenuWrap=1;
var RightToLeft=0;
var BottomUp=0;
var UnfoldsOnClick=0;
var BaseHref="";
var Arrws=['../images/admin/tri.gif',5,10,'../images/M_images/6977transparent.gif',5,10,'../images/admin/trileft.gif',5,10];
var MenuUsesFrames=0;
var RememberStatus=0;
var PartOfWindow=.8;
var BuildOnDemand=0;
//	var MenuSlide="";
var MenuSlide="progid:DXImageTransform.Microsoft.RevealTrans(duration=.5, transition=19)";
//	var MenuSlide="progid:DXImageTransform.Microsoft.GradientWipe(duration=.5, wipeStyle=1)";
//	var MenuShadow="";
var MenuShadow="progid:DXImageTransform.Microsoft.DropShadow(color=#888888, offX=2, offY=2, positive=1)";
//	var MenuShadow="progid:DXImageTransform.Microsoft.Shadow(color=#888888, direction=135, strength=3)";
//	var MenuOpacity="";
var MenuOpacity="progid:DXImageTransform.Microsoft.Alpha(opacity=75)";

function BeforeStart(){return}
function AfterBuild(){return}
function BeforeFirstOpen(){return}
function AfterCloseAll(){return}

Menu1=new Array("Components","","",14,17,90,"","","","","","",-1,-1,-1,"","");
	Menu1_1=new Array("Articles","","",2,18,95,"","","","","","",-1,-1,-1,"","");	
		Menu1_1_1=new Array("View Articles","index2.php?option=Articles","",0,18,120,"","","","","","",-1,-1,-1,"","");
		Menu1_1_2=new Array("View Categories","index2.php?option=Articles&act=categories","",0,18,120,"","","","","","",-1,-1,-1,"","");
	Menu1_2=new Array("Banners","","",2,18,95,"","","","","","",-1,-1,-1,"","");
		Menu1_2_1=new Array("Active Banners","index2.php?option=Current","",0,18,110,"","","","","","",-1,-1,-1,"","");
		Menu1_2_2=new Array("View Clients","index2.php?option=Clients","",0,18,110,"","","","","","",-1,-1,-1,"","");
	Menu1_3=new Array("Contact Details","index2.php?option=contact","",0,18,110,"","","","","","",-1,-1,-1,"","");
	Menu1_4=new Array("FAQ's","","",2,18,95,"","","","","","",-1,-1,-1,"","");
		Menu1_4_1=new Array("View FAQ's","index2.php?option=Faq","",0,18,120,"","","","","","",-1,-1,-1,"","");
		Menu1_4_2=new Array("View Categories","index2.php?option=Faq&act=categories","",0,18,120,"","","","","","",-1,-1,-1,"","");
	Menu1_5=new Array("Main Menu","","",3,17,95,"","","","","","",-1,-1,-1,"","");
		Menu1_5_1=new Array("Top Levels","index2.php?option=MenuSections","",0,18,90,"","","","","","",-1,-1,-1,"","");
		Menu1_5_2=new Array("Sub Levels","index2.php?option=SubSections","",0,18,90,"","","","","","",-1,-1,-1,"","");
		Menu1_5_3=new Array("Install Custom","index2.php?option=component_installer","",0,18,90,"","","","","","",-1,-1,-1,"","");
	Menu1_6=new Array("News","","",2,18,95,"","","","","","",-1,-1,-1,"","");
		Menu1_6_1=new Array("Edit/View News","index2.php?option=News","",0,18,130,"","","","","","",-1,-1,-1,"","");
		Menu1_6_2=new Array("Edit/View Categories","index2.php?option=News&act=categories","",0,18,130,"","","","","","",-1,-1,-1,"","");
	Menu1_7=new Array("News Feeds","","",2,18,95,"","","","","","",-1,-1,-1,"","");
		Menu1_7_1=new Array("Edit/View News Feeds","index2.php?option=newsfeeds","",0,18,130,"","","","","","",-1,-1,-1,"","");
		Menu1_7_2=new Array("Edit/View Categories","index2.php?option=newsfeeds&act=categories","",0,18,130,"","","","","","",-1,-1,-1,"","");
	Menu1_8=new Array("News Flash","index2.php?option=Newsflash","",0,18,95,"","","","","","",-1,-1,-1,"","");
	Menu1_9=new Array("Page Modules","","",2,18,95,"","","","","","",-1,-1,-1,"","");
		Menu1_9_1=new Array("View Modules","index2.php?option=Components","",0,18,130,"","","","","","",-1,-1,-1,"","");
		Menu1_9_2=new Array("Install Modules","index2.php?option=module_installer","",0,18,130,"","","","","","",-1,-1,-1,"","");
	Menu1_10=new Array("Site Preview","javascript:OnClick=window.open('../index.php', '', 'height=480, width=640, resizable=yes, toolbars=no, scrollbars=yes')","",0,18,95,"","","","","","",-1,-1,-1,"","");
	Menu1_11=new Array("Survey/Polls","index2.php?option=Survey","",0,18,95,"","","","","","",-1,-1,-1,"","");
	Menu1_12=new Array("Gallery","javascript:OnClick=window.open('gallery/gallery.php', '', 'height=480, width=700, resizable=yes, toolbars=no, scrollbars=yes')","",0,18,95,"","","","","","",-1,-1,-1,"","");
	Menu1_13=new Array("Web Links","","",2,18,95,"","","","","","",-1,-1,-1,"","");
		Menu1_13_1=new Array("View Web Links","index2.php?option=Weblinks","",0,18,130,"","","","","","",-1,-1,-1,"","");
		Menu1_13_2=new Array("View Categories","index2.php?option=Weblinks&act=categories","",0,18,130,"","","","","","",-1,-1,-1,"","");
	Menu1_14=new Array("Forum","","",2,18,95,"","","","","","",-1,-1,-1,"","");
		Menu1_14_1=new Array("View Threads","index2.php?option=Forums&act=threads","",0,18,130,"","","","","","",-1,-1,-1,"","");   
		Menu1_14_2=new Array("View Forums","index2.php?option=Forums","",0,18,130,"","","","","","",-1,-1,-1,"",""); 

	
Menu2=new Array("System","","",6,17,61,"","","","","","",-1,-1,-1,"","");
	Menu2_1=new Array("Mambo Database","","",7,18,120,"","","","","","",-1,-1,-1,"","");
		Menu2_1_1=new Array("Tables Status", "index2.php?option=databaseAdmin&task=dbStatus","",0,18,120,"","","","","","",-1,-1,-1,"","");
		Menu2_1_2=new Array("Tables Optimize", "index2.php?option=databaseAdmin&task=dbOptimize","",0,18,120,"","","","","","",-1,-1,-1,"","");
		Menu2_1_3=new Array("Tables Analyze", "index2.php?option=databaseAdmin&task=dbAnalyze","",0,18,120,"","","","","","",-1,-1,-1,"","");
		Menu2_1_4=new Array("Tables Check", "index2.php?option=databaseAdmin&task=dbCheck","",0,18,120,"","","","","","",-1,-1,-1,"","");
		Menu2_1_5=new Array("Tables Repair", "index2.php?option=databaseAdmin&task=dbRepair","",0,18,120,"","","","","","",-1,-1,-1,"","");
		Menu2_1_6=new Array("Database Backup", "index2.php?option=databaseAdmin&task=dbBackup","",0,18,120,"","","","","","",-1,-1,-1,"","");
		Menu2_1_7=new Array("Database Restore", "index2.php?option=databaseAdmin&task=dbRestore","",0,18,120,"","","","","","",-1,-1,-1,"","");
	Menu2_2=new Array("Global CheckIn","index2.php?option=global_checkin","",0,18,120,"","","","","","",-1,-1,-1,"","");
	Menu2_3=new Array("phpMyAdmin","index2.php?option=phpMyAdmin","",0,18,120,"","","","","","",-1,-1,-1,"","");
	Menu2_4=new Array("Theme Manager","index2.php?option=systemInfo","",0,18,120,"","","","","","",-1,-1,-1,"","");
	Menu2_5=new Array("Site Statistics","","",2,18,120,"","","","","","",-1,-1,-1,"","");
		Menu2_5_1=new Array("Web Browser","index2.php?option=statistics&task=browser","",0,18,120,"","","","","","",-1,-1,-1,"","");
		Menu2_5_2=new Array("Operating System","index2.php?option=statistics&task=os","",0,18,120,"","","","","","",-1,-1,-1,"","");
	Menu2_6=new Array("Top 10","","",2,18,120,"","","","","","",-1,-1,-1,"","");
		Menu2_6_1=new Array("News Stories", "index2.php?option=top10&task=news","",0,18,120,"","","","","","",-1,-1,-1,"","");
		Menu2_6_2=new Array("Articles", "index2.php?option=top10&task=articles","",0,18,120,"","","","","","",-1,-1,-1,"","");

Menu3=new Array("Users","","",2,17,49,"","","","","","",-1,-1,-1,"","");
	Menu3_1=new Array("Administrators","","",2,18,110,"","","","","","",-1,-1,-1,"","");
		Menu3_1_1=new Array("Add Administrator","index2.php?option=Administrators&task=new","",0,18,125,"","","","","","",-1,-1,-1,"","");
		Menu3_1_2=new Array("View Administrators","index2.php?option=Administrators","",0,18,125,"","","","","","",-1,-1,-1,"","");
	Menu3_2=new Array("Users","","",2,18,110,"","","","","","",-1,-1,-1,"","");
		Menu3_2_1=new Array("Add User","index2.php?option=Users&task=new","",0,18,80,"","","","","","",-1,-1,-1,"","");
		Menu3_2_2=new Array("View Users","index2.php?option=Users","",0,18,80,"","","","","","",-1,-1,-1,"","");

Menu4=new Array("Logout","logout.php","",0,18,60,"","","","","","",-1,-1,-1,"","");

Menu5=new Array("Help","","",1,17,50,"","","","","","",-1,-1,-1,"","");
		Menu5_1=new Array("About","index2.php?option=about","",0,18,110,"","","","","","",-1,-1,-1,"","");