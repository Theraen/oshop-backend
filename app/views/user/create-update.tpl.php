<div class="container my-4">
    <a href="<?= $router->generate('user-list'); ?>" class="btn btn-success float-right">Retour</a>
    <h2><?= isset($mode) && $mode === 'create' ? 'Ajouter un utilisateur' : 'Modifier l\'utilisateur ' . $user->getFirstname() . ' ' . $user->getLastName(); ?></h2>

    <?php include __DIR__ . '/../partials/errorlist.tpl.php'; ?>

    <form action="" method="POST" class="mt-5">
        <div class="form-group">
            <label for="name">Adresse E-mail</label>
            <input
                type="email"
                class="form-control"
                id="email" name="email"
                placeholder="Adresse e-mail"
                value="<?= isset($user) ? $user->getEmail() : ''; ?>">
        </div>
        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input
                type="password"
                class="form-control"
                id="password"
                name="password"
                placeholder="Mot de passe"
                >
        </div>
        <div class="form-group">
            <label for="firstname">Prénom</label>
            <input
                type="text"
                class="form-control"
                id="firstname"
                name="firstname"
                placeholder="Prénom"
                value="<?= isset($user) ? $user->getFirstname() : ''; ?>">
        </div>

        <div class="form-group">
            <label for="lastname">Nom</label>
            <input
                type="text"
                class="form-control"
                id="lastname"
                name="lastname"
                placeholder="Nom"
                value="<?= isset($user) ? $user->getlastname() : ''; ?>">
        </div>

        <div class="form-group">
            <label for="role">Role</label>
            <select class="form-control" id="role" name="role">
                <option value="admin" <?= ((isset($user) && $user->getRole() == 'admin')) ? 'selected' : ''; ?>>Admin</option>
                <option value="catalog-manager" <?= ((isset($user) && $user->getRole() == 'catalog-manager')) ? 'selected' : ''; ?>>Catalog-manager</option>
            </select>
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select class="form-control" id="status" name="status">
                <option value="1" <?= ((isset($user) && $user->getStatus() == '1')) ? 'selected' : ''; ?>>Actif</option>
                <option value="2" <?= ((isset($user) && $user->getStatus() == '2')) ? 'selected' : ''; ?>>Inactif</option>
            </select>
        </div>
        <input type="hidden" name="token" value="<?= $_SESSION['token'];  ?>">
        <button type="submit" class="btn btn-primary btn-block mt-5">Valider</button>
    </form>
</div>