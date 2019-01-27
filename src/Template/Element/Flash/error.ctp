<?php
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>
<div class="message error" onclick="this.classList.add('hidden');"></div>

<p class="bg-danger" style="font-size: 23px;"><?= $message ?></p>
