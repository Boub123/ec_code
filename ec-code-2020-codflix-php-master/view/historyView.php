<?php ob_start(); ?>
    <script>
        function supMedia(str){
            document.getElementById('supMedia').value = str;
        }
    </script>
    <h1 class="media-header">Mes dernières visites</h1>
    <form method="post" action="index.php?action=history" class="custom-form">
        <div class="media-list">
            <?php
            foreach( $mediaVisited as $row ):
                $media = Media::Details($row['media_id']);
                ?>
                <a class="item" href="index.php?media=<?= $media['id']; ?>">
                    <div class="video">
                        <div>
                            <iframe allowfullscreen="" frameborder="0"
                                    src="<?= $media['trailer_url']; ?>" ></iframe>
                        </div>
                    </div>
                    <div class="title"><?= $media['title']; ?></div>
                    <div class="d-flex justify-content-center"><span class="badge badge-light"><?= substr($media['release_date'], 0, 4) ?></span></div>
                    <input type="submit" value="Supprimer" onclick="supMedia(<?= $media['id'] ?>)" />
                </a>
            <?php endforeach; ?>
        </div>
        <input type="hidden" name="deleteOneMedia" id="deleteOneMedia">
        <input type="submit" name="deleteAllHistory" value="Supprimer tout mon historique" class="btn btn-block bg-red" />
    </form>
<?php $content = ob_get_clean(); ?>
<?php require('dashboard.php'); ?>