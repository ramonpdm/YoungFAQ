<?php

namespace App\Helpers;

use App\Models\Category;
use App\Models\Topic;

class TopicPresentation
{
    /** 
     * Devolver el nombre de usuario 
     * como un link en HTML.
     * 
     * @param Category[] $categories
     * @return string
     */
    public static function categories(array $categories)
    {
        // Devolver una cadena vacía si no hay datos del usuario
        if (!is_array($categories)) {
            return '';
        }

        $html = '<span class="categories">';

        foreach ($categories as $category) {
            $html .= '<a href="/archive?category=' . $category->getID() . '" class="p-l-15"><i class="fa fa-list"></i>' . $category->getName() . '</a>';
        }

        $html .= '</span>';

        return $html;
    }
}
