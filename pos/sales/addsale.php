<? include ("../login/session.php");
include ("../settings.php");
include ("../authorization/sales.php"); 
?>

<html>
<head>
<LINK REL=stylesheet HREF="../stylesheets/stylesheet.php" TYPE="text/css"> 
</head>
<body>
<?
//Addes the sale to the database, and puts a date on the order.

$Date=date("Y-m-d");
$counter=$_POST["counter"];
$Name=$_SESSION ['Name'];
$Customer=$_POST["customer"];
echo"<h2 align='center'>$company</h2>";
$db = mysql_connect("$server", "$username", "$password");
mysql_select_db("$database",$db);
$result = mysql_query("SELECT * FROM items ORDER BY ItemName",$db);

echo "<tr><td>Ordered by: $Customer</td></tr>
<table cellspacing='1'>
<th>Item Name</th>
<th>Item ID</th>
<th># Ordered</th>
<th>Price</th>
<th>Total Item Cost</th>";

//Runs as many times as there are items, only adds to DB if $QuantityPurchased >=1    
for($k=0;$k<=$counter;$k++)
{

	$ItemID=$_POST["ItemID$k"];
	$Tax=$_POST["Tax$k"];
	$Quantity=$_POST["Quantity$k"]; 
  	$ID=$_POST["ID$k"]; 
  	$Brand=$_POST["Brand$k"];
  	$Category=$_POST["Category$k"];
	$item=$_POST["item$k"];
	$QuantityPurchased=$_POST["quantity$k"];
	$price=$_POST["price$k"];
	echo"$Price";
	$TotalItemCost=$price*$QuantityPurchased;
	
	
//Checks the tax levels so we can find total tax.

		$TaxTotal=$TotalItemCost*$Tax/100;
		$FinalTax+=$TaxTotal;
		$TaxType="$Tax%";
	$TotalItemCostTax=$TaxTotal+$TotalItemCost;
	$SubTotal+=$TotalItemCost;
	$TaxTotal=number_format($TaxTotal,2, '.', '') ;  
	$TotalItemCost=number_format($TotalItemCost,2, '.', '') ; 
	$TotalItemCostTax=number_format($TotalItemCostTax,2, '.', '') ; 
	$price=number_format($price,2, '.', '') ; 
	
	
	//Adds to Database if $QuantityPurchased<=1 or <0
		if($QuantityPurchased >=1 or $QuantityPurchased < 0)
		{
		
			
			echo"<tr bgcolor='white'><td align='center'>$item</td>
			<td align='center'>$ItemID</td>
			<td align='center'>$QuantityPurchased</td>
			<td align='center'>\$$price</td>
			<td align='center'>\$$TotalItemCost</td></tr>";
			$msg = "Date: $Date\nCustomer: $Customer\nBrand: $Brand\nCategory: $Category\nItems: $item\nPrice: $price\nTotalCost: $TotalItemCostTax\nQuantity: $QuantityPurchased\nTax: $TaxTotal\nTaxType: $TaxType\nSoldBy: $Name;";
			$err = "../errors/error.php";
			$ok = "../errors/ok.php";
			$dbHost = "$server";
			$dbName = "$database";
			$dbUser = "$username";
			$dbPass = "$password";
			$dbTable = "sales";
			$sel = "INSERT INTO $dbTable (Date, Customer,Brand,Category,Items, Price, TotalCost, Quantity, Tax, TaxType, SoldBy) VALUES (\"$Date\",\"$Customer\",\"$Brand\",\"$Category\",\"$item\", \"$price\", \"$TotalItemCostTax\",\"$QuantityPurchased\",\"$TaxTotal\",\"$TaxType\", \"$Name\")";
			$conn = @mysql_connect($dbHost, $dbUser, $dbPass);
			$dbDB = @mysql_select_db($dbName, $conn);
			$result = @mysql_query($sel, $conn);
			$NewQuantity=($Quantity-$QuantityPurchased); 
   			$QUAN = "UPDATE items SET Quantity=\"$NewQuantity\" WHERE ID=$ID"; 
   			$result = @mysql_query($QUAN, $conn); 

	}

}
//Outputs Total Tax, Order Cost, and Company contact information.
$TotalOrderCost=$SubTotal+$FinalTax;
$FinalTax="$".number_format($FinalTax,2, '.', '') ;  
echo "</table>";
echo" <BR>";
$TotalOrderCost="$".number_format($TotalOrderCost,2, '.', '') ;
$SubTotal="$".number_format($SubTotal,2, '.', '') ;
echo"<b>SubTotal: $SubTotal</b><BR>";
echo"<b>Total Tax: $FinalTax</b>";
echo" <BR>";
echo"<b>Total Order Cost: $TotalOrderCost</b><p><p>";

echo"<b>Contact Information:</b><p>";
if($address!="")
{
	echo "Address: $address <br>";

}
if($phone!="")
{
	echo "Phone Number: $phone <br>";

}

if($email!="")
{
	echo "E-mail: $email <br>";

}



?>
</body>
</html>
<? include ("../login/obend.php"); ?>