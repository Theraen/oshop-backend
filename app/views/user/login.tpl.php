<div class="container my-4">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <h2>Connection</h2>

        <?php
        // On inclut des sous-vues => "partials"
        include __DIR__.'/../partials/errorlist.tpl.php';
        ?>

            <form action="" method="POST">
                <div class="form-group">
                    <label for="email">Adresse E-mail</label>
                    <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Adresse E-mail" value="<?= isset($login) ? $login->getEmail() : ''; ?>">
                    <small id="emailHelp" class="form-text text-muted">Entrez votre adresse e-mail</small>
                </div>
                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Mot de passe">
                </div>
                <input type="hidden" name="token" value="<?= $_SESSION['token']; ?>">
                <button type="submit" class="btn btn-block btn-primary">Ce connecter</button>
            </form>
        
        </div>
    </div>
</div>