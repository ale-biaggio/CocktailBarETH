<?php
        $db_conn = mysqli_connect("localhost", "root", "root", "my_bite01");
        $data = $_POST["data"];
        $ora = $_POST["ora"];
        $query = "SELECT tavolo FROM tavolo WHERE data='$data' and ora='$ora'";
        $result = mysqli_query($db_conn, $query);
        $dati = array();
        while ($row = mysqli_fetch_row($result)){
            array_push($dati,$row[0]);
        }
        echo implode(" ",$dati);     
?>

