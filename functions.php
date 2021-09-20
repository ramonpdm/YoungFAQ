<?php 

function get_template_part($file){
    include(dirname( __FILE__ ).'/require/template/'.$file.'.php');
}

function get_title(){
    $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $slug = basename(parse_url($url, PHP_URL_PATH));
    if ($slug == 'services')
    {
        echo ucwords('Servicios');
    }
    else
    {
        echo ucwords($slug);
    }
}

function what_page_is($slug){
    if (get_title() == ucwords($slug)){
        return true;
    }else{
        return false;
    }
}

function get_code($from, $code){
    if(what_page_is($from)){
        if ($from || $code){
            echo $code;
            echo 'es from';
        }else{
            echo 'no es from';
        }
    }
    
}

function send_code($from, $code){

}

function include_code($from, $where, $code){
    if ($from || $where || $code){
        send_code($from, $code);
    }
}



?>