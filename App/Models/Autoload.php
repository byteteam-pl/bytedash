<?php
spl_autoload_register(function ($name) {
    $byte = <<<END
        Byte\
        END;
    $name = str_replace($byte, "", $name);
    require $name . '.php';
});
