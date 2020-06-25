<?php ob_start(); ?>
<h1>
    <?= $media['title']; ?>
</h1>
<<<<<<< Updated upstream
<div style="width: 100%; height: 700px;">
    <iframe width="100%" height="100%" src="<?= $media['trailer_url']; ?>" frameborder="0"
            allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
    </iframe>
</div>
<div class="mt-3">
    <h1 class="mb-3">
        <?= $media['title']; ?>
    </h1>
    <p class="mb-3 text-justify"> <?= $media['summary']; ?> </p>
    <?php if ($media['type'] == 'film'): ?>
        <a href="#" class="badge badge-primary p-2">film</a>
    <?php endif; ?>
    <?php if ($media['type'] == 'série'): ?>
        <a href="#" class="badge badge-danger p-2">série</a>
    <?php endif; ?>
    <a href="#" class="badge badge-info p-2"> <?= substr($media['release_date'], 0, 4); ?> </a>
    <a href="#" class="badge badge-dark p-2"> <?= $genre ?> </a>
=======
<script>
    let selectedSeason = null;
    function getSeason(str) {
        if (str == "") {
            document.getElementById("mainContainer").innerHTML = "";
            return;
        } else {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("mainContainer").innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET","index.php?media=" + <?= $media['id']; ?> + "&season=" + str, true);
            xmlhttp.send();
            selectedSeason = str;
        }
    }
    function getEpisode(str) {
        if (str == "") {
            document.getElementById("mainContainer").innerHTML = "";
            return;
        } else {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("mainContainer").innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET","index.php?media=" + <?= $_GET['media']; ?> + "&season=" + selectedSeason + "&episode=" + str, true);
            xmlhttp.send();
        }
    }
</script>
<div style="width: 100%; height: 700px;">    <iframe width="100%" height="100%" src="<?= $video ?>" frameborder="0"         allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>    </iframe></div>
<div class="mt-3">
    <h1 class="mb-2" id="test">        <?= $media['title']; ?>    </h1>
    <?php if ($detailStream): ?>        <h5 class="mb-3">            <span style="text-decoration: underline;"><?= $detailStream['title'] ?></span>                 </h5>        <span>            (Saison <?= $detailStream['season'] ?>, Episode <?= $detailStream['episode'] ?>)        </span>    <?php endif; ?>
    <?php if ($detailStream): ?>        <p class="mb-3 text-justify"> <?= $detailStream['summary']; ?> </p>    <?php else: ?>        <p class="mb-3 text-justify"> <?= $media['summary']; ?> </p>    <?php endif; ?>
    <?php if ($media['type'] == 'film'): ?>        <a href="index.php?type=film" class="badge badge-primary p-2">film</a>    <?php endif; ?>
    <?php if ($media['type'] == 'série'): ?>        <a href="index.php?type=serie" class="badge badge-danger p-2">série</a>    <?php endif; ?>
    <a href="index.php?release_date=<?= substr($media['release_date'], 0, 4); ?>" class="badge badge-info p-2"> <?= substr($media['release_date'], 0, 4); ?> </a>
    <a href="index.php?genre=<?= $media['genre_id'] ?>" class="badge badge-dark p-2"> <?= $genre ?> </a>
    <!-- If the media is a tv show, then show the different seasons and episodes -->
    <?php if ($media['type'] == 'série'): ?>
        <form method="get" class="custom-form">
            <input type="hidden" name="media" value="<?= $media['id'] ?>"/>
            <div class="row">
                <div class="mt-3 col-md-1">
                    <select name="season" id="season" onchange="getSeason(this.value)">
                        <option value="">Saisons</option>
                        <?php foreach( $seasons as $season ): ?>
                            <option id="season<?= $season['season'] ?>" value="<?= $season['season']; ?>">Saison <?= $season['season']; ?> </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <?php if ($episodes): ?>
                    <div class="mt-3 col-md-1">
                        <select name="episode" id="episode" onchange="getEpisode(this.value)">
                            <option value="">Episodes</option>
                            <?php foreach( $episodes as $episode ): ?>
                                <option value="<?= $episode['episode']; ?>">Episode <?= $episode['episode']; ?> </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <?php endif; ?>

                </div>
            </form>
        <?php endif; ?>
</div>

>>>>>>> Stashed changes
<?php $content = ob_get_clean(); ?>
<?php require('dashboard.php'); ?>
