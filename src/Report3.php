<?php include('lib/common.php');

?>

<?php include("lib/header.php"); ?>
		<title>Report3: Actual versus Predicted Revenue for GPS units</title>
	</head>
	
	<body>
        <div id="main_container">
		    <?php include("lib/menu.php"); ?>
            
			<div class="center_content">
				<div class="center_left">
                                <div class="features">   	
					<div class="profile_section">
                        	<div class="subtitle">Report3: Actual versus Predicted Revenue for GPS units</div>   
							<table>
<thead>
<tr>
                  <td class="heading">PID </td>
                  <td class="heading">Product Name </td>
                  <td class="heading">Retail Price ($)</td>
                  <td class="heading">Total Number of Units Sold</td>
                  <td class="heading">Total Number of Units Sold at a Discount</td>
                  <td class="heading">Total Number of Units Sold at a Retail Price</td>
                  <td class="heading">Actual Revenue ($)</td>
                  <td class="heading">Predicted Revenue ($)</td>
                  <td class="heading">Difference between Actual Revenue and Predicted Revenue ($)</td>
</tr>
</thead>
																
								<?php								
                                    $query = "SELECT 
                                    PID,
                                    product_name,
                                    retail_price,
                                    SUM(quantity_sold) AS total_num_units_sold,
                                    SUM(quantity_sold_at_discount) AS total_num_units_sold_at_discount,
                                    SUM(quantity_sold_at_retail_price) AS total_num_units_sold_at_retail_price,
                                    ROUND(SUM(quantity_sold * actual_price),2) AS actual_revenue,
                                    ROUND((SUM(quantity_sold_at_discount)*0.75+SUM(quantity_sold_at_retail_price))*retail_price,2) AS predicted_revenue,
                                    ROUND(SUM(quantity_sold * actual_price) - ((SUM(quantity_sold_at_discount)*0.75+SUM(quantity_sold_at_retail_price))*retail_price),2) AS revenue_diff
                                FROM
                                    (SELECT DISTINCT
                                        Sell.date,
                                            Sell.PID,
                                            Product.product_name,
                                            retail_price,
                                            quantity AS quantity_sold,
                                            CASE
                                                WHEN OnSale.discount IS NOT NULL THEN quantity
                                                ELSE 0
                                            END AS quantity_sold_at_discount,
                                            CASE
                                                WHEN OnSale.discount IS NULL THEN quantity
                                                ELSE 0
                                            END AS quantity_sold_at_retail_price,
                                            CASE
                                                WHEN OnSale.discount IS NOT NULL THEN discount
                                                ELSE retail_price
                                            END AS actual_price
                                    FROM
                                        Sell
                                    LEFT JOIN OnSale ON Sell.PID = OnSale.PID
                                        AND Sell.date = OnSale.date
                                    LEFT JOIN Product ON Sell.PID = Product.PID
                                    WHERE
                                        Product.PID IN (SELECT DISTINCT
                                                PID
                                            FROM
                                                ProductBelongsToCategory
                                            WHERE
                                                category_name = 'GPS')
                                    GROUP BY PID , product_name , date , retail_price , quantity) daily_product_records
                                GROUP BY PID , product_name , retail_price
                                HAVING revenue_diff > 5000
                                    OR revenue_diff < - 5000
                                ORDER BY revenue_diff DESC;";
                                    $result = mysqli_query($db, $query);
								
                                     if (!empty($result) && (mysqli_num_rows($result) == 0) ) {
                                         array_push($error_msg,  "There is no result.");
                                    }
                                    
                                    while ($row = mysqli_fetch_array($result)){
                                        print "<tr>";
                                        print "<td>{$row['PID']}</td>";
                                        print "<td>{$row['product_name']}</td>";
                                        print "<td>{$row['retail_price']}</td>";
                                        print "<td>{$row['total_num_units_sold']}</td>";
                                        print "<td>{$row['total_num_units_sold_at_discount']}</td>";
                                        print "<td>{$row['total_num_units_sold_at_retail_price']}</td>";
                                        print "<td>{$row['actual_revenue']}</td>";
                                        print "<td>{$row['predicted_revenue']}</td>";
                                        print "<td>{$row['revenue_diff']}</td>";
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