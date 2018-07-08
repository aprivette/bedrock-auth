<?php
/**
 * @package WP Bedrock Auth
 * @version 1.0.1
 */
/*
Plugin Name: WP Bedrock Auth
Plugin URI: https://github.com/aprivette/bedrock-auth
Description: Environment-specific basic auth for the Bedrock WordPress framework.
Author: Adam Privette
Version: 1.0.1
Author URI: http://www.dcwebmarketing.com/
*/

namespace BedrockAuth;

use Dotenv;
use Env;

class BasicAuth
{
    public function __construct()
    {
        $this->root_dir = dirname(dirname(ABSPATH));
        $this->dotenv = new Dotenv\Dotenv($this->root_dir);

        Env::init();
    }

    public function initAuth()
    {
        if (file_exists($this->root_dir . '/.env')) {
            if (env('BASIC_AUTH_USER') && env('BASIC_AUTH_PASS')) {
                $this->dotenv->load();
                $this->dotenv->required(['BASIC_AUTH_USER', 'BASIC_AUTH_PASS']);
                $this->requireAuth(env('BASIC_AUTH_USER'), env('BASIC_AUTH_PASS'));
            }
        }
    }

    // Adapted from https://gist.github.com/rchrd2/c94eb4701da57ce9a0ad4d2b00794131
    private function requireAuth($user, $pass) {
        add_action('send_headers', function() {
            header('Cache-Control: no-cache, must-revalidate, max-age=0');
        });

        $has_supplied_credentials = !(empty($_SERVER['PHP_AUTH_USER']) && empty($_SERVER['PHP_AUTH_PW']));

        $is_not_authenticated = (
            !$has_supplied_credentials ||
            $_SERVER['PHP_AUTH_USER'] != $user ||
            $_SERVER['PHP_AUTH_PW']   != $pass
        );

        if ($is_not_authenticated) {
            add_action('send_headers', function() { 
                header('HTTP/1.1 401 Authorization Required');
                header('WWW-Authenticate: Basic realm="Access denied"');
                wp_die(
                    'Access denied.',
                    'Authorization Required',
                    array('response' => 401)
                );
            });
        }
    }
}

$bedrock = new BasicAuth();
$bedrock->initAuth();
