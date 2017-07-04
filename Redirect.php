<?php

namespace StudioVisual\Support;

class Redirect
{
    static public function toAdmin($destination) {
        if(wp_redirect(admin_url($destination))) {
            exit;
        }
    }
}