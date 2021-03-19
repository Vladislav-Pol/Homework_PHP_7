<?php
// Блокировка прямого доступа к данному файлу из браузера

if (basename($_SERVER['DOCUMENT_URI']) == basename(__FILE__))
    header('Location: ./index.php');

require_once 'variables.php';
require_once './functions/main.php';

//Проверка авторизации
if (!isAuthorized()) {
    require_once './functions/login.php';
}
else {
    require_once './functions/crud.php';

    //Изменение элемента
    if
    (isset($_REQUEST['saveElement'])) {
        if ($_REQUEST['extension'] == 'folder')
            renameFolder($fullPath . $_REQUEST['oldName'], $fullPath . $_REQUEST['fileName']);
        else
            editFile($fullPath, $_REQUEST['oldName'] . $_REQUEST['oldFileExtension'], $_REQUEST['fileName'] . $_REQUEST['extension'], $_REQUEST['fileContent'] ?? "");
    } //Создание элемента
    elseif (isset($_REQUEST['saveNewElement'])) {
        if ($_REQUEST['extension'] == 'folder')
            createNewFolder($fullPath, $_REQUEST['fileName']);
        else
            createNewFile($fullPath, $_REQUEST['fileName'], $_REQUEST['extension'], $_REQUEST['fileContent'] ?? "");
    } //Удаление папки или файла
    elseif (isset($_REQUEST['del'])) {
        deleteElement($fullPath . $_REQUEST['del']);
    } //Запись загруженного файла
    elseif (isset($_REQUEST['isUpload'])) {
        require_once './functions/upload.php';
        saveUploadFile($fullPath);
    }
}

//Получение содержимого каталога
$dirContent = (scandir(realpath($fullPath)));

//Определение шаблона для подключения
if (!isAuthorized())
    $contentTemplate = './templates/login.php';
elseif ($create || $edit)
    $contentTemplate = './templates/create_edit.php';
elseif (isset($_REQUEST['upload']))
    $contentTemplate = './templates/uploadFile.php';
else
    $contentTemplate = './templates/templates.php';
