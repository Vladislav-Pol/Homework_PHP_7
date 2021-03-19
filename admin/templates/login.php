<div class="auth content">
    <h2>Для доступа к разделу необходима авторизация</h2>
</div>
<div class="main content">
    <form method="POST" class="auth" action="./">
        <input type="text" placeholder="login" name="login" value="" class="button"><br/>
        <input type="password" placeholder="password" name="password" class="button"><br/>
        <input type="submit" value="Войти" class="button">
    </form>
    <p><?=$authError??""?></p>
</div>

<?php
