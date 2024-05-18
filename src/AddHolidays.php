<?php

include('lib/common.php');
    
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  
	$date = mysqli_real_escape_string($db, $_POST['date']);
	$holiday_name = mysqli_real_escape_string($db, $_POST['holiday_name']);  
	
	if (empty($date)) {
			array_push($error_msg,  "Please enter a date.");
	} 
	
	if (empty($holiday_name)) {
		array_push($error_msg,  "Please enter a holiday_name.");
	}

	if (!empty($date) && !empty($holiday_name))  { 
		$query = "INSERT INTO Holiday(date, holiday_name) " .
			 	 "VALUES('$date', '$holiday_name')";
		$result = mysqli_query($db, $query);

		// include('lib/show_queries.php');
		
		if ($result  == False) {
			array_push($error_msg,  "INSERT ERROR. Please try an alternative one.<br>");
			//array_push($error_msg,  'Error# '. mysqli_errno($db) . ": " . mysqli_error($db));
		}  

	}
}  //end of if($_POST)

function is_date( $str ) { 
	$stamp = strtotime( $str ); 
	if (!is_numeric($stamp)) { 
		return false; 
	} 
	$month = date( 'm', $stamp ); 
	$day   = date( 'd', $stamp ); 
	$year  = date( 'Y', $stamp ); 
  
	if (checkdate($month, $day, $year)) { 
		return true; 
	} 
	return false; 
} 

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
							<div class="subtitle">Add Holidays</div>   
                            
							<form name="profileform" action="AddHolidays.php" method="post">
								<table>
									<tr>
										<td class="item_label">Date(YYYY-MM-DD)</td>
										<td>
											<input type="text" name="date" value="<?php if ($row['date']) { print $row['date']; } ?>" />										
										</td>
									</tr>
									<tr>
										<td class="item_label">Holiday Name</td>
										<td>
											<input type="text" name="holiday_name" value="<?php if ($row['holiday_name']) { print $row['holiday_name']; } ?>" />	
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