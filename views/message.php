<?php if ($msg) : ?>
            <div class="message <?= $msg['type'] ?>">
                <?= $msg['text'] ?>
            </div>

<?php endif ?>