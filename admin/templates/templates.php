<div class="fileMen content">
    <h2>Файловая стуктура сайта</h2>
    <div class="functions">
        <a href="./" class="button">Домой</a>
        <a href="./?path=<?="$path&create="?>" class="button">Создать</a>
        <a href="./?path=<?="$path&upload="?>" class="button">Загрузить файл</a>
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
                        <a href="./?path=<?="$path&del=/$item"?>"><img src="/Homework_PHP_6/img/delete.png" alt="delete"></a>
                        <?endif;?>
                        <?if(canEdit($fullPath . "/" .$item)):?>
                            <a href="./?path=<?="$path&edit=$item"?>"><img src="/Homework_PHP_6/img/edit.png" alt="edit"></a>
                        <?endif;?>
                    </td>
                    <td class="element">
                        <?if(is_dir($fullPath . "/" .$item)):?>
                        <a href="./?path=<?=cleanPath($path . "/" . $item)?>">
                            <img src="/Homework_PHP_6/img/folder.png" alt="folder">
                            <?= $item ?>
                        </a>
                        <?else:?>
                        <p>
                            <img src="/Homework_PHP_6/img/file.png" alt="file">
                            <?= $item ?>
                        </p>
                        <?endif;?>
                    </td>
                    <td>
                        <div class="size">
                            <div><?=getFileSize($fullPath . "/" .$item)?></div>
                        </div>
                    </td>
                    <td>
                        <div class="date">
                            <div><?=getFileDate($fullPath . "/" .$item)?></div>
                        </div>
                    </td>
               </tr>
            <?endforeach; ?>
        </tbody>
    </table>

</div>
<?php
