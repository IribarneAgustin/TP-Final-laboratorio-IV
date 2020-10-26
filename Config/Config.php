<?php namespace Config;

define("ROOT", dirname(__DIR__) . "/");   // raiz del proyecto definido como ROOT


// Cambiar Valor del FRONT_ROOT por el Root Directory de su propio Proyecto
define("FRONT_ROOT", "/TP-Final-laboratorio-IV/");
define("VIEWS_PATH", "Views/");
define("CSS_PATH", FRONT_ROOT. "Assets/css/");
define("JS_PATH", FRONT_ROOT. "Assets/js/");
define("IMG_PATH", FRONT_ROOT. "Assets/img/");

define("DB_HOST", "localhost");
define("DB_NAME", "cinemadb");
define("DB_USER", "root");
define("DB_PASS", "");