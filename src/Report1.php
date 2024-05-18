<?php
include('lib/common.php');
include('lib/show_queries.php');
?>

<?php include("lib/header.php"); ?>
		<title>Report1: Manufacturer's Product Report</title>
	</head>
	
	<body>
        <div id="main_container">
		    <?php include("lib/menu.php"); ?>
            
			<div class="center_content">
				<div class="center_left">
					<div class="features">   	
						<div class="profile_section">
                        	<div class="subtitle">Report1: Manufacturer's Product Report</div>   
							<table>
								<tr>
                  <td class="heading">Manufacturer Name</td>
                  <td class="heading">Total Number of Products</td>
                  <td class="heading">Average Retail Price ($)</td>
                  <td class="heading">Minimum Retail Price ($)</td>
                  <td class="heading">Maximum Retail Price ($)</td>
								</tr>
																
								<?php								
                                    $query = "SELECT manufacturer_name, COUNT(PID) AS count, round(AVG(retail_price),2) AS average_price, MIN(retail_price) AS min_price, MAX(retail_price) AS max_price FROM Product GROUP BY manufacturer_name ORDER BY average_price DESC LIMIT 100";
                                             
									$result = mysqli_query($db, $query);
									
                                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
										$selectedManufacturerName = $row['manufacturer_name'];
                    print "<tr>";
                    print "<td><a href='Report1-drill.php?selectedManufacturerName=$selectedManufacturerName'>{$row['manufacturer_name']}</a></td>";
                    print "<td>{$row['count']}</td>";
                    print "<td>{$row['average_price']}</td>";
                    print "<td>{$row['min_price']}</td>";
                    print "<td>{$row['max_price']}</td>";
                    print "</tr>";    
						
                                    }									
                                ?>
							</table>						
						</div>	
					 </div> 
				</div> 
                    
				<div class="clear"></div> 
			</div>    

               <?php include("lib/footer.php"); ?>
		 
		</div>
	</body>
</html>