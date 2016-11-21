<?php
    if (isset($_POST['subc'])) //When data is submitted by the button
    {
        $name = $_POST["name"]; 
        $surname = $_POST["surname"]; 
        $bday = $_POST["bday"]; 
        $gen = $_POST["gen"]; 
        $city = $_POST["city"]; 
        
        echo callofthewild($name, $surname, $bday, $gen, $city);
    }

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