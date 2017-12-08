<?
include ("../settings.php");
?>

table
{
        background-color: <? echo $backgroundcolor ?>;
        border-width: <?  echo $borderwidth ?>px;
        border-style: <?  echo $borderstyle ?>;
        color: <?  echo $textcolor ?>;
}

tr,td,th 
{ 
	padding: 2px; 
}

a:link { color: <?  echo $alink ?>; }
a:visited { color: <?  echo $vlink ?>; }
p { color: <?    echo $pcolor ?>; }
h1, h2, h3, h4, h5, h6, h7 { color: <?    echo $hcolor ?>; } 