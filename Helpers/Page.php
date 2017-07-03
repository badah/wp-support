<?php

namespace StudioVisual\Support\Helpers;

class Page
{
    protected $parent;

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

    public function add($title, $is_parent = true)
    {
        $page_title = $title;
        $menu_title = $title;

        if (is_array($title)) {
            $menu_title = $title[1];
        }

        if (!function_exists('acf_add_options_page')) {
            return new WP_Error('dependency', MISSING_ACF);
        }

        if ($is_parent) {
            return $this->parent = acf_add_options_page([
                'page_title' => $page_title,
                'menu_title' => $menu_title,
                'redirect' => true,
            ]);
        }

        if (!$is_parent) {
            return acf_add_options_sub_page([
                'page_title' => $page_title,
                'menu_title' => $menu_title,
                'parent_slug' => $this->parent['menu_slug'],
            ]);
        }
    }

    public function setParentSlug($parent_slug)
    {
        $this->parent['menu_slug'] = $parent_slug;
    }

    public function getParentSlug()
    {
        return $this->parent['menu_slug'];
    }
}
