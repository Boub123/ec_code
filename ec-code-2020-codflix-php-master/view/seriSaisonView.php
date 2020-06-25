<?php
// connect this page to database
$host = 'localhost';
$dbname = 'codflix';
$username = 'root';
$password = '';
$season = $_GET["var5"];
$title = $_GET["var1"];
//echo $saison;
$dsn = "mysql:host=$host;dbname=$dbname;port=3308";
// get all series in the clause
//$sql = "SELECT * FROM serie";
$sql = "SELECT * FROM serie WHERE season ='".$season."' AND title LIKE '%{$title}%' ";
try{
    $pdo = new PDO($dsn, $username, $password);
    $stmt = $pdo->query($sql);

    if($stmt === false){
        die("Erreur");
    }

}catch (PDOException $e){
    echo $e->getMessage();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Cod'Flix</title>

    <link href="../public/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../public/lib/font-awesome/css/all.min.css" rel="stylesheet" />

    <link href="../public/css/partials/partials.css" rel="stylesheet" />
    <link href="../public/css/layout/layout.css" rel="stylesheet" />
</head>


<body>
<div class="wrapper d-flex align-items-stretch" id="mainContainer">
    <nav id="sidebar">
        <h2 class="title">Bienvenue</h2>
        <div class="sidebar-menu">
            <ul>
                <li class="active"><a href="index.php">Médias</a></li>
                <li class="active"><a href="http://localhost/ec_code/ec-code-2020-codflix-php-master/view/serieView.php">Séries</a></li>
                <li><a href="index.php?action=contact">Nous contacter</a></li>
                <li><a href="index.php?action=account">Mon Compte</a></li>
                <li><a href="index.php?action=logout">Me déconnecter</a></li>
            </ul>
        </div>
    </nav>

    <!-- Page Content  -->
    <div id="content">
        <div class="header">
            <h2 class="title">Cod<span>'Flix</span></h2>
            <div class="toggle-menu d-block d-md-none">
                <button type="button" id="sidebarCollapse" class="btn btn-primary">
                    <i class="fas fa-bars"></i>
                    <span class="sr-only">Toggle Menu</span>
                </button>
            </div>
        </div>
        <div class="content p-4 mb-4">
            <?php while($row = $stmt->fetch(PDO::FETCH_ASSOC)) : ?>
                <div class="card">
                    <iframe allowfullscreen="allowfullscreen"  frameborder="0"
                            src="<?= $row['stream_url']; ?>" ></iframe>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($row['title']); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars($row['summary']); ?></p>
                        <p class="card-text"><small class="text-muted">Saison : <?php echo htmlspecialchars($row['season']); ?> Episode : <?php echo htmlspecialchars($row['episode']); ?></small></p>
                    </div>
                </div>
            <?php endwhile; ?>

        </div>
        <footer>Copyright Cod'Flix</footer>
    </div>
</div>

<script src="../public/lib/jquery/js/jquery-3.5.0.min"></script>
<script src="../public/lib/bootstrap/js/bootstrap.min.js"></script>

<script src="../public/js/script.js"></script>
</body>

</html>

