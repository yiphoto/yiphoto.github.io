<? include ("../login/session.php"); 
include ("../settings.php");
include ("../authorization/items.php");
?>
<HTML>
<head>
<LINK REL=stylesheet HREF="../stylesheets/stylesheet.php" TYPE="text/css"> 
<title>PHP Point Of Sale</title>
</head>
<body bgcolor="#FFFFFF" leftmargin="3" topmargin="3" marginwidth="3" marginheight="3" >
<h3 align="center">Items</h3><br>
		<ul>
			<li><a href="newitem.php">Create A New Item</a>
			<li><a href="manageitems.php">Manage Items</a>
			
			
			<ul>
			<br>
			<li><a href="brands/newbrand.php">Add Brands</a>
			<li><a href="brands/managebrands.php">Manage Brands</a>
			
			<ul>
			<br>
			
			<li><a href="categories/newcategory.php">Add Categories</a>
			<li><a href="categories/managecategories.php">Manage Categories</a>
		</ul>
	</body>
</HTML>
<? include ("../login/obend.php"); ?>