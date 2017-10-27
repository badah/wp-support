<?php

namespace Badah\WpSupport\Components;

class Page
{
    public static function isLogin()
    {
        return 'wp-login.php' === $GLOBALS['pagenow']
            || '/login' === $_SERVER['REQUEST_URI']
            || '/login-dev' === $_SERVER['REQUEST_URI'];
    }

    public static function isLogout()
    {
        return isset($_REQUEST['action']) && 'logout' === $_REQUEST['action'];
    }
}
