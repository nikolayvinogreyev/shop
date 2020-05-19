<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/scripts/index/getPages.php');

?>

<?php for ($i = 1; $i <= $pagesCount; $i++): ?>
    <li>
        <a class="paginator__item" href="<?= $i ?>"><?= $i ?></a>
    </li>
<?php endfor; ?>
