HUD Housing Counseling Agencies
=======================

Introduction
------------
This is a simple web service used to retrieve a list of
nearby HUD-approved housing counseling agencies.

### Database Options
This application comes pre-configured to use SQLite with
the PDO driver. However, you may use any PDO-compatible
database by configuring it in the `config/autoload`
configuration files. A sample MySQL entry is included.
If you decide to use a custom database, the `data`
directory includes SQL to execute that will create the
schema needed for the application.

Installation
------------

### Using Git submodules
Alternatively, you can install using native git submodules:

    git clone git://github.com/bentigano/HUD_HCA.git --recursive

Web Server Setup
----------------

### PHP CLI Server

The simplest way to get started if you are using PHP 5.4 or above is to start the internal PHP cli-server in the root directory:

    php -S 0.0.0.0:8080 -t public/ public/index.php

This will start the cli-server on port 8080, and bind it to all network
interfaces.

**Note: ** The built-in CLI server is *for development only*.

### Apache Setup

To setup apache, setup a virtual host to point to the public/ directory of the
project and you should be ready to go! It should look something like below:

    <VirtualHost *:80>
        ServerName HUD_HCA.localhost
        DocumentRoot /path/to/HUD_HCA/public
        SetEnv APPLICATION_ENV "development"
        <Directory /path/to/HUD_HCA/public>
            DirectoryIndex index.php
            AllowOverride All
            Order allow,deny
            Allow from all
        </Directory>
    </VirtualHost>
