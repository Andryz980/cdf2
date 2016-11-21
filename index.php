<!DOCTYPE html>
<html>
   
  <head>
    <meta charset="utf-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- implementato correttamente Bootstrap   -->
  </head>

  <body style="background-color:lavender">

  <div class="container">
    <h2 class="text-center">Calcolo codice fiscale</h2>
    <form action="cfstuffex.php" method="post">
      <div class="form-group">
        <label>Nome:</label>
        <input class="form-control" name="name">
      </div>
      
      <div class="form-group">
        <label>Cognome:</label>
        <input class="form-control" name="surname">
      </div>

      <div>
        <label>Data di nascita:</label>
        <input type="date" name="bday">
      </div>
      
      <div class="radio">
        <label>
            <input type="radio" name="gen" value="Male"> Maschio
        </label>
        <label>
            <input type="radio" name="gen" value="Female"> Femmina
        </label>
      </div>
        
        <div class="form-group">
        <label>Comune di nascita:</label>
        <select class="form-control" name="city">
          <?php
            //Lettura da file corretta
            $myfile=fopen("comuni.csv","r") or die("unable to open file!");
            while(!feof($myfile))
            {
              $linea = fgets($myfile);
              if(!feof($myfile))
                {
                  $array = explode(",", $linea);
                  $com = trim($array[1]);
                  echo"<option value=" . $array[0] . ">". $com . "</option>";
                }
            }	
          ?>
        </select>
      </div>
        
      <button type="submit" name="sub" class="btn btn-primary">Submit</button>
    </form>
  </div>

  </body>
</html> 