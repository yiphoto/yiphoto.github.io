import java.awt.*;
import java.awt.event.*;
import java.applet.*;
import java.net.*;    
import javax.swing.*;
import java.io.*;


public class MenuBar extends JApplet implements ActionListener
{
    JMenuBar navigate;
	JMenu file,items,customers,reports,brands,categories,options,sale;
	JMenuItem home,logout,
	newCustomer,manageCustomers,
	newItem,manageItems,Brands,Categories,newBrand,manageBrands,newCategory,manageCategories,
	brandReport,categoryReport,cumulativeReport,customerReport,dailyReport,dateReport,detailedReport,employeeReport,itemReport,taxReport,totalReport,
	changeSettings,newUser,manageUsers,
	newSale;
	
	
	String usertype;
	
	public void init() 
	{
		usertype=getParameter("usertype");
		resize(600,20);
		
		//Create Menu
		file=new JMenu("File");
		customers=new JMenu("Customers");
		items=new JMenu("Items");
		reports=new JMenu("Reports");
		options=new JMenu("Options");
		sale=new JMenu("Sales");
		
		//submenu's for Items (Brands & Categories)
		brands=new JMenu("Brands");
		categories=new JMenu("Categories");
		
		//Menu Items for File
		home=new JMenuItem("Home");
		home.addActionListener(this);
		logout=new JMenuItem("Logout");
		logout.addActionListener(this);
		
		//Menu Items for Customers
		newCustomer=new JMenuItem("Create New Customer");
		newCustomer.addActionListener(this);
		manageCustomers=new JMenuItem("Manage Customers");
		manageCustomers.addActionListener(this);
		
		//Menu Items for Items
		newItem=new JMenuItem("Create New Item");
		newItem.addActionListener(this);
		manageItems=new JMenuItem("Manage Items");
		manageItems.addActionListener(this);
		//Submenus Brands and Categories
		Brands=new JMenuItem("Brands");
		Brands.addActionListener(this);
		Categories=new JMenuItem("Categories");
		Categories.addActionListener(this);
		//Menu Items for Brands and Categories
		newBrand=new JMenuItem("New Brand");
		newBrand.addActionListener(this);
		manageBrands=new JMenuItem("Manage Brands");
		manageBrands.addActionListener(this);
		newCategory=new JMenuItem("New Category");
		newCategory.addActionListener(this);
		manageCategories=new JMenuItem("Manage Categories");
		manageCategories.addActionListener(this);
		
		//Menu Items for Reports
		brandReport=new JMenuItem("Brand Report");
		brandReport.addActionListener(this);
		categoryReport=new JMenuItem("Category Report");
		categoryReport.addActionListener(this);
		cumulativeReport=new JMenuItem("Cumulative Report");
		cumulativeReport.addActionListener(this);
		customerReport=new JMenuItem("Customer Report");
		customerReport.addActionListener(this);
		dailyReport=new JMenuItem("Daily Report");
		dailyReport.addActionListener(this);
		dateReport=new JMenuItem("Date Range Report");
		dateReport.addActionListener(this);
		detailedReport=new JMenuItem("Detailed Report");
		detailedReport.addActionListener(this);
		employeeReport=new JMenuItem("Employee Report");
		employeeReport.addActionListener(this);
		itemReport=new JMenuItem("Item Report");
		itemReport.addActionListener(this);
		taxReport=new JMenuItem("Tax Report");
		taxReport.addActionListener(this);
		totalReport=new JMenuItem("Totals Report");
		totalReport.addActionListener(this);
		
		//Menu Items for Options
		changeSettings=new JMenuItem("Change Settings");
		changeSettings.addActionListener(this);
		newUser=new JMenuItem("New User");
		newUser.addActionListener(this);
		manageUsers=new JMenuItem("Manage Users");
		manageUsers.addActionListener(this);
		
		
		//Menu Items for New Sale
		newSale=new JMenuItem("New Sale");
		newSale.addActionListener(this);
		
		
		
		
		
		//Add Menu Items for Menu File
		file.add(home);
		file.add(logout);
		
		//Add Menu Items for Menu Customers
		customers.add(newCustomer);
		customers.add(manageCustomers);
		
		//Add Menu Items for Menu Items
		items.add(newItem);
		items.add(manageItems);
		//Add Menu Items to submenus Brands and Categories
		brands.add(newBrand);
		brands.add(manageBrands);
		categories.add(newCategory);
		categories.add(manageCategories);
		//Add Submenus to Menu Items
		items.add(brands);
		items.add(categories);
		
		//Add Menu Items for Menu Reports
		reports.add(brandReport);
		reports.add(categoryReport);
		reports.add(cumulativeReport);
		reports.add(customerReport);
		reports.add(dailyReport);
		reports.add(dateReport);
		reports.add(detailedReport);
		reports.add(employeeReport);
		reports.add(itemReport);
		reports.add(taxReport);
		reports.add(totalReport);
		
		//Add Menu Items for Menu Options
		options.add(changeSettings);
		options.add(newUser);
		options.add(manageUsers);
		
		//Add Menu Items for Menu New Sale
		sale.add(newSale);
	
		
		
		
		//Create Menu Bar.
		navigate=new JMenuBar();

		navigate.setPreferredSize(new Dimension(600, 20));
		
		navigate.add(file);
		if(usertype.equals("Admin"))
		{
			navigate.add(customers);
			navigate.add(items);
		}
		if(usertype.equals("Admin") || usertype.equals("Report Viewer"))
		{
			navigate.add(reports);
		}
        	if(usertype.equals("Admin"))
		{
			navigate.add(options);
		}
		if(usertype.equals("Sales Clerk") || usertype.equals("Admin"))
		{
			navigate.add(sale);
		}
		setJMenuBar(navigate);
	}
        
      public void actionPerformed(ActionEvent event)
      {
      	/*
      	Fowards user to correct page based on what the user selects from the menu
      	*/
          String urlText="";
          
          	if(event.getSource()==home)
        	{
         	  	urlText="home.php";
         	  
         	}
         	else if(event.getSource()==logout)
      	 	{
      		
      			if(0==JOptionPane.showConfirmDialog(null,"Are you sure you would like to logout?","Logout",JOptionPane.OK_CANCEL_OPTION,JOptionPane.QUESTION_MESSAGE))
      			{
      				urlText="logout.php";
      			}
      			
      		 }
      		else if(event.getSource()==newCustomer)
      		{
      			urlText="customers/newcustomer.php";
      		
      		}
      		else if(event.getSource()==manageCustomers)
      		{
      			urlText="customers/managecustomers.php";
      		
      		}
      		else if(event.getSource()==newItem)
      		{
      			urlText="items/newitem.php";
      		
      		}  
      		else if(event.getSource()==manageItems)
      		{
      			urlText="items/manageitems.php";
      		
      		}
      		else if(event.getSource()==newBrand)
      		{
      			urlText="items/brands/newbrand.php";
      		
      		}
      		else if(event.getSource()==manageBrands)
      		{
      			urlText="items/brands/managebrands.php";
      		
      		}
      		else if(event.getSource()==newCategory)
      		{
      			urlText="items/categories/newcategory.php";
      		
      		}
      		else if(event.getSource()==manageCategories)
      		{
      			urlText="items/categories/managecategories.php";
      		
      		}
      		else if(event.getSource()==brandReport)
      		{
      			urlText="reports/brand.php";
      		
      		}
      		else if(event.getSource()==categoryReport)
      		{
      			urlText="reports/category.php";
      		
      		}
      		else if(event.getSource()==cumulativeReport)
      		{
      			urlText="reports/cumulative.php";
      		
      		}
      		else if(event.getSource()==customerReport)
      		{
      			urlText="reports/customer.php";
      		
      		}
      		else if(event.getSource()==dailyReport)
      		{
      			urlText="reports/daily.php";
      		
      		}
      		else if(event.getSource()==dateReport)
      		{
      			urlText="reports/selectdaterange.php";
      		
      		}
      		else if(event.getSource()==detailedReport)
      		{
      			urlText="reports/detailed.php";
      		
      		}
      		else if(event.getSource()==employeeReport)
      		{
      			urlText="reports/employee.php";
      		
      		}
      		else if(event.getSource()==itemReport)
      		{
      			urlText="reports/item.php";
      		
      		}
      		else if(event.getSource()==taxReport)
      		{
      			urlText="reports/tax.php";
      		
      		}
      		else if(event.getSource()==totalReport)
      		{
      			urlText="reports/totals.php";
      		
      		}
      		else if(event.getSource()==changeSettings)
      		{
      			urlText="settings/index.php";
      		
      		}
      		else if(event.getSource()==newUser)
      		{
      			urlText="users/newuser.php";
      		
      		}
      		else if(event.getSource()==manageUsers)
      		{
      			urlText="users/manageusers.php";
      		
      		}
      		else if(event.getSource()==newSale)
      		{
      			urlText="sales/index.php";
      		
      		}
      		
      		       
         	
      		
  
         	
      	String baseURL=getParameter("domain");
  		String totalURL=baseURL+urlText;
  		   
            try 
            {  
            	 URL url = new URL(totalURL);
            	  
                if(urlText!="")
                {
                  
                    if(urlText=="logout.php")
                    {
                    	getAppletContext().showDocument(url,"_parent");
                    }
                    else
                    {
                    	
                    	getAppletContext().showDocument(url,"MainFrame");
                    
                    }
                    
                }
            } 
            catch(MalformedURLException me)
            {
            
            }
      
    }
}
