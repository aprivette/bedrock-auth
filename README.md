# Bedrock Auth

A WordPress plugin designed to be an addon to the [Bedrock](https://roots.io/bedrock/) WordPress framework.

It adds environment-specific basic authentication to WordPress sites. There are a few use cases for this.  For example, if you were to set up a staging site and only wanted to protect only this setup while not affecting version control, then this package could be of use.  Alternatively, you can exclusively protect wp-login.php to protect against brute force attacks.

## Setup

1. Add the package to your bedrock installation with `composer require aprivette/bedrock-auth`.
2. Activate the plugin in WordPress.
3. Add the `BASIC_AUTH_USER` and `BASIC_AUTH_PASS` variables to your .env file.
4. Choose an authentication level by setting the `BASIC_AUTH_LEVEL` variable to either site or login.  Choosing site will require auth for the entire site while login will exclusively protect wp-login.php.
5. Navigate to the site and it should require you to login.