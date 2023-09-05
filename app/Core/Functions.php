<?php

namespace App\Core\Functions;

/** 
 * Obtener el tiempo que ha pasado
 * desde una fecha hasta hoy.
 * 
 * @param DateTime|string $time 
 * @return string
 */
function getAgo($time)
{
    // Si es un DateTime, convertirlo a String
    if (is_object($time)) {
        if (method_exists($time, 'format')) {
            $time = $time->format('Y-m-d H:i:s');
        }
    }

    $periods = array("segundo", "minuto", "hora", "dia", "semana", "mes", "año", "decada");
    $lengths = array("60", "60", "24", "7", "4.35", "12", "10");

    $now = time();

    $difference = $now - strtotime($time);

    for ($j = 0; $difference >= $lengths[$j] && $j < count($lengths) - 1; $j++) {
        $difference /= $lengths[$j];
    }

    $difference = round($difference);

    if ($difference != 1) {
        $periods[$j] .= "s";
    }

    return "hace $difference $periods[$j] ";
}

/** 
 * Limpiar cadenas
 * 
 * @param string $str 
 * @return string
 */
function cleanFields($str)
{
    return htmlspecialchars(strip_tags($str));
}

function getSlug($use = 'logout') //Funcion para obtener slug/etiqueta/parametro de la URL. Principalmente para regresar a la página que estaba antes de cerrar la sesión.
{
    if ($use == 'logout') {
        $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $slug = parse_url($url, PHP_URL_QUERY);
        if (strlen($slug) > 2) {
            if (str_contains($slug, 'topic')) {
                echo '?from=' . $slug;
            } else {
                echo '?from=' . $slug;
            }
        }
    } else {
        $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        return basename(parse_url($url, PHP_URL_PATH));
    }
}
