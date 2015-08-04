<?php

    // This is the test php file
    
    $intime = "11:00:00";
    $outtime = "02:00:00";
    
//    echo isOpen($intime,$outtime);
//    echo json_encode(getdate()['hours']);
    echo explode(":", $intime)[0];
    
    function isOpen($intime , $outtime){
        $intime = explode(":", $intime);
        $intimehour = $intime[0];
        $intimemin = $intime[1];
        $intimesec = $intime[2];

        $outtime = explode(":", $outtime);
        $outtimehour = $outtime[0];
        $outtimemin = $outtime[1];
        $outtimesec = $outtime[2];

        $bakuTime = getdate();

        if($intimehour < $outtimehour){
            if($bakuTime['hours']>$intimehour && $bakuTime['hours']<$outtimehour){
                return "1";
            }

        }else if($intimehour > $outtimehour){
            $outtimehour = $outtimehour + 24;
            if($bakuTime['hours']>$intimehour && $bakuTime['hours']<$outtimehour){
                return "1";
            }        
        }else{
            // $intimehour == $outtimehour
            // which mean that place open 7x24
            return "1";
        }

        return "0"; 
    }
    
    
//    echo json_encode(getdate());

?>
