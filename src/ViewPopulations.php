<?php
include('lib/common.php');
include('lib/show_queries.php');
?>

<?php include("lib/header.php"); ?>
		<title>View Populations</title>
	</head>
	
	<body>
        <div id="main_container">
		    <?php include("lib/menu.php"); ?>
            
			<div class="center_content">
				<div class="center_left">
					<div class="features">   	
						<div class="profile_section">
                        	<div class="subtitle">View Populations</div>   
							<table>
								<tr>
									<td class="heading">City Name</td>
									<td class="heading">State</td>
									<td class="heading">Population</td>
								</tr>
																
								<?php								
                                    $query = "SELECT city_name, state, population " .
                                             "FROM City " .
                                             "ORDER BY city_name, state";
                                             
									$result = mysqli_query($db, $query);
									
                                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                                        print "<tr>";
										print "<td>{$row['city_name']}</td>";
										print "<td>{$row['state']}</td>";
                                        print "<td>{$row['population']}</td>";
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