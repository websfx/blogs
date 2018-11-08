<?php
define("APP_PATH", __DIR__);

spl_autoload_register(function ($file) {
    $file = str_replace('\\', '/', trim($file, 'App'));

    $filePath = APP_PATH.$file.".php";

    if (!file_exists($filePath)) {
        throw new Exception("$filePath 不存在");
    }

    include $filePath;
});
