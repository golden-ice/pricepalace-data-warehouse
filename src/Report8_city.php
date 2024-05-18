<?php
	include('lib/common.php');
	include('lib/show_queries.php');

	$selectedYear = mysqli_real_escape_string($db, $_REQUEST['year']);
	$selectedCity = mysqli_real_escape_string($db, $_REQUEST['city']);
	$selectedState = mysqli_real_escape_string($db, $_REQUEST['state']);

	$query = "SELECT YEAR(date) as year, city_name, state, Store.store_ID, street_address, COUNT(member_ID) as member_ttl  " .
	         "FROM Membership " .
	         "LEFT JOIN Store " .
	         "ON Membership.store_ID = Store.store_ID " .
	         "GROUP BY year, city_name, state, Store.store_ID " .
	         "HAVING year = '$selectedYear' and city_name = '$selectedCity' and state = '$selectedState'";	

	$result = mysqli_query($db, $query);	
	
?>

<?php include("lib/header.php"); ?>
		<title>Memberships by city by store</title>
	</head>
	
	<body>
        <div id="main_container">
		<?php include("lib/menu.php"); ?>
            
			<div class="center_content">
				<div class="center_left">
					<div class="features">  

						<div class="profile_section">
                        	<div class="subtitle">Year：<?php print $selectedYear;?></div>

							<table border="1">
								<tr>
									<td class="heading">City</td>
									<td class="heading">State</td>
									<td class="heading">Store</td>
									<td class="heading">Address</td>
									<td class="heading">Memberships Sold</td>
								</tr>
																
								<?php												
                                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
										print "<td>{$row['city_name']}</td>";
										print "<td>{$row['state']}</td>";
										print "<td>{$row['store_ID']}</td>";
										print "<td>{$row['street_address']}</td>";
										print "<td>{$row['member_ttl']}</td>";
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
                    
				<div class="clear"></div> 
			</div>    

               <?php include("lib/footer.php"); ?>
		 
		</div>
	</body>
</html>