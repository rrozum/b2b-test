<?php

spl_autoload_register(function ($className) {
    $path = str_replace('\\', '/', $className);

    require_once sprintf('%s/%s.php', __DIR__, $path);
});
