<?php
if(isset($_SESSION['user_id'])){
    unset($_SESSION['user_id']);
}

header('Location: ./?page=login');
?>

<a href="./?page=logout">Logout</a>

<a href="javascript:void(0)" onclick="confirmLogout('./?page=logout')">
    <svg ...>...</svg> Logout
</a>