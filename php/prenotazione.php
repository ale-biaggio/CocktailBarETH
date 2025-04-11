<?php
    //se nella variabile $_POST è settato il campo "tav_num", allora è stata richiesta una prenotazione 
    //arrivata da ajax, che viene effettuata tramite due INSERT nel database, una per la tabella prenotazione
    //per i dati del prenotante, e una nella tabella tavolo per sapere data, ora e tavolo prenotato.
    if(isset($_POST["tav_num"])){
        $db_conn = mysqli_connect("localhost", "root", "root", "my_bite01");
        $data = $_POST["data"];
        $ora = $_POST["ora"];
        $tav_num = $_POST["tav_num"];
        $query1 = "INSERT into tavolo(id_t,data,ora,tavolo) values(0,'$data','$ora','$tav_num')";
        $result = mysqli_query($db_conn, $query1);
        $nome = $_POST["nome"];
        $cognome = $_POST["cognome"];
        $telefono = $_POST["telefono"];
        $email = $_POST["email"];
        $query2 = "INSERT into prenotazione(id,nome,cognome,telefono,email) values(0,'$nome','$cognome','$telefono','$email')";
        $result = mysqli_query($db_conn, $query2);
    }
    //se nessuno dei precedenti if ritorna true, allora è stata richiesta tramite ajax la lista dei tavolo occupati
    //per una certa data e ora
    else{
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
    }
?>

