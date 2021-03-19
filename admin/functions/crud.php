<?php

// Блокировка прямого доступа к данному файлу из браузера
if(basename($_SERVER['DOCUMENT_URI']) == basename(__FILE__))
    header('Location: ./index.php');

// --- Создание нового каталога ---
function createNewFolder($path, $NewDirName){
    $newPath = $path . $NewDirName;
    if (!file_exists($newPath))
        mkdir($newPath);
}

// --- Создание нового файла ---
function createNewFile($path, $newFileName, $extension, $newFileContent){
    $newFilePath = $path . $newFileName . $extension;
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

// --- Изменение файла ---
function editFile($fullPath, $oldName, $newName, $fileContent){
    if($oldName != $newName){
        rename($fullPath . $oldName, $fullPath . $newName);
    }

    file_put_contents($fullPath . $newName, $fileContent);
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



