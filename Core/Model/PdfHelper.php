<?php


namespace Projet\Model;

class PdfHelper{

    public static function render($path,$variables = []){
        ob_start();
        extract($variables);
        require($path);
        $html = ob_get_contents();
        ob_get_clean();
        return $html;
    }

}
