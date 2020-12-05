<?php

namespace Anax\View;
?>

<div class="answers">
    <div class ="aUser">
        <p class="qAcro"><strong><a href="<?= url("user/profile/{$userInfo->id}"); ?>"> <?= $userInfo->acronym ?></a></strong></p>
        <img class="aUserImg" src="<?= "https://www.gravatar.com/avatar/" . md5(strtolower(trim($userInfo->email))) . "?d=" . urlencode("https://www.gravatar.com/avatar") . "&s=" . 150; ?>" alt="" />
    </div>
    <div class="aText"><?= $parsedText ?></div>
    <a class="commentBtn" href="<?= url("question/comment?question={$answer->questionid}&answer={$answer->id}"); ?>">Kommentera</a>
</div>
