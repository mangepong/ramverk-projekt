<?php

namespace Anax\View;
?>

<div class="userQuestion">
    <div class="userQuestTitle">
        Titel: <a href="<?= url("question/view/{$question->id}"); ?>"> <?= $question->title ?></a>
    </div>
    <div class="userQuestText">
        <p><?= $parsedText ?></p>
    </div>
</div>
