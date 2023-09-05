<?php

namespace App\Helpers;

use App\Models\User;

class UserPresentation
{
    /** 
     * Devolver el nombre de usuario 
     * como un link en HTML.
     * 
     * @param User $user
     * @return string
     */
    public static function username(User $user)
    {
        // Devolver una cadena vacía si no hay datos del usuario
        if (!is_object($user) || empty($user)) {
            return '';
        }

        $html = '<span class="user_name">';

        if ($user->isAdmin()) {
            $html .= '<a class="d-flex-j-center-a-center" style="color: var(--thm-base);" href="/archive?user=' . $user->getID() . '">';
            $html .= '<i class="fa fa-star" style="color: var(--thm-base);"></i>';
            $html .= '<span style="font-weight: bold;">' . $user->getUsername() . '</span>';
            $html .= '</a>';
        } else {
            $html .= '<a class="d-flex-j-center-a-center" style="color: var(--thm-gray-1);" href="/archive?user=' . $user->getID() . '">';
            $html .= '<i class="fa fa-user"></i>';
            $html .= '<span>' . $user->getUsername() . '</span>';
            $html .= '</a>';
        }
        $html .= '</span>';

        return $html;
    }
}
