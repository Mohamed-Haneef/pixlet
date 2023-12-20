<?php

spl_autoload_register('autoLoad');

function autoLoad($className)
{
    include_once $_SERVER['DOCUMENT_ROOT']."/src/classIncludes/$className.class.php";
}

?>
<pre>
    <?echo $_SERVER['DOCUMENT_ROOT']?>
</pre>