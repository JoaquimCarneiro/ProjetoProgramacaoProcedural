<?php
/* SITE CONSTANTS*/

const SITE_TITLE = "LoginSys";
const SITE_SUBTITLE = "Sistema de Login procedural";

const SITE_ROOT = "http://loginsys.arg/";

/* DATABASE CONSTANTS */

const DB_SERVER = "localhost";
const DB_USER = "verysafeuser";
const DB_PWD = "verysafepassword";
const DB_NAME = "loginsysproc";

/* FORM CONSTANTS */

const HIDE_CREDENCIALS = false;

/* SMTP EMAIL CONSTANTS */

if(file_exists(__DIR__."/secrets.php")){
    require __DIR__."/secrets.php";
}else{
    define('SMTP_HOST', '');
    define('SMTP_USERNAME', '');
    define('SMTP_PASS', '');
}
const SMTP_PORT = 25;
