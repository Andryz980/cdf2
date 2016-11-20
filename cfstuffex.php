<?php

    if (isset($_POST['sub']))
    {
        $name = $_POST["name"]; 
        $surname = $_POST["surname"]; 
        $bday = $_POST["bday"]; 
        $gen = $_POST["gen"]; 
        $city = $_POST["city"]; 
        
        echo call($name, $surname, $bday, $gen, $city);
    }

function call($name, $surname, $bday, $gen, $city)
{
    $tmp = new cf;
    return $tmp->calcola($name, $surname, $bday, $gen, $city);
    
}

class cf
{

    protected $_cons = array('B', 'C', 'D', 'F', 'G', 'H', 'J', 'K', 'L', 'M', 'N', 'P', 'Q', 'R', 'S', 'T', 'V', 'W', 'X', 'Y', 'Z');
    //Array containing all the consonants.
    
    protected $_vows = array('A', 'E', 'I', 'O', 'U');
    //Array containing all the vowels.

    protected $_mesi = array(1  => 'A',  2 => 'B',  3 => 'C',  4 => 'D',  5 => 'E', 6  => 'H',  7 => 'L',  8 => 'M',  9 => 'P', 10 => 'R', 11 => 'S', 12 => 'T');
    //Array that will be used to associate the number of our birth month to a specific letter that ends up in the final code.

    
    protected $_even = array('0' =>  0, '1' =>  1, '2' =>  2, '3' =>  3, '4' =>  4, '5' =>  5, '6' =>  6, '7' =>  7, '8' =>  8, '9' =>  9, 'A' =>  0, 'B' =>  1, 'C' =>  2, 'D' =>  3, 'E' =>  4, 'F' =>  5, 'G' =>  6, 'H' =>  7, 'I' =>  8, 'J' =>  9, 'K' => 10, 'L' => 11, 'M' => 12, 'N' => 13, 'O' => 14, 'P' => 15, 'Q' => 16, 'R' => 17, 'S' => 18, 'T' => 19, 'U' => 20, 'V' => 21, 'W' => 22, 'X' => 23, 'Y' => 24, 'Z' => 25);

    protected $_odds = array('0' =>  1, '1' =>  0, '2' =>  5, '3' =>  7, '4' =>  9, '5' => 13, '6' => 15, '7' => 17, '8' => 19, '9' => 21, 'A' =>  1, 'B' =>  0, 'C' =>  5, 'D' =>  7, 'E' =>  9, 'F' => 13, 'G' => 15, 'H' => 17, 'I' => 19, 'J' => 21, 'K' =>  2, 'L' =>  4, 'M' => 18, 'N' => 20, 'O' => 11, 'P' =>  3, 'Q' =>  6, 'R' =>  8, 'S' => 12, 'T' => 14, 'U' => 16, 'V' => 10, 'W' => 22, 'X' => 25, 'Y' => 24, 'Z' => 23);

    protected $_controllo = array('0'  => 'A', '1'  => 'B', '2'  => 'C', '3'  => 'D', '4'  => 'E', '5'  => 'F', '6'  => 'G', '7'  => 'H', '8'  => 'I', '9'  => 'J', '10' => 'K', '11' => 'L', '12' => 'M', '13' => 'N', '14' => 'O', '15' => 'P', '16' => 'Q', '17' => 'R', '18' => 'S', '19' => 'T', '20' => 'U', '21' => 'V', '22' => 'W', '23' => 'X', '24' => 'Y', '25' => 'Z');    
    //These three arrays will come in handy in the last char function.
    

    protected function _getl($string, array $haystack) //This function returns either the vowels or the consonants of a string.
    { 
        $letters = array();
        foreach(str_split($string) as $needle) //The string is split and then every char is checked.
        {
            if (in_array($needle, $haystack)) //in_array checks if a letter is present in the group I specified, either vowels or consonants.
            {
                $letters[] = $needle;
            }
        }
        return $letters;
    }

    protected function _getvows($string) //This function calls the getl function with consonants...
    {
        return $this->_getl($string, $this->_vows);
    }

    protected function _getcons($string) //...and this calls it with vowels.
    {
        return $this->_getl($string, $this->_cons);
    }

    protected function _addMissingX($string) //This function adds some X if the string is shorter than 3 chars.
    {
        $code = $string;
        
        while(strlen($code) < 3)
        {
            $code = $code . 'X';
        }    
        return $code;
    }
    
    protected function _calcolaNome($nome)
    //This function returns the first, third and fourth consonants (adding vowels if shorter than 3) of the name.
    {

        if (strlen($nome) < 3)
        {
            return $this->_addMissingX($nome);
        } 
        
        $nome_cons = $this->_getcons($nome);

        if (count($ncons) <= 3)
        {
            $code = implode('', $ncons);
        }
        else
        {
            for($i=0; $i<4; $i++)
            {
                if ($i == 1)
                    $i++;
                
                if (!empty($ncons[$i]))
                {
                    $code = $code . $ncons[$i];
                }
            }
        }
        
        if (strlen($code) < 3) 
        {
            $nvoc = $this->_getvows($nome);
            while (strlen($code) < 3)
            {
               $code = $code . array_shift($nvoc); 
            }
        }
        
        return $code;
    }

    protected function _calcolaCognome($cognome)
    //This function returns the first three consonants (adding vowels if shorter than 3) of the name.
    {

        if (strlen($cognome) < 3)
        {
            return $this->_addMissingX($cognome);
        }

        $ccons = $this->_getcons($cognome);
        
        
        for ($i=0; $i<3; $i++) 
        {
            if (array_key_exists($i, $ccons)) 
            {
                $code = $code . $ccons[$i];
            }
        }

        if (strlen($code) < 3)
        {
            $cvoc = $this->_getvows($cognome);
            while (strlen($code) < 3)
            {
                $code = $code . array_shift($cvoc);
            }
        }

        return $code;   
    }

    protected function _calcolaDataNascita($data, $gen)
    //This function returns the five symbols after the six ones. These symbols are related to a person's date of birth and gender.
    {
        $dn = explode('/', $data); //Separates the "01/01/1900" format in an array containing the single elements.

        $giorno = (int) @$dn[0];
        $mese   = (int) @$dn[1];
        $anno   = (int) @$dn[2];
        
        $aa = substr($anno, -2); //Removes the first two numbers from the year.
        
        $mm = $this->_mesi[$mese]; //Fetchs the letter associated with the person's month.
        
        if ($gen != "Male")
            $gg = $giorno + 40;
        else
            $gg = $giorno;
        
        
        if (strlen($gg) < 2) $gg = '0' . $gg;

        return $aa . $mm . $gg;
    }

    protected function _calcolaCatastale($comune)
    {
        return "L840"; //WIP
    }

    protected function _calcolaCifraControllo($codice)
    {
        $code = str_split($codice);
        $sum  = 0;

        for($i=1; $i <= count($code); $i++)
        {
            $cifra = $code[$i-1];
            $sum += ($i % 2) ? $this->_odds[$cifra] : $this->_even[$cifra];
        }

        $sum %= 26;

        return $this->_controllo[$sum];
    }

    public function calcola($nome, $cognome, $data, $sesso, $comune)
    {
        $codice = $this->_calcolaCognome($cognome) . 
                  $this->_calcolaNome($nome) . 
                  $this->_calcolaDataNascita($data, $sesso) . 
                  $this->_calcolaCatastale($comune);

        
 
        $codice .= $this->_calcolaCifraControllo($codice);

        if (strlen($codice) != 16)
        {
            return false;
        }

        return $codice;
    } 
}