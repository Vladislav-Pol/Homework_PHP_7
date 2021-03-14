<?php
require_once './explorer.php';

require_once './templates/header.php';

if(isset($_REQUEST['create']) || isset($_REQUEST['edit']))
    require_once './templates/create_edit.php';
elseif(isset($_REQUEST['upload']))
    require_once './templates/uploadFole.php';
else
    require_once './templates/templates.php';

require_once './templates/footer.php';
