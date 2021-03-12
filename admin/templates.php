<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0">
    <link rel="stylesheet" href="/Homework_PHP_6/css/style.css">
    <title>Document</title>
</head>
<body>
<div class="functionMenu content">
    <button name="home" form="form1">Домой</button>
    <button name="open" form="form1">Открыть каталог</button>
</div>
<div class="main content">
    <span><?= $workDir; ?></span>
    <form id="form1" method="post">
        <input type="text" name="dd" value="<?= $workDir; ?>" class="display_none">
        <select name="selectFile[]" size="<?= count($dirContent) ?>">
            <? foreach ($dirContent as $key => $item): ?>
                <option value="<?= $workDir ?>/<?= $item ?>"
                    <?= $key == 0 ? "selected hidden" : "" ?> class="<?= is_file($workDir . "/" . $item) ? "file" : "folder" ?>">
                    <?= $item; ?>
                </option>
            <?endforeach; ?>
        </select>
    </form>
    <button name="deleteDir" form="form1">Удалить выбранный каталог или файл</button>
    <br/>
    <button name="renameDir" form="form1">Переименовать выбранный каталог или файл</button>
    <input type="text" name="newNameRenameDir" form="form1" placeholder="введите новое название каталога"><br/>
    <button name="createDir" form="form1">Создать новый каталог</button>
    <input type="text" name="newDirName" form="form1" placeholder="введите название каталога"><br/>
    <button name="createFile" form="form1">Создать новый файл</button>
    <input type="text" name="newFileName" form="form1" placeholder="введите название каталога"><br/>


</div>
</body>
</html>
<?php
