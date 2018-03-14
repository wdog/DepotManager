<?php if ($isCurrent): ?>
    <li data-disabled="1" <?= is_numeric($title)?'class="page-item active"' : 'class="page-item disabled"' ?>>
        <a class="page-link" href="#" tabindex="-1"><?= $title ?></a>
    </li>
<?php else: ?>
    <li class="page-item">
        <a class="page-link" href="<?= $url ?>"><?= $title ?></a>
    </li>
<?php endif ?>
