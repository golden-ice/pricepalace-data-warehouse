<?php
	include('lib/common.php');

	$selectedYear = mysqli_real_escape_string($db, $_REQUEST['top_25']);

	$query = "SELECT a.year, a.city_name, a.state, a.member_ttl, b.store_ttl FROM " .
	"(SELECT YEAR(date) as year, city_name, state, COUNT(member_ID) as member_ttl " .
	"FROM Membership " .
	"LEFT JOIN Store " .
	"ON Membership.store_ID = Store.store_ID " .
	"GROUP BY year, city_name, state " .
	"HAVING year = '$selectedYear') as a " .
	"LEFT JOIN " .
	"(SELECT DISTINCT p.year, p.city_name, p.state, COUNT(p.storeID) as store_ttl FROM " .
	"(SELECT YEAR(date) as year, city_name, state, Store.store_ID as storeID " .
	"FROM Membership " .
	"LEFT JOIN Store " .
	"ON Membership.store_ID = Store.store_ID " .
	"GROUP BY year, city_name, state, Store.store_ID " .
	"HAVING year = '$selectedYear') p " .
	"GROUP BY p.year, p.city_name, p.state) as b " .
	"ON a.year = b.year and a.city_name = b. city_name and a.state = b.state " .
	"ORDER BY a.member_ttl DESC " .
	"LIMIT 25";	
	$result = mysqli_query($db, $query);		
?>

<?php include("lib/header.php"); ?>
		<title>Top 25 Memberships</title>
	</head>
	
	<body>
        <div id="main_container">
		<?php include("lib/menu.php"); ?>
            
			<div class="center_content">
				<div class="center_left">
					<div class="features">  

						<div class="profile_section">
                        	<div class="subtitle">Year：<?php print $selectedYear; ?></div>

							<table border="1">
								<tr>
									<td class="heading">City</td>
									<td class="heading">State</td>
									<td class="heading">Memberships Sold</td>
								</tr>
																
								<?php												
                                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
										
										if ($row['member_ttl'] >= 250) {
											$color = "red";
										} else if ($row['member_ttl'] <= 30) {
											$color = "yellow";
										} else {
											$color = "none";
										}

										print "<tr style='background-color:{$color}'>";

										if ($row['store_ttl'] > 1) {
											$selectedCity = urlencode($row['city_name']);
											$selectedState = urlencode($row['state']);
											print "<td>{$row['city_name']}<a href='Report8_city.php?year=$selectedYear&city=$selectedCity&state=$selectedState'>&nbspdetail</a></td>";
										} else {
											print "<td>{$row['city_name']}</td>";
										}
										print "<td>{$row['state']}</td>";
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