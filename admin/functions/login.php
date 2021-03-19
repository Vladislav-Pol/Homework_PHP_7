<?php
$arData = parse_ini_file("$rootPath/admin/config.ini", true);

foreach ($arData as $user) {
    if (password_verify($_REQUEST['login'], $user['login']) &&
        password_verify($_REQUEST['password'], $user['password'])) {
        setcookie('auth', true, time() + $authAdminTime);
        header('Location: ./');
        break;
    }
}
if ($_REQUEST['login'])
    $authError = "Вы ввели неправильный логин или пароль";


