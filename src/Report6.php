<?php

include('lib/common.php');
                       

/* if form was submitted, then execute query to search for friends */
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
	$SelectYear = mysqli_real_escape_string($db, $_POST['Year']);
	$SelectMonth = mysqli_real_escape_string($db, $_POST['Month']);
		
	$query = "SELECT F1.category_name, F1.state, F1.total_quantity FROM
                (SELECT S.state, year(E.date) AS year, Month(E.date) AS month, B.category_name, SUM(E.quantity) AS total_quantity
                 FROM Product P, Sell E, Store S, ProductBelongsToCategory B
                 WHERE P.PID = E.PID AND E.store_ID = S.store_ID AND P.PID = B.PID
                 GROUP BY year, month, B.category_name, S.state) AS F1 INNER JOIN
                (SELECT R.year, R.month, R.category_name, MAX(total_quantity) AS max_quantity FROM
                (SELECT S.state, year(E.date) AS year, Month(E.date) AS month, B.category_name, SUM(E.quantity) AS total_quantity
                 FROM Product P, Sell E, Store S, ProductBelongsToCategory B
                 WHERE P.PID = E.PID AND E.store_ID = S.store_ID AND P.PID = B.PID
                 GROUP BY year, month, B.category_name, S.state) AS R
                 GROUP BY R.year, R.month, R.category_name) AS F2
                 ON F1.year= F2.year AND F1.month = F2.month AND F1.category_name = F2.category_name AND F1.total_quantity = F2.max_quantity
                 WHERE F1.year = '$SelectYear' AND F1.month = '$SelectMonth'
                 ORDER BY F1.category_name";		
    
	$result = mysqli_query($db, $query);
    
    include('lib/show_queries.php');

    if (mysqli_affected_rows($db) == 0) {
        array_push($error_msg,  "There is no match result." );
    }
		
}
?>

<?php include("lib/header.php"); ?>
		<title>View Volume Statistics</title>
	</head>
	
	<body>
    	<div id="main_container">
            <?php include("lib/menu.php"); ?>
			
			<div class="center_content">
				<div class="center_left">        			
					<div class="features">   
						
						<div class="profile_section">						
							<div class="subtitle">Report6: View Volume Statistics</div> 
							
							<form name="searchform" action="Report6.php" method="POST">
								<table>								
									<tr>
										<td class="item_label">Year(YYYY)</td>
										<td><input type="text" name="Year" /></td>
									</tr>
									<tr>
										<td class="item_label">Month(MM)</td>
										<td><input type="text" name="Month" /></td>
									</tr>
									
								</table>
									<a href="javascript:searchform.submit();" class="fancy_button">Search</a> 					
							</form>							
						</div>
						
						<div class='profile_section'>
						<div class='subtitle'>Search Results</div>
						<table>
							<tr>
								<td class='heading'>Category</td>
								<td class='heading'>State</td>
								<td class='heading'>Total_quantity</td>
							</tr>
								<?php
									if (isset($result)) {
										while ($row = mysqli_fetch_array($result)){
											
											print "<tr>";
											print "<td>{$row['category_name']}</td>";
											print "<td>{$row['state']}</td>";
											print "<td>{$row['total_quantity']}</td>";									
											print "</tr>";
										}
									}	?>
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
