<?php
setcookie('auth', '', time() - 10, "/admin");
header('Location: ../');
