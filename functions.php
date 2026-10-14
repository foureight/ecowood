<?php

function odstranit_diakritiku($text){
	$vysledek = str_replace(
            array("á","č","ď","é","ě","í","ľ","ň","ó","ř","š","ť","ú","ů","ý","ž","Á","Č","Ď","É","Ě","Í","Ľ","Ň","Ó","Ř","Š","Ť","Ú","Ů","Ý","Ž"," ","ë") ,
            array("a","c","d","e","e","i","l","n","o","r","s","t","u","u","y","z","A","C","D","E","E","I","L","N","O","R","S","T","U","U","Y","Z","-","e") ,
					$text);
	return strtolower($vysledek);
}

function convert_to_url($text){
	$vysledek = str_replace(
            array("á","č","ď","é","ě","í","ľ","ň","ó","ř","š","ť","ú","ů","ý","ž","Á","Č","Ď","É","Ě","Í","Ľ","Ň","Ó","Ř","Š","Ť","Ú","Ů","Ý","Ž"," ","ë",",",".","!","?",":","(",")","[","]","{","}","/","*","'",'&quot;') ,
            array("a","c","d","e","e","i","l","n","o","r","s","t","u","u","y","z","A","C","D","E","E","I","L","N","O","R","S","T","U","U","Y","Z","-","e","","","","","","","","","","","","","","","") ,
					$text);
	return strtolower(trim($vysledek,'-'));
}

function convert_to_filename($text){
	$vysledek = str_replace(
            array("á","č","ď","é","ě","í","ľ","ň","ó","ř","š","ť","ú","ů","ý","ž","Á","Č","Ď","É","Ě","Í","Ľ","Ň","Ó","Ř","Š","Ť","Ú","Ů","Ý","Ž"," ","ë",",",".","!","?",":","(",")","[","]","{","}","/","*") ,
            array("a","c","d","e","e","i","l","n","o","r","s","t","u","u","y","z","A","C","D","E","E","I","L","N","O","R","S","T","U","U","Y","Z","-","e","","","","","","","","","","","","","") ,
					$text);
	return trim($vysledek,'-');
}

function check_access_for_users($doc_pages){
    $public = true;
    // projít docpages
    foreach($doc_pages as $doc_page){

        $parentpage = new Page();
        $parentpage->id = $doc_page;
        $parentpage = $parentpage->get_by_id();                                

        $parents = $parentpage->get_parents();
        foreach ($parents as $parent) {
            if($parent->id == 3){
               $public = false;
               break;
            }
        }
        if($public == false){
            break;
        }                                
    }
    return $public;
}


function upload_image($koncovky, $adresar, $vytvorit_miniaturu, $sirka_miniatury = 300){
        $filenames = array();
        $total = count($_FILES['image']['name']);
        
        for($i=0; $i<$total; $i++) {
            // nebyl nahrán žádný obrázek
            if($total == 1 && strlen($_FILES['image']['name'][0]) == 0){
                break;
            }
            
            // ZPRACOVÁNÍ UPLOADU

				
	$chyba = "";
	if (!$_FILES || $_FILES["image"]["error"][$i] == UPLOAD_ERR_INI_SIZE) {
		$chyba = "!!! - Obrázek je příliš velký, maximální velikost je " . ini_get('upload_max_filesize') . ".";
	} elseif ($_FILES["image"]["error"][$i] == UPLOAD_ERR_NO_FILE) {
		$chyba = "!!! - Nevybral jste žádný obrázek.";
	} elseif (!in_array(strtolower(pathinfo($_FILES["image"]["name"][$i], PATHINFO_EXTENSION)), $koncovky)){
		$chyba = "!!! - Koncovka obrázku musí být jedna z: " . implode(", ", $koncovky) . ".";
	} elseif ($_FILES["image"]["error"][$i]) {
		$chyba = "!!! - Soubor se nepodařilo nahrát, kontaktujte prosím správce serveru.";
	}elseif (!($imagesize = getimagesize($_FILES["image"]["tmp_name"][$i])) || $imagesize[2] > 3) {
		$chyba = "!!! - Typ obrázku musí být JPG, PNG nebo GIF.";
	} 
	else {
            $nazev_souboru = basename($_FILES['image']['name'][$i]);
            $docasne_jmeno = $_FILES['image']['tmp_name'][$i];
            
            if(!is_uploaded_file($docasne_jmeno)){
                $chyba = "!!! - Obrázek se nepodařilo nahrát.";
            }
            else{
                // přesun a přejmenování souboru
                $novy_nazev = vytvor_jmeno();
                while(file_exists($adresar.DIRECTORY_SEPARATOR.$novy_nazev)){
                    $novy_nazev = vytvor_jmeno();
                }

                $velky = $adresar.DIRECTORY_SEPARATOR.$novy_nazev;

                list($width, $height) = vrat_rozmery_obrazku($docasne_jmeno, 1600, 1600);
                if ($width && $height) {
                    zmensi_obrazek($docasne_jmeno, $velky, $width, $height);
                    chmod($velky, 0664);
                } 

                if ($vytvorit_miniaturu) {
                    $maly = $adresar.DIRECTORY_SEPARATOR.'m'.DIRECTORY_SEPARATOR.$novy_nazev;

                    list($width, $height) = vrat_rozmery_obrazku($docasne_jmeno, $sirka_miniatury, 0);
                    if ($width && $height) {
                        zmensi_obrazek($docasne_jmeno, $maly, $width, $height);
                        chmod($maly, 0664);
                    }
                }    
            }
        }
        if(isset($novy_nazev)){
            array_push($filenames, $novy_nazev);
        }
        else{
            array_push($filenames, $chyba);            
        }
    }
    return $filenames;
}

/** Vrácení rozměrů obrázku po zmenšení
* @param string název zmenšovaného souboru
* @param int maximální šířka výsledného obrázku, 0 pokud na ní nezáleží
* @param int maximální výška výsledného obrázku, 0 pokud na ní nezáleží
* @return array ($width, $height) výsledná šířka a výška
* @copyright Jakub Vrána, https://php.vrana.cz/
*/
function vrat_rozmery_obrazku($file_in, $max_x = 0, $max_y = 0) {
    list($width, $height) = getimagesize($file_in);
    if (!$width || !$height) {
        return array(0, 0);
    }
    if ($max_x && $width > $max_x) {
        $height = round($height * $max_x / $width);
        $width = $max_x;
    }
    if ($max_y && $height > $max_y) {
        $width = round($width * $max_y / $height);
        $height = $max_y;
    }
    return array($width, $height);
}

/** Převzorkování obrázku GIF, PNG nebo JPG
* @param string název zmenšovaného souboru
* @param string název výsledného souboru
* @param int šířka výsledného obrázku
* @param int výška výsledného obrázku
* @return bool true, false v případě chyby
* @copyright Jakub Vrána, http://php.vrana.cz/
*/
function zmensi_obrazek($file_in, $file_out, $width, $height) {
    $imagesize = getimagesize($file_in);
    if ((!$width && !$height) || !$imagesize[0] || !$imagesize[1]) {
        return false;
    }
    if ($imagesize[0] == $width && $imagesize[1] == $height) {
        return copy($file_in, $file_out);
    }
    switch ($imagesize[2]) {
        case 1: $img = imagecreatefromgif($file_in); break;
        case 2: $img = imagecreatefromjpeg($file_in); break;
        case 3: $img = imagecreatefrompng($file_in); break;
        default: return false;
    }
    if (!$img) {
        return false;
    }
    $img2 = imagecreatetruecolor($width, $height);
    imagecopyresampled($img2, $img, 0, 0, 0, 0, $width, $height, $imagesize[0], $imagesize[1]);
    if ($imagesize[2] == 2) {
        return imagejpeg($img2, $file_out, 90);
    } elseif ($imagesize[2] == 1 && function_exists("imagegif")) {
        imagetruecolortopalette($img2, false, 256);
        return imagegif($img2, $file_out);
    } else {
        return imagepng($img2, $file_out);
    }
}

function vytvor_jmeno(){
    $nahodne_jmeno="";
    for($x = 0; $x < 30; $x++){
        switch (round(rand(1, 3))){
        case "1";
            $nahodne_jmeno = $nahodne_jmeno.chr(round(rand(49, 57)));
        break;
        case "2";    
            $nahodne_jmeno = $nahodne_jmeno.chr(round(rand(65, 90)));
        break;
        case "3"; 
            $nahodne_jmeno = $nahodne_jmeno.chr(round(rand(97, 122)));
        break; 
        }
    }
    return strtolower(trim($nahodne_jmeno)).".jpg";    
}

function remove_dir_with_content($path){
    $result = null;
    $soubory = glob($path."/*");    
    foreach ($soubory as $soubor){
        if(is_file($soubor)){
            unlink($soubor);
        }
    }
    $soubory = glob($path.'/m/*');
    foreach ($soubory as $soubor){
        if(is_file($soubor)){
            unlink($soubor);
        }
    }
    if(is_dir($path.'/m')){
        rmdir($path.'/m');
    }
    if(is_dir($path)){
        $result = rmdir($path) ? true : false;
    }
    return $result;
}

/***************************************************************************
* Zajisti spravne formatovani data do databaze
*/

function formatuj_datum_do_db($datum){
   $den_mesic_rok = explode(".", $datum);
   $rok_mesic_den = $den_mesic_rok[2]."-".$den_mesic_rok[1]."-".$den_mesic_rok[0];

   return $rok_mesic_den;
}

/***************************************************************************
* Zajisti uzivatelsky prijemny format data z databaze
* 
* @param string datum   Hodnota, ktera je nactena z databaze
*/

function formatuj_datum_z_db($datum){
   $rok_mesic_den = explode("-", $datum);
   $den_mesic_rok = $rok_mesic_den[2].".".$rok_mesic_den[1].".".$rok_mesic_den[0];

   return $den_mesic_rok;
}
function formatuj_datum_pro_datatable($datum){
   $den_mesic_rok = explode(".", $datum);
   $rok_mesic_den = $den_mesic_rok[2]."/".$den_mesic_rok[1]."/".$den_mesic_rok[0];

   return $rok_mesic_den;
}
    
function upload_attachment($input_name, $koncovky, $adresar){
        $filenames = array();
        $total = count($_FILES[$input_name]['name']);
            
        // ZPRACOVÁNÍ UPLOADU
		
	$chyba = "";
	if (!$_FILES || $_FILES[$input_name]["error"] == UPLOAD_ERR_INI_SIZE) {
		$chyba = "!!! - Soubor je příliš velký, maximální velikost je " . ini_get('upload_max_filesize') . ".";
	} elseif ($_FILES[$input_name]["error"] == UPLOAD_ERR_NO_FILE) {
		$chyba = "!!! - Nevybral jste žádný soubor.";
	} elseif (!in_array(strtolower(pathinfo($_FILES[$input_name]["name"], PATHINFO_EXTENSION)), $koncovky)){
		$chyba = "!!! - Koncovka souboru musí být jedna z: " . implode(", ", $koncovky) . ".";
	} elseif ($_FILES[$input_name]["error"]) {
		$chyba = "!!! - Soubor se nepodařilo nahrát, kontaktujte prosím správce serveru.";
	} 
	else {
            $file_name = pathinfo($_FILES[$input_name]["name"], PATHINFO_FILENAME);
            $docasne_jmeno = $_FILES[$input_name]['tmp_name'];
            
            if(!is_uploaded_file($docasne_jmeno)){
                $chyba = "!!! - Soubor se nepodařilo nahrát.";
            }
            else{
                // přesun a přejmenování souboru
                $novy_nazev = convert_to_filename($file_name).'.'.strtolower(pathinfo($_FILES[$input_name]["name"], PATHINFO_EXTENSION));
                $destination = $adresar.DIRECTORY_SEPARATOR.$novy_nazev;

                if(move_uploaded_file($docasne_jmeno, $destination)){
                    chmod($destination, 0664);
                    array_push($filenames, $novy_nazev);
                }
                else{
                    array_push($filenames, $chyba);            
                }
            }
        }
    return $filenames;
} 


?>