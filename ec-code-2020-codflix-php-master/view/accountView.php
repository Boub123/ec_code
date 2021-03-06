<?php ob_start();
?>

<div class="col-md-12 full-height bg-white">
    <div class="auth-container">
        <h2><span>Cod</span>'Flix</h2>
        <h3 class="text-black-50">Administrer mon compte (cette page sert à changer de mail/motpass)</h3>

        <form method="post" class="custom-form text-danger">
             <span class="error-msg">
              <?= isset( $error_msg ) ? $error_msg : null; ?>
            </span>
            <span class="success-msg">
              <?= isset( $success_msg ) ? $success_msg : null; ?>
            </span>
            <div class="form-group ">
                <label for="email">Adresse email</label>
                <input type="email" name="email" id="email" class="form-control" />
                <?php //$response['email'];?>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe actuel</label>
                <input type="password" name="password" id="password" class="form-control" />
            </div>
            <div class="form-group">
                <label for="newPassword">Nouveau mot de passe</label>
                <input type="password" name="newPassword" id="newPassword" class="form-control" />
            </div>
            <div class="form-group">
                <label for="newPasswordConfirm">Confirmer nouveau mot de passe</label>
                <input type="password" name="newPasswordConfirm" id="newPasswordConfirm" class="form-control" />
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <input type="submit" name="Valider" value="Modifier mes informations" class="btn btn-block bg-blue" />
                    </div>
                    <div class="col-md-6">
                        <!-- <a href="#" class="btn btn-block bg-red">Supprimer mon compte</a> -->
                        <input type="submit" name="Delete" value="Supprimer mon compte" class="btn btn-block bg-red" />
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>

<?php $content = ob_get_clean(); ?>
<?php require( __DIR__ . './base.php'); ?>
