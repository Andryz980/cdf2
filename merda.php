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

class cf {
    
    protected $_consonanti = array(
        'B', 'C', 'D', 'F', 'G', 'H', 'J', 'K',
        'L', 'M', 'N', 'P', 'Q', 'R', 'S', 'T',
        'V', 'W', 'X', 'Y', 'Z'
    );

    /**
     * Array delle vocali
     */
    protected $_vocali = array(
        'A', 'E', 'I', 'O', 'U'
    );

    /**
     * Array per il calcolo della lettera del mese
     * Al numero del mese corrisponde una lettera
     */
    protected $_mesi = array( 
        1  => 'A',  2 => 'B',  3 => 'C',  4 => 'D',  5 => 'E',  
        6  => 'H',  7 => 'L',  8 => 'M',  9 => 'P', 10 => 'R', 
        11 => 'S', 12 => 'T'
    );

    
    protected $_pari = array(
        '0' =>  0, '1' =>  1, '2' =>  2, '3' =>  3, '4' =>  4, 
        '5' =>  5, '6' =>  6, '7' =>  7, '8' =>  8, '9' =>  9,
        'A' =>  0, 'B' =>  1, 'C' =>  2, 'D' =>  3, 'E' =>  4, 
        'F' =>  5, 'G' =>  6, 'H' =>  7, 'I' =>  8, 'J' =>  9,
        'K' => 10, 'L' => 11, 'M' => 12, 'N' => 13, 'O' => 14, 
        'P' => 15, 'Q' => 16, 'R' => 17, 'S' => 18, 'T' => 19,
        'U' => 20, 'V' => 21, 'W' => 22, 'X' => 23, 'Y' => 24, 
        'Z' => 25
    );

    protected $_dispari = array(  
        '0' =>  1, '1' =>  0, '2' =>  5, '3' =>  7, '4' =>  9,
        '5' => 13, '6' => 15, '7' => 17, '8' => 19, '9' => 21,
        'A' =>  1, 'B' =>  0, 'C' =>  5, 'D' =>  7, 'E' =>  9, 
        'F' => 13, 'G' => 15, 'H' => 17, 'I' => 19, 'J' => 21,
        'K' =>  2, 'L' =>  4, 'M' => 18, 'N' => 20, 'O' => 11, 
        'P' =>  3, 'Q' =>  6, 'R' =>  8, 'S' => 12, 'T' => 14,
        'U' => 16, 'V' => 10, 'W' => 22, 'X' => 25, 'Y' => 24, 
        'Z' => 23
    );

    protected $_controllo = array( 
        '0'  => 'A', '1'  => 'B', '2'  => 'C', '3'  => 'D', 
        '4'  => 'E', '5'  => 'F', '6'  => 'G', '7'  => 'H', 
        '8'  => 'I', '9'  => 'J', '10' => 'K', '11' => 'L', 
        '12' => 'M', '13' => 'N', '14' => 'O', '15' => 'P', 
        '16' => 'Q', '17' => 'R', '18' => 'S', '19' => 'T',
        '20' => 'U', '21' => 'V', '22' => 'W', '23' => 'X', 
        '24' => 'Y', '25' => 'Z'
    );    


    protected function _getLettere($string, array $haystack) { 
        $letters = array();
        foreach(str_split($string) as $needle) {
            if (in_array($needle, $haystack)) {
                $letters[] = $needle;
            }
        }
        return $letters;
    }

    /**
     * Ritorna un array con le vocali di una data stringa
     */
    protected function _getVocali($string) {
        return $this->_getLettere($string, $this->_vocali);
    }

    /**
     * Ritorna un array con le consonanti di una data stringa
     */
    protected function _getConsonanti($string) {
        return $this->_getLettere($string, $this->_consonanti);
    }


    protected function _addMissingX($string) {
        $code = $string;
        while(strlen($code) < 3) {
            $code .= 'X';
        }    
        return $code;
    }

    protected function _calcolaNome($nome) {
        $code = "";
        if (strlen($nome) < 3) {
            return $this->_addMissingX($nome);
        } 
        
        $nome_cons = $this->_getConsonanti($nome);

        // Se le consonanti contenute nel nome sono minori 
        // o uguali a 3 vengono considerate nell'ordine in cui
        // compaiono.
        if (count($nome_cons) <= 3) {
            $code = implode('', $nome_cons);
        } else {
            // Se invece abbiamo almeno 4 consonanti, prendiamo
            // la prima, la terza e la quarta.
            for($i=0; $i<4; $i++) {
                if ($i == 1) continue;
                if (!empty($nome_cons[$i])) {
                    $code .= $nome_cons[$i];
                }
            }
        }
        $i = 0;
        // Se compaiono meno di 3 consonanti nel nome, si
        // utilizzano le vocali, nell'ordine in cui compaiono
        // nel nome.
        if (strlen($code) < 3) {
            $nome_voc = $this->_getVocali($nome);
            while (strlen($code) < 3 && $i < count($nome_voc))
            {
               $code = $code . $nome_voc[$i];
                $i++;
            }
        }
        
        return $code;
    }

    protected function _calcolaCognome($cognome) {
        $code = "";
        if (strlen($cognome) < 3) {
            return $this->_addMissingX($cognome);
        }

        $cognome_cons = $this->_getConsonanti($cognome);
        
        // Per il calcolo del cognome si prendono le prime
        // 3 consonanti. 
        for ($i=0; $i<3; $i++) {
            if (array_key_exists($i, $cognome_cons)) {
                $code .= $cognome_cons[$i];
            }
        }
$i = 0;
        // Se le consonanti non bastano, vengono prese
        // le vocali nell'ordine in cui compaiono.
        if (strlen($code) < 3) {
            $cvoc = $this->_getVocali($cognome);
            while (strlen($code) < 3 && $i < count($cvoc)) 
            {
                $code = $code . $cvoc[$i];
                $i++;
            }
        }

        return $code;   
    }

    protected function _calcolaDataNascita($data, $sesso) {
        $dn = explode('/', $data); 

        $giorno = (int) @$dn[0];
        $mese   = (int) @$dn[1];
        $anno   = (int) @$dn[2];

        // Le ultime due cifre dell'anno di nascita
        $aa = substr($anno, -2);
        
        // La lettera corrispondente al mese di nascita
        $mm = $this->_mesi[$mese];

        // Il giorno viene calcolato a seconda del sesso
        // del soggetto di cui si calcola il codice:
        // se e' Maschio si mette il giorno reale, se e' 
        // Femmina viene aggiungo 40 a questo numero.
        $gg = (strtoupper($sesso) != 'M') ? $giorno : ($giorno + 40);

        // Bug #1: Thanks to Luca 
        if (strlen($gg) < 2) $gg = '0' . $gg;


        return $aa . $mm . $gg;        
    }
    protected function _calcolaComune($comune)
    {
        return "L840";
    }

    protected function _ccontrollo($codice) {
        $code = str_split($codice);
        $sum  = 0;

        for($i=1; $i <= count($code); $i++) {
            $cifra = $code[$i-1];
            $sum += ($i % 2) ? $this->_dispari[$cifra] : $this->_pari[$cifra];
        }

        $sum %= 26;

        return $this->_controllo[$sum];
    }

    public function calcola($nome, $cognome, $data, $sesso, $comune) 
    {
        $codice = $this->_calcolaCognome($cognome) . 
                  $this->_calcolaNome($nome) . 
                  $this->_calcolaDataNascita($data, $sesso) . 
                  $this->_calcolaComune($comune);
 
        $codice .= $this->_ccontrollo($codice);

        if (strlen($codice) != 16) 
        {
            echo "wut";
        }

        return $codice;
    } 
}