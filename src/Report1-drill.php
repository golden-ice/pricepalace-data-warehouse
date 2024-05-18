<?php include('lib/common.php');

$selectedManufacturerName = mysqli_real_escape_string($db, $_REQUEST['selectedManufacturerName']);

$query = "SELECT manufacturer_name, maximum_discount FROM Manufacturer WHERE manufacturer_name = '$selectedManufacturerName'";

$result = mysqli_query($db, $query);

  while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
  $maximum_discount = $row['maximum_discount'];}

?>


<?php include("lib/header.php"); ?>
		<title>Drill-down report</title>
	</head>
	
	<body>
        <div id="main_container">
		    <?php include("lib/menu.php"); ?>
            
			<div class="center_content">
				<div class="center_left">
                                <div class="features">   	
					<div class="profile_section">
                        	<div class="subtitle">Manufacturer: <?php print $selectedManufacturerName; ?>, Maximum Discount: <?php print $maximum_discount; ?> </div>   
	             <table>
                <tr>
                  <td class="item_label">Summary from parent report</td>
                </tr>
               <table>
                <tr>
                  <td class="heading">Manufacturer Name</td>
                  <td class="heading">Total Number of Products</td>
                  <td class="heading">Average Retail Price ($)</td>
                  <td class="heading">Minimum Retail Price ($)</td>
                  <td class="heading">Maximum Retail Price ($)</td>
                </tr>
                                
                <?php               
                                    $query = "SELECT manufacturer_name, COUNT(PID) AS count, round(AVG(retail_price),2) AS average_price, MIN(retail_price) AS min_price, MAX(retail_price) AS max_price FROM Product WHERE manufacturer_name = '$selectedManufacturerName'";
                                             
                                    $result = mysqli_query($db, $query);
                  
                                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                                        print "<tr>";
                                        print "<td>{$row['manufacturer_name']}</td>";
                                        print "<td>{$row['count']}</td>";
                                        print "<td>{$row['average_price']}</td>";
                                        print "<td>{$row['min_price']}</td>";
                                        print "<td>{$row['max_price']}</td>";
                                        print "</tr>";    
            
                                    }                 
                                ?>
              </table>          					

            	<table>
                <tr>
                  <td class="item_label">Details for <?php print $selectedManufacturerName; ?></td>
                </tr>
              <table>
                <tr>
                  <td class="heading">PID</td>
                  <td class="heading">Product Name</td>
                  <td class="heading">Retail Price ($)</td>
                  <td class="heading">Categories</td>
                </tr>
																
								<?php								
                                    $query = "SELECT t1.PID, t1.product_name, t1.retail_price, GROUP_CONCAT(t2.category_name) AS category_name FROM Product t1 LEFT JOIN ProductBelongsToCategory t2 ON t1.PID = t2.PID WHERE t1.manufacturer_name = '$selectedManufacturerName' GROUP BY t1.PID, t1.product_name, t1.retail_price ORDER BY retail_price DESC";    
                                    $result = mysqli_query($db, $query);
                                     if (!empty($result) && (mysqli_num_rows($result) == 0) ) {
                                         array_push($error_msg,  "There is no result.");
                                    }
                                    
                                    while ($row = mysqli_fetch_array($result)){
                                        print "<tr>";
                                        print "<td>{$row['PID']}</td>";
                                        print "<td>{$row['product_name']}</td>";
                                        print "<td>{$row['retail_price']}</td>";
                                        print "<td>{$row['category_name']}</td>";
                                        print "</tr>";		

                                    }									
                                ?>

							</table>	
              <div class="subtitle">
                  <a href="#" onClick="javascript :history.back(-1);">Back</a>
              </div>  					
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