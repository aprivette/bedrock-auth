# Bedrock Auth

A WordPress plugin designed to be an addon to the [Bedrock](https://roots.io/bedrock/) WordPress framework.

It adds environment-specific basic authentication to WordPress sites. For example, if you were to set up a staging site and only wanted to protect only this setup while not affecting version control, then this package could be of use.

## Setup

1. Add the package to your bedrock installation with `composer require aprivette/bedrock-auth`.
2. Add the `BASIC_AUTH_USER` and `BASIC_AUTH_PASS` variables to your .env file.
3. Navigate to the site and it should require you to login.