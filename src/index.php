<?php include('lib/common.php');?>

<?php include("lib/header.php"); ?>
		<title>Main Menu</title>
	</head>
	
	<body>
        <div id="main_container">
		    <?php include("lib/menu.php"); ?>
            
			<div class="center_content">
				<div class="center_left">
                                <div class="features">   	
					<div class="profile_section">
                        	<div class="subtitle">Main Menu</div>   

 <table>
                <thead>
<tr>


  <th>Total Number of Stores:</th>

</tr>
      </thead>

                        
                <?php               
                                    $query = "SELECT COUNT(store_ID) AS total_num_store
                                    FROM Store";    
                                    $result = mysqli_query($db, $query);
                                     if (!empty($result) && (mysqli_num_rows($result) == 0) ) {
                                         array_push($error_msg,  "There is no result.");
                                    }
                                    
                                    while ($row = mysqli_fetch_array($result)){
                                        print "<tr>";
                                        print "<td>{$row['total_num_store']}</td>";
                                        print "</tr>";              
                                    }                 
                                ?>
                                                              
 
                            </table>    

<table>
                <thead>
<tr>

  <th>Total Number of Manufacturers:</th>

</tr>
      </thead>

                        
                <?php               
                                    $query = "SELECT COUNT(manufacturer_name) AS total_num_manufacturer
                                    FROM Manufacturer";    
                                    $result = mysqli_query($db, $query);
                                     if (!empty($result) && (mysqli_num_rows($result) == 0) ) {
                                         array_push($error_msg,  "There is no result.");
                                    }
                                    
                                    while ($row = mysqli_fetch_array($result)){
                                        print "<tr>";
                                        print "<td>{$row['total_num_manufacturer']}</td>";
                                        print "</tr>";              
                                    }                 
                                ?>
                                                              
 
                            </table>    

 <table>
                <thead>
<tr>

  <th>Total Number of Products:</th>
</tr>
      </thead>

                        
                <?php               
                                    $query = "SELECT COUNT(PID) AS total_num_product
                                    FROM Product";    
                                    $result = mysqli_query($db, $query);
                                     if (!empty($result) && (mysqli_num_rows($result) == 0) ) {
                                         array_push($error_msg,  "There is no result.");
                                    }
                                    
                                    while ($row = mysqli_fetch_array($result)){
                                        print "<tr>";
                                        print "<td>{$row['total_num_product']}</td>";
                                        print "</tr>";              
                                    }                 
                                ?>
                                                              
 
                            </table>                               
              <table>
                <thead>
<tr>

  <th>Total Number of Memberships Sold:</th>

</tr>
      </thead>

            
                <?php               
                                    $query = "SELECT COUNT(member_ID) AS total_num_membership 
                                    FROM  Membership";    
                                    $result = mysqli_query($db, $query);
                                     if (!empty($result) && (mysqli_num_rows($result) == 0) ) {
                                         array_push($error_msg,  "There is no result.");
                                    }
                                    
                                    while ($row = mysqli_fetch_array($result)){
                                        print "<tr>";
                                        print "<td>{$row['total_num_membership']}</td>";
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