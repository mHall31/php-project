 <?php
 $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
                    or die('Error connecting to the database');
                    
            if (isset($_GET['id']) && is_numeric($_GET['id'])) {
                $id =  mysqli_real_escape_string($dbc, trim($_GET['id']));
            }
            
            
            $query = "select patronId from patronProgramAttendance where programId = $id";
            echo "$query";
            $data = mysqli_query($dbc, $query)
                    or die('Error retreving Patron Ids');
            
            $patronArray = array();
            
            while($row = mysqli_fetch_array($data)) {
                if(!$row == null ) {
                    $patronArray[] = $row['patronId'];
                }
            }    
                    $patronQuery = implode(", ", $patronArray); 
            if(!empty($patronQuery)) {        
                    $query = "select Id, firstName, lastName, sex, birthdate, schoolAttending, grade, city, phoneNumber from spplPatrons where id in ($patronQuery)";
                    //print_r($patronArray);
                    //echo"$patronQuery";
                    //echo "$query";
                    $data = mysqli_query($dbc, $query)
                            or die('Error retrieving patron data');
                    while ($row = mysqli_fetch_array($data)) { 
                        
                        if(!empty($row['birthdate'])) {
                            $age = date_diff(date_create($row['birthdate']), date_create('now'))->y;
                        }
                        
                        echo '<tr><td>' . $row['firstName']. '    </td>';
                        echo '<td>' . $row['lastName']. '    </td>';
                        echo '<td>' . $row['phoneNumber']. '    </td>';
                        echo '<td>' . $row['sex']. '    </td>';
                        echo '<td>' . $age. '    </td>';
                        echo '<td>' . $row['schoolAttending']. '    </td>';
                        echo '<td>' . $row['grade']. '    </td>';
                        echo '<td>' . $row['city']. '    </td>';
                        echo '<td><a href="removePatronfromProgram.php?patronId=' . $row['Id'] . '&programId=' .$id. '">Remove from Program</a></td>';
                    }
                
            }
        ?>
