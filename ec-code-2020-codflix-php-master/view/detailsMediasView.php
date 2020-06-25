<?php ob_start(); ?>
<h1>
    <?= $media['title']; ?>
</h1>
<?php $content = ob_get_clean(); ?>
<?php require('dashboard.php'); ?>
