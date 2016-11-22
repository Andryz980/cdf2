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
      <div class="col-xs-6">
        <label>Nome:</label>
        <input class="form-control" name="name">
      </div>
      
      <div class="col-xs-6">
        <label>Cognome:</label>
        <input class="form-control" name="surname">
      </div>
        
        <div class="col-xs-12" style="height:20px;"></div>
        
      <div class="col-xs-12">
        <label>Data di nascita:</label>
        <input type="date" name="bday" placeholder="gg-mm-aa">
      </div>
      
        <div class="col-xs-12" style="height:20px;"></div>
        
      <div class="col-xs-12">
        <label>
            <input type="radio" name="gen" value="Male"> Maschio
        </label>
        <label>
            <input type="radio" name="gen" value="Female"> Femmina
        </label>
      </div>
        
        <div class="col-xs-12" style="height:20px;"></div>
        
        <div class="col-xs-12">
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
        
        <div class="col-xs-12" style="height:30px;"></div>
        
        <div class="text-center">
            <button type="submit" name="sub" class="btn btn-primary">Submit</button>
        </div>
    </form>
  </div>

  </body>
</html> 
