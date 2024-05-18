<?php

include('lib/common.php');
    
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  
	$city_name = mysqli_real_escape_string($db, $_POST['city_name']);
	$state = mysqli_real_escape_string($db, $_POST['state']);  
	$population = mysqli_real_escape_string($db, $_POST['population'] + 0); 

	if (empty($city_name)) {
		array_push($error_msg,  "Please enter a city name.");
	} 
	
	if (empty($state)) {
		array_push($state,  "Please enter a state name.");
	} 

	if (empty($population)) {
		array_push($error_msg,  "Please enter a new population.");
	} else if ($population < 0) {
		array_push($error_msg,  "Population should be above 0.");
	}

	if (!empty($city_name) && !empty($state)  && ($population > 0))  { 
		$query = "UPDATE City " .
				 "SET population = $population " .
			 	 "WHERE city_name = '$city_name'and state = '$state'";
		$result = mysqli_query($db, $query);
		
		if (mysqli_affected_rows($db) > 0) {
			array_push($error_msg,  "Update Success.");
		}  else {
			array_push($error_msg,  "Update ERROR. Please try again.<br>");
		}

		include('lib/show_queries.php');

	}
}  //end of if($_POST)
?>

<?php include("lib/header.php"); ?>
		<title>Add Holidays</title>
	</head>
	
	<body>
    	<div id="main_container">
        <?php include("lib/menu.php"); ?>
    
			<div class="center_content">	
				<div class="center_left">        
					<div class="features">   
						
                        <div class="profile_section">
							<div class="subtitle">Update Populations</div>   
                            
							<form name="profileform" action="UpdatePopulations.php" method="post">
								<table>
									<tr>
										<td class="item_label">City</td>
										<td>
											<input type="text" name="city_name" value="<?php if ($row['city_name']) { print $row['city_name']; } ?>" />										
										</td>
									</tr>
									<tr>
										<td class="item_label">State (2-letter abbr.)</td>
										<td>
											<input type="text" name="state" value="<?php if ($row['state']) { print $row['state']; } ?>" />	
										</td>
									</tr>
									<tr>
										<td class="item_label">Population</td>
										<td>
											<input type="text" name="population" value="<?php if ($row['population']) { print $row['population']; } ?>" />	
										</td>
									</tr>
								</table>
								
								<a href="javascript:profileform.submit();" class="fancy_button">Save</a> 
							
							</form>
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