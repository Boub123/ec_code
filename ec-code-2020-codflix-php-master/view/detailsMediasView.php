<?php ob_start(); ?>
<h1>
    <?= $media['title']; ?>
</h1>

<div style="width: 100%; height: 700px;">
    <!--<iframe width="100%" height="100%" src="<?= $media['trailer_url']; ?>" frameborder="0"-->
    <iframe width="100%" height="100%" src="<?= $stream ?>" frameborder="0"
            allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
    </iframe>
</div>
<div class="mt-3">
    <h1 class="mb-3">
        <?= $media['title']; ?>
    </h1>
    <p class="mb-3 text-justify"> <?= $media['summary']; ?> </p>

    <?php if ($detailStream): ?>
        <h5 class="mb-3">
            <span style="text-decoration: underline;"><?= $detailStream['title'] ?></span>
        </h5>
        <span>
            (Saison <?= $detailStream['season'] ?>, Episode <?= $detailStream['episode'] ?>)
        </span>
    <?php endif; ?>
    <?php if ($detailStream): ?>
        <p class="mb-3 text-justify"> <?= $detailStream['summary']; ?> </p>
    <?php else: ?>
        <p class="mb-3 text-justify"> <?= $media['summary']; ?> </p>
    <?php endif; ?>


    <?php if ($media['type'] == 'film'): ?>
        <a href="index.php?type=film" class="badge badge-primary p-2">film</a>
    <?php endif; ?>
    <?php if ($media['type'] == 'série'): ?>
        <a href="index.php?type=serie" class="badge badge-danger p-2">série</a>
    <?php endif; ?>
    <a href="#" class="badge badge-info p-2"> <?= substr($media['release_date'], 0, 4); ?> </a>
    <a href="#" class="badge badge-dark p-2"> <?= $genre ?> </a>

<?php $content = ob_get_clean(); ?>
<?php require('dashboard.php'); ?>
