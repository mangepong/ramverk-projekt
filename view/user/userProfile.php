<?php

namespace Anax\View;
?>

<div>
<?php if (!$userInfo) : ?>
    <p>There is no user info.</p>
    <?php
    return;
endif;
?>
<div class="userProfile">
    <img class="profileImg" src="<?= "https://www.gravatar.com/avatar/" . md5(strtolower(trim($userInfo->email))) . "?d=" . urlencode("https://www.gravatar.com/avatar") . "&s=" . 150; ?>" alt="" />
    <div>
        <p><strong><?= $userInfo->acronym ?></strong></p>
        <p>Registrerad sedan: <i><?= $userInfo->created ?></i></p>
        <p><?= $userInfo->email ?></p>
        <?php if ($this->di->session->get('loggedIn') == $userInfo->id) : ?>
            <a class="commentBtn" href="<?= url("user/edit") ?>">Redigera</a>
            <a class="commentBtn" href="<?= url("user/logout") ?>">Logga ut <i class="fas fa-sign-out-alt"></i></a>
            <?php
        endif;
        ?>
    </div>
</div>
