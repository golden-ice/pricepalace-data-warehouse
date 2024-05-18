<?php

include('lib/common.php');
//include('lib/show_queries.php');
    

?>

<?php include("lib/header.php"); ?>
		<title>View Revenue by Population Statistics</title>
	</head>
	
	<body>
        <div id="main_container">
		    <?php include("lib/menu.php"); ?>
            
			<div class="center_content">
				<div class="center_left">
					
					<div class="features">   	
						<div class="profile_section">
                        	<div class="subtitle">Report7: View Revenue by Population Statistics</div>   
							<table>
								<tr>
									<td class="heading">Year</td>
                                                                        <td class="heading">City_Size</td>
                                                                        <td class="heading">Total Revenue($)</td>
								</tr>
																
								<?php								
                                    $query = "SELECT FF.year, C.city_category, ROUND(SUM(total_revenue),2) AS total_revenue
                                              FROM (SELECT city_name, state,
                                              CASE WHEN population < 3700000 THEN 'Small'
					      WHEN population >= 3700000 AND population <6700000 THEN 'Medium'
						WHEN population >= 6700000 AND population <9000000 THEN 'Large'		      
						ELSE 'ExtraLarge'
						END AS city_category
						FROM City) AS C LEFT JOIN
						(SELECT F.year, F.city_name, F.state, SUM(F.revenue1) AS total_revenue
						FROM
						(SELECT Year(E.date) AS year, E.city_name, E.state, SUM(revenue) AS revenue1
						FROM
						(SELECT R.date, P.PID, retail_price*quantity AS revenue, S.city_name, S.state
						FROM Sell R, Product P, Store S
						WHERE R.PID = P.PID AND S.store_ID = R.store_ID) AS E
						LEFT OUTER JOIN
						OnSale ON E.PID = OnSale.PID AND E.date= OnSale.date
						WHERE discount IS NULL
						GROUP BY Year(date), E.state, E.city_name
						UNION
						(SELECT Year(E.date), E.city_name, E.state, SUM(E.quantity*discount) AS revenue1
						FROM
						(SELECT R.date, P.PID, R.quantity, S.city_name, S.state
						FROM Sell R, Product P, Store S
						WHERE R.PID = P.PID AND S.store_ID = R.store_ID) AS E
						LEFT OUTER JOIN
						OnSale ON E.PID = OnSale.PID AND E.date= OnSale.date
						WHERE discount IS NOT NULL
						GROUP BY Year(date), E.state, E.city_name)) AS F
						GROUP BY F.year, F.state, F.city_name) AS FF
						ON C.city_name = FF.city_name AND C.state = FF.state
						GROUP BY FF.year, C.city_category
						ORDER BY FF.year ASC,
						CASE WHEN C.city_category = 'Small' THEN '1'
						WHEN C.city_category = 'Medium' THEN '2'
						WHEN C.city_category = 'Large' THEN '3'
						ELSE C.city_category END";    
                                    $result = mysqli_query($db, $query);
                                     if (!empty($result) && (mysqli_num_rows($result) == 0) ) {
                                         array_push($error_msg,  "There is no result.");
                                    }
                                    
                                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                                        print "<tr>";
                                        print "<td>{$row['year']}</td>";
                                        print "<td>{$row['city_category']}</td>";
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