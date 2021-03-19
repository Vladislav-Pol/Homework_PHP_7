<?php
// Блокировка прямого доступа к данному файлу из браузера
if(basename($_SERVER['DOCUMENT_URI']) == basename(__FILE__))
    header('Location: ./index.php');

//Путь к корню сайта
$siteDir = "";// "/Homework_PHP_6";

//Путь от корня диска до корня сайта
$rootPath = $_SERVER['DOCUMENT_ROOT'];
//Рабочий каталог от корня сайта
$path = $_REQUEST['path']?? "";
$fullPath = $rootPath . $path . "/";

//Список возможных типов файлов для создания и редактирования
define('FILE_TYPE', [
    'folder' => 'Папка',
    '.txt' => 'Файл .txt',
    '.html' => 'Файл .html',
    '.css' => 'Файл .css',
    '.js' => 'Файл .js'
]);

//Время действия авторизации в админке
$authAdminTime = 60 * 30; //30 минут

//Подготовка данных для редактирования элемента
if(isset($_REQUEST['edit'])){
    $edit = $_REQUEST['edit'];
    $fullFileName = $fullPath . $edit;
    if(is_file($fullFileName)) {
        $fileType = '.' . pathinfo($edit, PATHINFO_EXTENSION);
        $edit = pathinfo($edit, PATHINFO_FILENAME);
        $fileContent = file_get_contents($fullFileName);
    }
}
else
    $edit = false;

//Элемент для создания
$create = isset($_REQUEST['create']) ? true : false;

