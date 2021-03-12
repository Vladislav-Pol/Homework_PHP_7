<?php
// Блокировка прямого доступа к данному файлу из браузера
//if(preg_match('/.*\/' . basename(__FILE__) . '$/', $_SERVER['DOCUMENT_URI']))header('Location: ./index.php');
if(basename($_SERVER['DOCUMENT_URI']) == basename(__FILE__))
    header('Location: ./index.php');
session_start();
//Путь к домашнему каталогу
$homeDir = $_SERVER['DOCUMENT_ROOT'] . "/Homework_PHP_6";
//Путь к рабочему каталогу
$workDir = getWorkDir($_SESSION['workDir'] ?? $homeDir);
$_SESSION['workDir'] = $workDir;
//Создание нового каталога
if(isset($_REQUEST['createDir'])) {
    createNewDir($_SESSION['workDir'], $_REQUEST['newDirName']);
}
//Создание нового файла
elseif(isset($_REQUEST['createFile'])) {
    $newFileName = $_SESSION['workDir'] . "/" . $_REQUEST['newFileName'];
    createNewFile($newFileName);
}
//Переименование папки или файла
elseif(isset($_REQUEST['renameDir'])) {
    renameElement($_REQUEST['selectFile'][0], $_SESSION['workDir'] . '/' . $_REQUEST['newNameRenameDir']);
}

//Удаление папки или файла
elseif(isset($_REQUEST['deleteDir'])) {
    deleteElement($_REQUEST['selectFile'][0]);
}

//Читает содержимое папки
$dirContent = (scandir($workDir));

//---------- Функции ----------

// --- Создание нового каталога ---
function createNewDir($Path, $NewDirName){
    $newPath = $Path . "/" . $NewDirName;
    if(!file_exists($newPath) && checkElementName($NewDirName, true))
        mkdir($newPath);
}

// --- Создание нового файла ---
function createNewFile($newFileName){
    if(!file_exists($newFileName)) {
        $fd = fopen($newFileName, "w");
        fclose($fd);
    }
}

// --- Переименование элемента ---
function renameElement($oldElementName, $newElementName){
    if (file_exists($oldElementName))
        rename($oldElementName, $newElementName);
}

// --- Удаление элемента ---
function deleteElement($element){
    if (file_exists($element))
        if(is_file($element))
            unlink($element);
        else{
            if(count(scandir($element)) <= 2)
                rmdir($element);
            else {
                $dd = opendir($element);
                while(($i = readdir($dd)) !== false){
                    if ($i == "." || $i == "..") continue;
                    deleteElement($element."/".$i);
                }
                closedir($dd);
                rmdir($element);
            }
        }
}

// --- Получить адрес рабочего каталога ---
function getWorkDir($oldWorkDir){
    $newWorkDir = $oldWorkDir;
    if(isset($_REQUEST['home']))
        $newWorkDir = $GLOBALS['homeDir'];

    elseif(isset($_REQUEST['open']) && isset($_REQUEST['selectFile'])) {
        $preg = '/(.*[^.]{2}$)|(.+)\/[^\/.]*\/\.{2}$|(.+)\/\.{1,2}/';
        preg_match_all($preg, $_REQUEST['selectFile'][0], $arPregResult, PREG_SET_ORDER);
        $newWorkDir = array_pop($arPregResult[0]);
    }

    return $newWorkDir;
}

// --- Проверка имени нового элемента ---
function checkElementName($name, $folder = false){ //todo не реализовано

    return true;
}
