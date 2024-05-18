<?php
include('lib/common.php');
include('lib/show_queries.php');
?>

<?php include("lib/header.php"); ?>
		<title>View Holidays</title>
	</head>
	
	<body>
        <div id="main_container">
		    <?php include("lib/menu.php"); ?>
            
			<div class="center_content">
				<div class="center_left">
					<div class="features">   	
						<div class="profile_section">
                        	<div class="subtitle">View Holidays</div>   
							<table>
								<tr>
									<td class="heading">Date</td>
									<td class="heading">Holiday Name</td>
								</tr>
																
								<?php								
                                    $query = "SELECT date, holiday_name " .
                                             "FROM Holiday " .
                                             "ORDER BY date";
                                             
									$result = mysqli_query($db, $query);
									
                                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                                        print "<tr>";
                                        print "<td>{$row['date']}</td>";
                                        print "<td>{$row['holiday_name']}</td>";
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