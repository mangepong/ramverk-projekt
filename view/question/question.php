<?php

namespace Anax\View;
?>

<?php if (!$question) : ?>
    <p class="errTxt">Denna fråga finns ej.</p>
<?php
return;
endif;
?>
<div class="question">
    <h1 class="qTitle"><?= $question->title ?></h1>
    <div class ="qUser">
        <p class="qAcro">
            <a href="<?= url("user/profile/{$userInfo->id}"); ?>"> <?= $userInfo->acronym ?></a>
        </p>
        <img class="qUserImg" src="<?= "https://www.gravatar.com/avatar/" . md5(strtolower(trim($userInfo->email))) . "?d=" . urlencode("https://www.gravatar.com/avatar") . "&s=" . 150; ?>" alt="" />
        <p class="qCreated">Skapad: <?= $question->created ?></p>
    </div>


    <div class="qText"><?= $parsedText ?></div>
    <div class="qTags">
        <ul>
    <?php foreach ($tags as $tag) : ?>
            <li class="qTag"><a href="<?= url("tags/view/{$tag->text}"); ?>"><?= $tag->text ?></a></li>
    <?php endforeach; ?>
        </ul>
    </div>
    <hr>
</div>

<p><b>Kommentarer:</b></p>
