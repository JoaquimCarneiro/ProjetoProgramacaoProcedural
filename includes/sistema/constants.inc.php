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

/* LOGIN CONSTANTS */
const HIDE_CREDENCIALS = false; //defeito false

/* REGISTER CONSTANTS */
const REGISTER_SEND_EMAIL = false; //defeito true

/* SMTP EMAIL CONSTANTS */
const SMTP_PORT = 25;
// const SMTP_HOST = '';
// const SMTP_USERNAME = '';
// const SMTP_PASS = '';




/***** OVERRIDDEN CONSTANTS *****/
if(file_exists(__DIR__."/secrets.php")){
    require __DIR__."/secrets.php";
}
