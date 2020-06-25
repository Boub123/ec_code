<?php ob_start(); ?>

<div class="row">
    <div class="col-md-4 offset-md-8">
        <form method="get">
            <div class="form-group has-btn">
                <input type="search" id="search" name="title" value="<?= $search; ?>" class="form-control"
                       placeholder="Rechercher un film ou une série">

                <button type="submit" class="btn btn-block bg-red">Valider</button>
            </div>
        </form>
    </div>
</div>

<?php if(empty($search)):?>
<h1 class="movies-header">Films</h1>
<div class="media-list">
    <?php foreach( $movies as $movie ): ?>
        <a class="item" href="index.php?media=<?= $movie['id']; ?>">
            <div class="video">
                <div>
                    <iframe allowfullscreen="" frameborder="0"
                            src="<?= $movie['trailer_url']; ?>" ></iframe>
                </div>
            </div>
            <div class="title text-danger"><?= $movie['title']; ?></div>
            <div class="text-center text-danger">Date de sortie : <?= substr($movie['release_date'],0,4)?></div>
        </a>
    <?php endforeach; ?>
</div>
    <h1 class="movies-header text-danger">Series</h1>
    <div class="media-list">
    <?php foreach( $series as $serie ): ?>
        <a class="item" href="index.php?media=<?= $serie['id']; ?>">
            <div class="video">
                <div>
                    <iframe allowfullscreen="" frameborder="0"
                            src="<?= $serie['trailer_url']; ?>" ></iframe>
                </div>
            </div>
            <div class="title text-center"><?= $serie['title']; ?></div>
            <div class="text-center text-white"> Date de sortie : <?= substr($serie['release_date'],0,4)?></div>
        </a>
    <?php endforeach; ?>
</div>
<?php endif;?>
<?php if (!empty($search)): ?>
    <h1 class="search-header">La rechercher : <span style="color: red;"><?php echo $search; ?></span></h1>
    <div class="media-list">
        <?php foreach( $medias as $media ): ?>
            <a class="item" href="index.php?media=<?= $media['id']; ?>">
                <div class="video">
                    <div>
                        <iframe allowfullscreen="" frameborder="0"
                                src="<?= $media['trailer_url']; ?>" ></iframe>
                    </div>
                </div>
                <div class="title"><?= $media['title']; ?></div>
                <div class="d-flex  justify-content-between"><?= substr($media['release_date'],0,4)?></div>
            </a>
        <?php endforeach; ?>
    </div>
<?php endif; ?>


<?php $content = ob_get_clean(); ?>

<?php require('dashboard.php'); ?>
