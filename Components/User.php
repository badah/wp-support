<?php

namespace StudioVisual\Support\Components;

class User
{
    public static function exist($email)
    {
        if ($id = email_exists($email)) {
            return $id;
        }
        return false;
    }

    public static function createUser($user, $role, $fields = [])
    {
        // Generate the password and create the user
        $password = wp_generate_password(12, false);
        $user_id = wp_create_user($user['email_address'], $password, $user['email_address']);

        // Set the nickname
        wp_update_user([
            'ID'           => $user_id,
            'nickname'     => $user['email_address'],
            'first_name'   => $user['info']['name'],
            'display_name' => $user['info']['name'],
        ]);

        // Set the role
        $user = new \WP_User($user_id);
        $user->set_role($role);

        if (is_array($fields)) {
            foreach ($fields as $key => $field) {
                update_user_meta( $user_id, $key, $field );
            }
        }

        return $user_id;
    }

    public static function login($user_id)
    {
        $user = get_user_by('id', $user_id);
        if ($user) {
            wp_set_current_user($user_id, $user->user_login);
            wp_set_auth_cookie($user_id);
            do_action('wp_login', $user->user_login, $user);
        }
    }

    public static function logout()
    {
        wp_logout();
    }

    public static function isApi()
    {
        $user_id = get_current_user_id();
        $user_api = get_user_meta( $user_id, $key = 'api_user', true );

        if ($user_api) {
            return true;
        }
        return false;
    }

}
