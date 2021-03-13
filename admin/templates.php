<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0">
    <link rel="stylesheet" href="/Homework_PHP_6/css/style.css">
    <title>Document</title>
</head>
<body>
<div class="header content">
    <div class="logo">#Мой сайт#</div>
    <a href="#">#Войти/выйти#</a>
</div>
<div class="fileMen content">
    <h2>Файловая стуктура сайта</h2>
    <div class="functions">
        <a href="./" class="button">Домой</a>
        <button name="createDir" form="form1">Создать</button>
<!--        <input type="text" name="newDirName" form="form1" placeholder="введите название каталога">-->
<!--        <button name="createFile" form="form1">Создать новый файл</button>-->
<!--        <input type="text" name="newFileName" form="form1" placeholder="введите название каталога">-->
    </div>

</div>
<div class="main content">
    <span><?=$path;?></span><br/><br/>
    <table class="elementList">
        <tbody>
            <? foreach ($dirContent as $key => $item):
                if($key < 1) continue;?>
                <tr>
                    <td class="actions">
                        <?if($item != ".."):?>
                        <a href="#"><img src="/Homework_PHP_6/img/edit.png"></a>
                        <?endif;?>
                        <?if($item != ".."):?>
                        <a href="./?path=<?="$path&del=/$item"?>"><img src="/Homework_PHP_6/img/delete.png"></a>
                        <?endif;?>
                    </td>
                    <td class="element">
                        <a href="./?path=<?=cleanPath($path . "/" . $item)?>"></a>
                        <?$imgType = is_file($fullPath . $item) ? "file" : "folder";?>
                        <img src="/Homework_PHP_6/img/<?=$imgType?>.png" alt="<?=$imgType?>">
                        <?= $item ?>
                    </td>
               </tr>
            <?endforeach; ?>
        </tbody>
    </table>

    <button name="deleteDir" form="form1">Удалить выбранный каталог или файл</button>
    <br/>
    <button name="renameDir" form="form1">Переименовать выбранный каталог или файл</button>
    <input type="text" name="newNameRenameDir" form="form1" placeholder="введите новое название каталога"><br/>


</div>
</body>
</html>
<?php
