<?php
// Блокировка прямого доступа к данному файлу из браузера
if(basename($_SERVER['DOCUMENT_URI']) == basename(__FILE__))
    header('Location: ./index.php');

//Проверка авторизации
function isAuthorized(){
    return $_COOKIE['auth'] ?: false;
}

//Проверка возможности изменять элемент
function canEdit($element){
    if(is_dir($element) &&
        substr($element, -2) != "..") // Запрет изменения родительского каталога
        return 'dir';

    if(is_file($element) &&
        array_key_exists("." . pathinfo($element, PATHINFO_EXTENSION), FILE_TYPE))
        return 'file';

    return false;
}

//получение даты создания
function getFileDate($file){
    if(file_exists($file))
        return date("m.d.Y H:i:s", filectime($file));
    return "";
}

//Получение размера файла
function getFileSize($file){
    if(is_dir($file))
        return "";
    $size = filesize($file) / 1024; // Размер файла в КБ
    if($size > 1024-1) {
        $size /= 1024; // Размер файла в МБ
        return round($size, 2) . " МБ";
    }
    else
        return round($size, 2) . " КБ";
}

// --- Обрезка лишних символов в пути ---
function cleanPath($path = ""){
    $preg = '/\/[^\/.]*\/\.{2}$|\/.$|^\/..$/';
    $path = preg_replace($preg, "", $path);
    return $path;
}
