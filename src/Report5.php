<?php

include('lib/common.php');
//include('lib/show_queries.php');
    

?>

<?php include("lib/header.php"); ?>
		<title>Report5: Air Conditioners on Groundhog Day</title>
	</head>
	
	<body>
        <div id="main_container">
		    <?php include("lib/menu.php"); ?>
            
			<div class="center_content">
				<div class="center_left">
					
					<div class="features">   	
						<div class="profile_section">
                        	<div class="subtitle">Report5: Air Conditioners on Groundhog Day</div>   
							<table>
								<tr>
									<td class="heading">Year</td>
                                                                        <td class="heading">Total Units Sold</td>
                                                                        <td class="heading">Units Sold Per Day</td>
                                                                        <td class="heading">Units Sold on Groundhog Day</td>
								</tr>
																
								<?php								
                                    $query = "SELECT a.year, a.air_con_tll, a.units_per_day, b.units_groundhog_day FROM (SELECT year(Sell.date) AS year, sum(Sell.quantity) AS air_con_tll, round(sum(Sell.quantity)/365,2) AS units_per_day FROM Sell
                                    LEFT JOIN ProductBelongsToCategory
                                    ON Sell.PID = ProductBelongsToCategory.PID WHERE category_name = 'Air Conditioner' GROUP BY year) AS a
                                    LEFT JOIN
                                    (SELECT year(Sell.date) AS year, sum(Sell.quantity) AS units_groundhog_day FROM Sell
                                    LEFT JOIN ProductBelongsToCategory
                                    on Sell.PID = ProductBelongsToCategory.PID
                                    WHERE month(Sell.date) = '02' and day(Sell.date)= '02' AND category_name = 'Air Conditioner'
                                    GROUP BY year) AS b
                                    ON a.year = b.year
                                    ORDER BY year";
                                    $result = mysqli_query($db, $query);
                                     if (!empty($result) && (mysqli_num_rows($result) == 0) ) {
                                        array_push($error_msg,  "There is no result.");
                                    }
                                    
                                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                                        print "<tr>";
                                        print "<td>{$row['year']}</td>";
                                        print "<td>{$row['air_con_tll']}</td>";
                                        print "<td>{$row['units_per_day']}</td>";
                                        print "<td>{$row['units_groundhog_day']}</td>";
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
