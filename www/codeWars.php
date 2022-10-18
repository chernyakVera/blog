<?php
function count_smileys($arr): int {

    $count = 0;
    $pattern = '~^.*\:|\;.*|\-|\~D|\)$~';

    foreach ($arr as $face) {
        $match = preg_match($pattern, $face);
        if($match !== null) {
            $count++;
        }
    }
    return $count;
}


echo count_smileys([':)',':(',':D',':O',':;']);


//^.*:|;.*|-|~D|\)$