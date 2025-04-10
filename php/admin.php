<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin</title>
  <script src="../bootstrap/js/bootstrap.min.js"></script>
  <script src="https://unpkg.com/scrollreveal@4.0.0/dist/scrollreveal.min.js"></script>
  <link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
  <link rel="stylesheet" type="text/css" href="../css/style.css">
  <link rel="stylesheet" type="text/css" href="../css/admin.css">
  <script src="/js/admin.js"></script>
</head>
<body>
  <?php
    //con questo controllo, impediamo di accedere alla pagina riservata scrivendo il path del file nella url,
    //dato che si può accedere solo se si proviene dalla pagina login.html
    if(!(isset($_POST["username"]) && isset($_POST["password"]))){
      header("location: ../login.html");
    }
    else{
      $db_conn = mysqli_connect("localhost", "root", "", "my_bite01");
      $username = $_POST["username"];
      $password = $_POST["password"];
      $query1 = "SELECT * FROM admin WHERE username='$username' and password='$password'";
      $result = mysqli_query($db_conn, $query1);
      if(!($line=mysqli_fetch_row($result))){
        //se username e password vengono da login.html ma sono sbagliati, viene stampato a schermo
        //il box che invita a rieffettuare il login
        echo("
        <div class=\"log-failed\">
          <div class=\"box\">
            <img src=\"../img/logo.png\" class=\"logo\">
            <h1>Credenziali errate!</h1>
            <p>Effettua il <a href=\"../login.html\">Login.</a></p>
          </div>
        </div>");
      }
      else{
        //se le credenziali sono giuste, scarico tutte le prenotazioni dal database
        $query2 = "SELECT nome,cognome,telefono,data,ora,tavolo,id FROM prenotazione join tavolo on id=id_t ORDER BY data,ora";
        $result = mysqli_query($db_conn, $query2);
        $dati = array();
        while ($row = mysqli_fetch_row($result)){
            array_push($dati,$row[0],$row[1],$row[2],$row[3],$row[4],$row[5],$row[6]);
        }
  ?>      
        <header>
          <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li><a class="nav-link header-nav" style="text-align:right;" href="../index.html">HOME</a></li>
            <li>
              <a class="logo" style="text-align:center;">
                <img class="animate__animated animate__tada" src="../img/logo.png" width="90px">
              </a>
            </li>
            <li><a class="nav-link header-nav" href="../login.html">LOGOUT</a></li>
          </ul>
          </nav>
        </header>
        <div class="admin">
          <h1>Benvenuto,<?php echo(" <span>$username</span>"); ?></h1>
          <div class="container">
            <div class="row sottotitolo">
              <div class="col-10">
                <h3>Lista prenotazioni:</h3>
              </div>
              <div class="col-2" style="text-align: end;">
                <button type="button" id="tasto_plus" data-bs-toggle="modal" data-bs-target="#modal">+</button>
              </div>
              <!--  modale per la prenotazione, che appare solo dopo aver premuto il tasto +  -->
              <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content" name="form">
                    <div class="modal-header">
                      <h5 class="modal-title" id="modalLabel">Aggiungi Prenotazione</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" id="close" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <form class="row g-3" id="myForm" name="myFormName">
                        <div class="col-md-6">
                          <label for="nome" class="form-label">Nome: *</label>
                          <br>
                          <input type="text" class="form-control" name="nome" id="nome">
                        </div>
                        <div class="col-md-6">
                          <label for="cognome" class="form-label">Cognome: *</label>
                          <br>
                          <input type="text" class="form-control" name="cognome" id="cognome">
                        </div>
                        <div class="col-md-6">
                          <label for="telefono" class="form-label">Telefono: *</label>
                          <br>
                          <input type="text" class="form-control" name="telefono" id="telefono">
                        </div>
                        <div class="col-md-6">
                          <label for="email" class="form-label">e-mail:</label>
                          <br>
                          <input type="email" class="form-control" name="email" id="email">
                        </div>
                        <div class="col-3">
                          <label for="data" class="form-label">Data:</label>
                          <select class="form-select" name="data" id="data">
                            <option value="" selected disabled hidden></option>
                            <option>01/06</option><option>02/06</option>
                            <option>03/06</option><option>04/06</option><option>05/06</option>
                            <option>06/06</option><option>07/06</option><option>08/06</option><option>09/06</option>
                            <option>10/06</option><option>11/06</option><option>12/06</option><option>13/06</option>
                            <option>14/05</option><option>15/05</option>
                          </select>
                        </div>
                        <div class="col-1"></div>
                        <div class="col-4">
                          <label for="ora" class="form-label">Ora:</label>
                          <select class="form-select" name="ora" id="ora">
                            <option value="" selected disabled hidden></option>
                            <option>19:00</option><option>20:30</option><option>22:00</option>
                            <option>23:30</option>
                          </select>
                        </div>
                        <div class="col-1"></div>
                        <div class="col-3">
                          <label for="ora" class="form-label">Tavolo:</label>
                          <select class="form-select" name="tav_num" id="tav_num">
                            <option value="" selected disabled hidden></option>
                            <option id="1">1</option><option id="2">2</option><option id="3">3</option>
                            <option id="4">4</option><option id="5">5</option>
                            <option id="6">6</option><option id="7">7</option>
                            <option id="8">8</option><option id="9">9</option>
                            <option id="10">10</option>
                          </select>
                        </div>
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-primary" id="aggiungi_btn">Aggiungi</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div> 
          </div>
          <!--  tramite questo ciclo vengono stampate a schermo tutte le prenotazioni presenti nel database  -->
          <div class="container">
            <div class="row">
<?php     for($i = 0; $i<(count($dati))/7;$i++){    ?>           
              <div class="col-md-4 zoom">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
<?php         for($j = 0; $j<7; $j++){        
                    if($j==0){              ?>
                      <div class="col-6 header">Nome:</div> <div class="col-6" id="nome"><h5 class="card-title"> <?php echo($dati[$i*7+$j]);?>  </h5></div>
<?php               }           
                    if($j==1){             ?>
                      <div class="col-6 header">Cognome:</div> <div class="col-6" id="cognome"><h5 class="card-title"><?php echo($dati[$i*7+$j]);?>  </h5></div>
<?php               }           
                    if($j==2){             ?>
                      <div class="col-6 header">Telefono:</div> <div class="col-6" id="telefono"><h5 class="card-title"><?php echo($dati[$i*7+$j]);?>  </h5></div>
<?php               }           
                    if($j==3){             ?>
                      <div class="col-6 header">Data:</div> <div class="col-6" id="data"><h5 class="card-title"><?php echo($dati[$i*7+$j]);?>  </h5></div>
<?php               }           
                    if($j==4){             ?>
                      <div class="col-6 header">Ora:</div> <div class="col-6" id="ora"><h5 class="card-title"><?php echo($dati[$i*7+$j]);?>  </h5></div>
<?php               }           
                    if($j==5){             ?>
                      <div class="col-6 header">Tavolo:</div> <div class="col-6" id="tavolo"><h5 class="card-title"><?php echo($dati[$i*7+$j]);?>  </h5></div>
<?php               }           
                    if($j==6){             ?>  
                      <div class="col-6 header" id="id"><?php echo($dati[$i*7+$j]);?></div>
<?php               }
              }         ?>
                      <div class="col-12" id="cestino-div"><button type="button" class="cestino-btn"><img id="cestino-img" src="../img/cestino.png"></button></div>
                    </div>
                  </div>
                </div>
              </div>
              
<?php       }             
?>
              </div>
            </div>
          </div>
        </div>
<?php
      }
    }
?>

</body>

<script>
  ScrollReveal().reveal('.zoom', {duration: 1500, easing: 'cubic-bezier(.215, .61, .355, 1)', interval: 500, scale: 0.65});
</script>
</html>

