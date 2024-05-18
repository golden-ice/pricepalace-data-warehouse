<?php include('lib/common.php');

$selectedState = mysqli_real_escape_string($db, $_REQUEST['selectedState']);

// $query = "";
// $result = mysqli_query($db, $query);        

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
                        	<div class="subtitle">State: <?php print $selectedState; ?> </div>          					

            	<table>
                <tr>
                  <td class="item_label">Details for <?php print $selectedState; ?></td>
                </tr>
              <table>
                <tr>
                  <td class="heading">Store ID </td>
                  <td class="heading">Store Address</td>
                  <td class="heading">City Name </td>
                  <td class="heading">Sale Year </td>
                  <td class="heading">Total Revenue ($)</td>
                </tr>
																
								<?php								
                                    $query = "SELECT 
                                    store_ID,
                                    street_address,
                                    city_name,
                                    YEAR(date) AS sale_year,
                                    ROUND(SUM(actual_PID_daily_revenue),2) AS total_revenue
                                    FROM
                                    (SELECT 
                                            store_ID,
                                            street_address,
                                            city_name,
                                            date,
                                            PID,
                                            (quantity * actual_price) AS actual_PID_daily_revenue
                                    FROM
                                        (SELECT DISTINCT
                                            Sell.store_ID,
                                            Store.street_address,
                                            Store.city_name,
                                            Sell.date,
                                            Sell.PID,
                                            quantity,
                                            CASE
                                                WHEN OnSale.discount IS NOT NULL THEN discount
                                                ELSE retail_price
                                            END AS actual_price
                                    FROM
                                        Sell
                                    LEFT JOIN OnSale ON Sell.PID = OnSale.PID
                                        AND Sell.date = OnSale.date
                                    LEFT JOIN Product ON Sell.PID = Product.PID
                                    LEFT JOIN Store ON Sell.store_ID = Store.store_ID
                                    WHERE Store.state = '$selectedState') daily_product_records
                                    GROUP BY store_ID , street_address , city_name , date , PID) product_revenue_per_store_per_date
                                    GROUP BY store_ID , street_address , city_name , YEAR(date)
                                    ORDER BY YEAR(date) ASC , SUM(actual_PID_daily_revenue) DESC";    
                                    $result = mysqli_query($db, $query);
                                    if (!empty($result) && (mysqli_num_rows($result) == 0) ) {
                                         array_push($error_msg,  "There is no result.");
                                    }
                                    
                                    while ($row = mysqli_fetch_array($result)){
                                        print "<tr>";
                                        print "<td>{$row['store_ID']}</td>";
                                        print "<td>{$row['street_address']}</td>";
                                        print "<td>{$row['city_name']}</td>";
                                        print "<td>{$row['sale_year']}</td>";
                                        print "<td>{$row['total_revenue']}</td>";
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