<?php
class Config
{
    public static $rdsDomain = "phplogs.whotrades.net";
    public static $workerName = null;
    public static $debug = false;
}

if (file_exists(__DIR__."/config.local.php")) {
	include(__DIR__."/config.local.php");
}

if (Config::$workerName === null) {
    die("\e[0;31m[ERROR]\e[0;49m Setup Config::workerName first at \e[1;37mconfig.local.php \n");
}