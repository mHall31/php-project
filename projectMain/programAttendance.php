<?php
    require_once('startsession.php');
        if (!isset($_SESSION['userId'])) {
        echo '<p class="login">Please <a href="index.php">log in</a> to access this page.</p>';
        exit();
    }
    require_once('navbar.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Programs - Search</title>
        <link rel="stylesheet" type="text/css" href="styleSheets/style.css" />
</head>
<body>
        

    
      <form method="get" action="searchProgram.php">
    <label for="usersearch">Find program:</label><br />
    <input type="text" id="usersearch" name="usersearch" /><br />
    <input type="submit" name="submit" value="Submit" />
  </form>
<div id="wrapper">
    <h3>Programs - Search Results</h3>
<?php
 function build_query($user_search, $sort) {
        $search_query = "select * from spplPrograms";
        //Clean up step
        $clean_search = str_replace(',', '', $user_search);
        $search_words = explode(' ', $clean_search);
        $final_search_words = array();
        if(count($search_words) > 0 ) {
                foreach ($search_words as $word) {
                if (!empty($word)) {
                    $final_search_words[] = $word;
                }
        }
        
 }
 
        $where_list = array();
        if (count($final_search_words) > 0) {
            foreach($final_search_words as $word) {
                $where_list[] = "name like '%$word%'";
            }
        }
        $where_clause = implode(' or ', $where_list);

        // Add the keyword where clause to the search query
        if (!empty($where_clause)) {
            $search_query .= " where
            $where_clause";
        }

        // Sort the search query
        switch ($sort) {
        // Ascending by name
        case 1:
            $search_query .= " order by name";
            break;
        // Descending by name
        case 2:
            $search_query .= " order by name DESC";
            break;
        // Ascending by type
        case 3:
            $search_query .= " order by typeId";
            break;
        // Descending by type
        case 4:
            $search_query .= " order by typeId DESC";
            break;
        // Ascending by startDate
        case 5:
            $search_query .= " order by startDate";
            break;
        // Descending by startDate
        case 6:
            $search_query .= " order by startDate DESC";
            break;
        default:
     
        }

        return $search_query;
    }
 
    function generate_sort_links($user_search, $sort) {
        $sort_links = '';

        switch ($sort) {
        case 1:
            $sort_links .= '<td><a href = "' . $_SERVER['PHP_SELF'] . '?usersearch=' . $user_search . '&sort=2">Program Name</a></td><td>Type Id</td>';
            $sort_links .= '<td><a href = "' . $_SERVER['PHP_SELF'] . '?usersearch=' . $user_search . '&sort=3">Start Date</a></td>';
            $sort_links .= '<td><a href = "' . $_SERVER['PHP_SELF'] . '?usersearch=' . $user_search . '&sort=5">Max Capacity</a></td>';
            break;
        case 3:
            $sort_links .= '<td><a href = "' . $_SERVER['PHP_SELF'] . '?usersearch=' . $user_search . '&sort=1">Program Name</a></td><td>Type Id</td>';
            $sort_links .= '<td><a href = "' . $_SERVER['PHP_SELF'] . '?usersearch=' . $user_search . '&sort=4">Start Date</a></td>';
            $sort_links .= '<td><a href = "' . $_SERVER['PHP_SELF'] . '?usersearch=' . $user_search . '&sort=3">Max Capacity</a></td>';
            break;
        case 5:
            $sort_links .= '<td><a href = "' . $_SERVER['PHP_SELF'] . '?usersearch=' . $user_search . '&sort=1">Program Name</a></td><td>Type Id</td>';
            $sort_links .= '<td><a href = "' . $_SERVER['PHP_SELF'] . '?usersearch=' . $user_search . '&sort=3">Start Date</a></td>';
            $sort_links .= '<td><a href = "' . $_SERVER['PHP_SELF'] . '?usersearch=' . $user_search . '&sort=6">Max Capacity</a></td>';
            break;
        default:
            $sort_links .= '<td><a href = "' . $_SERVER['PHP_SELF'] . '?usersearch=' . $user_search . '&sort=1">Program Name</a></td><td>Type Id</td>';
            $sort_links .= '<td><a href = "' . $_SERVER['PHP_SELF'] . '?usersearch=' . $user_search . '&sort=3">Start Date</a></td>';
            $sort_links .= '<td><a href = "' . $_SERVER['PHP_SELF'] . '?usersearch=' . $user_search . '&sort=5">Max Capacity</a></td>';
        }

        return $sort_links;
    }

    
    function generate_page_links($user_search, $sort, $cur_page, $num_pages) {
        $page_links = '';

        // previous link
        if ($cur_page > 1) {
            $page_links .= '<a href="' . $_SERVER['PHP_SELF'] . '?usersearch=' . $user_search . '&sort=' . $sort . '&page=' . ($cur_page - 1) . '"><-</a> ';
        }
        else {
            $page_links .= '<- ';
        }

        //page number
        for ($i = 1; $i <= $num_pages; $i++) {
            if ($cur_page == $i) {
                $page_links .= ' ' . $i;
            }
            else {
                $page_links .= ' <a href="' . $_SERVER['PHP_SELF'] . '?usersearch=' . $user_search . '&sort=' . $sort . '&page=' . $i . '"> ' . $i . '</a>';
            }
        }
        
        //nest page link
        if ($cur_page < $num_pages) {
            $page_links .= ' <a href="' . $_SERVER['PHP_SELF'] . '?usersearch=' . $user_search . '&sort=' . $sort . '&page=' . ($cur_page + 1) . '">-></a>';
        }
        else {
            $page_links .= ' ->';
        }

        return $page_links;
    }
 
        $sort = $_GET['sort'];
        $user_search = $_GET['usersearch'];

        $cur_page = isset($_GET['page']) ? $_GET['page'] : 1;
        $results_per_page = 5; 
        $skip = (($cur_page - 1) * $results_per_page);
    
        // Start generating the table of results
        echo '<table class="searchTable" border="0" cellpadding="2">';

        // Generate the search result headings
        echo '<tr class="heading">';
        echo generate_sort_links($user_search, $sort);
        echo '</tr>';
        
        
        require_once('connectvars.php');
        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);


        $query = build_query($user_search, $sort);
        $result = mysqli_query($dbc, $query);
        $total = mysqli_num_rows($result);
        $num_pages = ceil($total / $results_per_page);
    
    
        $query =  $query . " LIMIT $skip, $results_per_page";
        $result = mysqli_query($dbc, $query)
                        or die('Error querying the database');
        while ($row = mysqli_fetch_array($result)) {
                echo '<tr class="results">';
                echo '<td valign="top" width="20%">' . $row['name'] . '</td>';
                echo '<td valign="top" width="10%">' . $row['typeId'] . '.</td>';
                echo '<td valign="top" width="30%">' . $row['startDate'] . '</td>';
                echo '<td valign="top" width="20%">' . $row['maxCapacity'] . '</td>';
                echo '<td valign="top" width="40%"> <a href="programPatronRefPage.php?id=' . $row['Id'] . '">Add patrons</a></td>';
                echo '<td valign="top" width="20%"> <a href="programStats.php?id=' . $row['Id'] . '">Stats</a></td>';
                
                echo '</tr>';
        } 
    
        echo '</table>';

    // Generate navigational page links if we have more than one page
    if ($num_pages > 1) {
        echo generate_page_links($user_search, $sort, $cur_page, $num_pages);
    }

    mysqli_close($dbc);
?>
</div>
</body>
</html>


