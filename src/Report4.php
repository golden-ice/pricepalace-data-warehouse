<?php include('lib/common.php');
# include('lib/show_queries.php');
?>

<?php include("lib/header.php"); ?>
		<title>Report4: Store Revenue by Year by State</title>
	</head>
	
	<body>
        <div id="main_container">
		    <?php include("lib/menu.php"); ?>
            
			<div class="center_content">
				<div class="center_left">
                                <div class="features">   	
					<div class="profile_section">
                        	<div class="subtitle">Report4: Store Revenue by Year by State</div>   
							<table>
<thead>
<tr>

  <th>State </th>
  <th>Sale Year </th>
  <th>Total Revenue ($)</th>
</tr>
      </thead>
																
								<?php								
                                    $query = "SELECT 
                                    state,
                                    YEAR(date) AS sale_year,
                                    ROUND(SUM(actual_store_daily_revenue),2) AS total_revenue
                                FROM
                                    (SELECT 
                                        state,
                                            store_ID,
                                            date,
                                            SUM(quantity * actual_price) AS actual_store_daily_revenue
                                    FROM
                                        (SELECT DISTINCT
                                        Store.state,
                                            Sell.store_ID,
                                            Sell.date,
                                            Sell.PID,
                                            Sell.quantity,
                                            CASE
                                                WHEN OnSale.discount IS NOT NULL THEN discount
                                                ELSE retail_price
                                            END AS actual_price
                                    FROM
                                        Sell
                                    LEFT JOIN OnSale ON Sell.PID = OnSale.PID
                                        AND Sell.date = OnSale.date
                                    LEFT JOIN Product ON Sell.PID = Product.PID
                                    LEFT JOIN Store ON Sell.store_ID = Store.store_ID) daily_product_records
                                    GROUP BY state , store_ID , date) store_revenue_per_day
                                GROUP BY state , YEAR(date)
                                ORDER BY
                                YEAR(date) ASC,
                                SUM(actual_store_daily_revenue) DESC";
                                    $result = mysqli_query($db, $query);
                                     if (!empty($result) && (mysqli_num_rows($result) == 0) ) {
                                         array_push($error_msg,  "There is no result.");
                                    }
                                    
                                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                                        $selectedState = $row['state'];
                                        print "<tr>";
                                        print "<td><a href='Report4-drill.php?selectedState=$selectedState'>{$row['state']}</a></td>";
                                        // print "<td>{$row['state']}</td>";
                                        print "<td>{$row['sale_year']}</td>";
                                        print "<td>{$row['total_revenue']}</td>";
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