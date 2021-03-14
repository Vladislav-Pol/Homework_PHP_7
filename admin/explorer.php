<?php
// Блокировка прямого доступа к данному файлу из браузера
//if(preg_match('/.*\/' . basename(__FILE__) . '$/', $_SERVER['DOCUMENT_URI']))header('Location: ./index.php');
if(basename($_SERVER['DOCUMENT_URI']) == basename(__FILE__))
    header('Location: ./index.php');

//Путь к корню сайта
$siteDir = "/Homework_PHP_6";

//Путь от корня диска до корня сайта
$rootPath = $_SERVER['DOCUMENT_ROOT'];
//Рабочий каталог от корня сайта
$path = $_REQUEST['path']?? "";
$fullPath = $rootPath . $path;

define('FILE_TYPE', [
    'folder' => 'Папка',
    '.txt' => 'Файл .txt',
    '.html' => 'Файл .html',
    '.css' => 'Файл .css',
    '.js' => 'Файл .js'
]);

//Подготовка данных для редактирования элемента
if(isset($_REQUEST['edit'])){
    $fileName = $_REQUEST['edit'];
    $fullFileName = $fullPath . "/" . $fileName;
    if(is_file($fullFileName)) {
        $fileName = pathinfo($fileName, PATHINFO_FILENAME);
        $fileType = '.' . pathinfo($_REQUEST['edit'], PATHINFO_EXTENSION);
        $fileContent = file_get_contents($fullFileName);
    }
}

//Запись загруженного файла
if(isset($_REQUEST['isUpload'])) {
    saveUploadFile($fullPath);
}

//Создание элемента
if(isset($_REQUEST['saveNewElement'])) {
    if($_REQUEST['extension'] == 'folder')
        createNewFolder($fullPath, $_REQUEST['fileName']);
    else
        createNewFile($fullPath, $_REQUEST['fileName'], $_REQUEST['extension'], $_REQUEST['fileContent'] ?? "");
}

//Изменение элемента
if(isset($_REQUEST['saveElement'])) {
    if($_REQUEST['extension'] == 'folder')
        renameFolder($fullPath . "/" . $_REQUEST['oldName'], $fullPath . "/" . $_REQUEST['fileName']);
    else
        editFile($fullPath, $_REQUEST['oldName'] . $_REQUEST['oldFileExtension'], $_REQUEST['fileName'] . $_REQUEST['extension'], $_REQUEST['fileContent'] ?? "");
}

//Удаление папки или файла
if(isset($_REQUEST['del'])){
    deleteElement($fullPath . $_REQUEST['del']);
}

//Получает содержимое каталога
$dirContent = (scandir(realpath($fullPath)));

////////////////////////////////////////////
//---------- Функции ----------

// --- Создание нового каталога ---
function createNewFolder($path, $NewDirName){
    $newPath = $path . "/" . $NewDirName;
    if(!file_exists($newPath))
        mkdir($newPath);
}

// --- Создание нового файла ---
function createNewFile($path, $newFileName, $extension, $newFileContent){
    $newFilePath = $path . "/" . $newFileName . $extension;
    if(!file_exists($newFilePath)) {
        $fd = fopen($newFilePath, "w");
        fwrite($fd, $newFileContent);
        fclose($fd);
    }
}

// --- Переименование каталога ---
function renameFolder($oldElementName, $newElementName){
    if (file_exists($oldElementName) && !file_exists($newElementName))
        rename($oldElementName, $newElementName);
}

// --- Изменение элемента ---
function editFile($fullPath, $oldName, $newName, $fileContent){
    if($oldName != $newName){
        rename($fullPath . "/" . $oldName, $fullPath . "/" . $newName);
    }

    file_put_contents($fullPath . "/" . $newName, $fileContent);
}

// --- Удаление элемента ---
function deleteElement($element){
    if (is_file($element))
        unlink($element);
    elseif (is_dir($element)){
        if (count(scandir($element)) <= 2)
            rmdir($element);
        else {
            $dd = opendir($element);
            while (($i = readdir($dd)) !== false) {
                if ($i == "." || $i == "..") continue;
                deleteElement($element . "/" . $i);
            }
            closedir($dd);
            rmdir($element);
        }
    }
}

// --- Обрезка лишних символов в пути ---
function cleanPath($path = ""){
    $preg = '/\/[^\/.]*\/\.{2}$|\/.$|^\/..$/';
    $path = preg_replace($preg, "", $path);
    return $path;
}

//Проверка возможности изменять элемент
function canEdit($element){
    if(is_dir($element) &&
      substr($element, -2) != "..")
        return 'dir';

    if(is_file($element) &&
        array_key_exists("." . pathinfo($element, PATHINFO_EXTENSION), FILE_TYPE))
        return 'file';

    return false;
}

//Сохранение загруженного файла
function saveUploadFile($fullPath){
    if(!empty($_FILES['uploadFiles']['name'])){
        foreach ($_FILES['uploadFiles']['tmp_name'] as $index => $tmpPath){
            if(file_exists($tmpPath)){
                $fileName = $_FILES['uploadFiles']['name'][$index];
                $fileName = getAvailableName($fileName);
                $fullFileName = $fullPath . "/" . $fileName;
                while(file_exists($fullFileName)){
                    $posToAdd = mb_strrpos($fullFileName, '.')?: mb_strlen($fullFileName)-1;
                    $arFullFileName = preg_split('//u', $fullFileName, null, PREG_SPLIT_NO_EMPTY);
                    array_splice($arFullFileName, $posToAdd, 0, ["_1"] );
                    $fullFileName = implode("", $arFullFileName);
                };

                move_uploaded_file($tmpPath, $fullFileName);
            }
        }
    }
}

//Получение размера файла
function getFileSize($file){
    if(is_dir($file))
        return "";
    $size = filesize($file) / 1024;
    if($size > 1024-1) {
        $size /= 1024;
        return round($size, 2) . " МБ";
    }
    else
        return round($size, 2) . " КБ";
}

//получение даты создания
function getFileDate($file){
    if(file_exists($file)){
        return date("m.d.Y H:i:s", filectime($file));
    }
    $date = filectime($file);
    return $date;
}

//Редактирование имени файла/папки
function getAvailableName($name){
    $arr_changes = [
        'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd',
        'е' => 'e', 'ё' => 'e', 'ж' => 'zh', 'з' => 'z', 'и' => 'i',
        'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n',
        'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't',
        'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c', 'ч' => 'ch',
        'ш' => 'sh', 'щ' => 'sch', 'ь' => '', 'ы' => 'y', 'ъ' => '',
        'э' => 'e', 'ю' => 'yu', 'я' => 'ya',

        'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D',
        'Е' => 'E', 'Ё' => 'E', 'Ж' => 'Zh', 'З' => 'Z', 'И' => 'I',
        'Й' => 'Y', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N',
        'О' => 'O', 'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T',
        'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C', 'Ч' => 'Ch',
        'Ш' => 'Sh', 'Щ' => 'Sch', 'Ь' => '', 'Ы' => 'Y', 'Ъ' => '',
        'Э' => 'E', 'Ю' => 'Yu', 'Я' => 'Ya',
    ];
    $preg = '/[^\w\-\.]+/';

    $name = strtr($name, $arr_changes);
    $name = preg_replace($preg, '_', $name);

    return $name;
}
