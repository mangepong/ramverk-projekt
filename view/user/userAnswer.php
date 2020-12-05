<?php

namespace Anax\View;
?>

<div class="userQuestion">
    <div class="userQuestTitle">
        Titel: <a class="userQuestTitle" href="<?= url("question/view/{$question->id}"); ?>"><?= $question->title ?></a>
    </div>
    <div class="userQuestText">
        <p>Din kommentar: <?= $parsedText ?></p>
    </div>
</div>
