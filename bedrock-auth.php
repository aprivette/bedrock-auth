<?php
/**
 * @package WP Bedrock Auth
 * @version 1.0.0
 */
/*
Plugin Name: WP Bedrock Auth
Plugin URI: https://github.com/aprivette/wp-bedrock-auth
Description: This plugin is designed to work with the bedrock-auth composer package.  Check https://github.com/aprivette/bedrock-auth for details.
Author: Adam Privette
Version: 1.0.0
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

    private function requireAuth($AUTH_USER, $AUTH_PASS) {
        header('Cache-Control: no-cache, must-revalidate, max-age=0');

        $has_supplied_credentials = !(empty($_SERVER['PHP_AUTH_USER']) && empty($_SERVER['PHP_AUTH_PW']));

        $is_not_authenticated = (
            !$has_supplied_credentials ||
            $_SERVER['PHP_AUTH_USER'] != $AUTH_USER ||
            $_SERVER['PHP_AUTH_PW']   != $AUTH_PASS
        );

        if ($is_not_authenticated) {
            header('HTTP/1.1 401 Authorization Required');
            header('WWW-Authenticate: Basic realm="Access denied"');
            exit;
        }
    }
}

$bedrock = new BasicAuth();
$bedrock->initAuth();
