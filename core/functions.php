<?php

function getAgo($time) //Función para obtener el tiempo que ha pasado desde que se creó/aprobó una publicación.
{
    date_default_timezone_set('America/Santo_Domingo');
    $periods = array("second", "min", "hour", "day", "week", "month", "year", "decade");
    $lengths = array("60", "60", "24", "7", "4.35", "12", "10");

    $now = time();

    $difference     = $now - strtotime($time);
    $tense         = "ago";

    for ($j = 0; $difference >= $lengths[$j] && $j < count($lengths) - 1; $j++) {
        $difference /= $lengths[$j];
    }

    $difference = round($difference);

    if ($difference != 1) {
        $periods[$j] .= "s";
    }

    return " $difference $periods[$j] ago ";
}

function getSlug($use = 'logout') //Funcion para obtener slug/etiqueta/parametro de la URL. Principalmente para regresar a la página que estaba antes de cerrar la sesión.
{
    if ($use == 'logout') {
        $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $slug = parse_url($url, PHP_URL_PATH);
        if (strlen($slug) > 2){
            echo '?from='.$slug;
        }
    }else{
        $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        return basename(parse_url($url, PHP_URL_PATH));
    }
}


