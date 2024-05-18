<?php include('lib/common.php');

?>

<?php include("lib/header.php"); ?>
		<title>Report2: Cateogory Report</title>
	</head>
	
	<body>
        <div id="main_container">
		    <?php include("lib/menu.php"); ?>
            
			<div class="center_content">
				<div class="center_left">
                                <div class="features">   	
					<div class="profile_section">
                        	<div class="subtitle">Report2: Cateogory Report</div>   
							<table>
<thead>
<tr>

  <th>Category Name</th>
  <th>Total Number of Products</th>
  <th>Total Number of Manufacturers</th>
  <th>Average Retail Price ($)</th>
</tr>
      </thead>
																
								<?php								
                                    $query = "SELECT ProductBelongsToCategory.category_name, COUNT(ProductBelongsToCategory.PID) AS total_num_products, COUNT(DISTINCT Product.manufacturer_name) AS total_num_manufacturer, round(AVG(Product.retail_price),2) AS average_price FROM Product LEFT JOIN ProductBelongsToCategory ON Product.PID = ProductBelongsToCategory.PID GROUP BY category_name ORDER BY category_name";    
                                    $result = mysqli_query($db, $query);
                                     if (!empty($result) && (mysqli_num_rows($result) == 0) ) {
                                         array_push($error_msg,  "There is no result.");
                                    }
                                    
                                    while ($row = mysqli_fetch_array($result)){
                                        print "<tr>";
                                        print "<td>{$row['category_name']}</td>";
                                        print "<td>{$row['total_num_products']}</td>";
                                        print "<td>{$row['total_num_manufacturer']}</td>";
                                        print "<td>{$row['average_price']}</td>";
                                        print "</tr>";		

                                    }									
                                ?>

							</table>						
						</div>	
					 </div> 
				</div> 
                
                <!-- <?php include("lib/error.php"); ?> -->
                    
				<div class="clear"></div> 
			</div>    

               <?php include("lib/footer.php"); ?>
		 
		</div>
	</body>
</html>