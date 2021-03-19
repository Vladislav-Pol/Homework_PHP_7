<?php
// Блокировка прямого доступа к данному файлу из браузера
if(basename($_SERVER['DOCUMENT_URI']) == basename(__FILE__))
    header('Location: ./index.php');

//Сохранение загруженного файла
function saveUploadFile($fullPath){
    if(!empty($_FILES['uploadFiles']['name'])){
        $arFiles = $_FILES['uploadFiles'];
        foreach ($arFiles['tmp_name'] as $index => $tmpPath){
            if(file_exists($tmpPath)){
                $fileName = $arFiles['name'][$index];
                $fileName = getAvailableName($fileName);
                $fullFileName = $fullPath . $fileName;
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
