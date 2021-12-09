<?php

class Md5PasswordRemover
{
    /** @var bool  */
    private static $initiated = false;

    public static function init() {
        if ( ! self::$initiated ) {
            self::init_hooks();
        }
    }

    private static function init_hooks() {
        add_filter('wp_authenticate_user', array('Md5PasswordRemover', 'wp_authenticate_user'), 10, 2);
    }

    /**
     * @param $user WP_User|WP_Error
     * @param $password string
     * @return WP_User|WP_Error
     */
    public function wp_authenticate_user($user, $password) {
        if($user instanceof WP_Error) {
            return $user;
        }

        if(!hash_equals( $user->user_pass, md5($password))) {
            return $user;
        }

        // As MD5 is not secure, we set the password to a random string.
        // User can use "Forget Password" form to generate a new secure password
        try {
            wp_set_password(random_bytes(24), $user->ID);
        }
        catch (Exception $exception) {
            error_log($exception->getMessage());
        }

        return new WP_Error(
            'incorrect_password',
            sprintf(
                __( '<strong>Error</strong>: The password you entered for the username %s is incorrect.' ),
                '<strong>' . $user->user_login . '</strong>') .
            '<a href="' . wp_lostpassword_url() . '">' . __( 'Lost your password?' ) . '</a>'
        );
    }
}
