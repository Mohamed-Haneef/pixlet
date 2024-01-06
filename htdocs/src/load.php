<?php

spl_autoload_register('autoLoad');

function autoLoad($className)
{
    include_once $_SERVER['DOCUMENT_ROOT']."/src/classIncludes/$className.class.php";
}

$WebAPI = new WebAPI();
$token_authenticated = $WebAPI->initiatesession();
