<?php

//read source file data



//connect to database

$mysqli = $this->connID = new \mysqli("localhost", "avhadmin", "12345678", "avhkn");


        if ($mysqli->connect_errno) {
            printf("Connection to database failed: %s\n", $mysqli->connect_error);
                       exit();
        } else {
            printf("Connectionestablished</br>");
            mysqli_set_charset($mysqli, 'utf8');
        }

$query = "SELECT * FROM skolib_customer";
$data = selectValues($mysqli,$query);

if (!empty($data) ) {
    foreach ($data as $d)
    {
        var_dump($d);
        echo '</br>';
    }
}


/******************************************************
 * ****************************************************
 */
public function selectValues($mysqli,$query) {
        $mysqli = $this->connID;
        $result = $mysqli->query($query);
        
        if ($result === false) {
            throw new MySQLException($mysqli, $query);
        }
        
        $value = null;
        $anz = $result->field_count;
        $valCount = 0;
        
        while ($row = $result->fetch_array(MYSQLI_NUM)) {
            for ($x = 0; $x < $anz; $x++) {
                $value[$valCount][$x] = $row[$x];
            }
            $valCount++;
        }
        $result->free();
        
        return $value;
    }
?>
