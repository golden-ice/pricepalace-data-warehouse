<?php
include('lib/common.php');
include('lib/show_queries.php');
?>

<?php include("lib/header.php"); ?>
		<title>Report8: Membership Trends</title>
	</head>
	
	<body>
        <div id="main_container">
		    <?php include("lib/menu.php"); ?>
            
			<div class="center_content">
				<div class="center_left">
					<div class="features">   	
						<div class="profile_section">
                        	<div class="subtitle">Report8: Membership Trends</div>   
							<table border="1">
								<tr>
									<td class="heading">Year</td>
									<td class="heading">Memberships Sold</td>
								</tr>
																
								<?php								
                                    $query = "SELECT YEAR(date) as year, COUNT(member_ID) as member_ttl " .
                                             "FROM Membership " .
											 "GROUP BY year " .
											 "ORDER BY year DESC";
                                             
									$result = mysqli_query($db, $query);
									
                                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
										$selectedYear = urlencode($row['year']);
										print "<tr>";
										print "<td>{$selectedYear}<a href='Report8_top.php?top_25=$selectedYear'>top 25</a>&nbsp<a href='Report8_bot.php?bot_25=$selectedYear'>bot 25</a></td>";
										print "<td>{$row['member_ttl']}</td>";
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