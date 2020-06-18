<div class="container my-4">
    <a href="categories.html" class="btn btn-success float-right">Retour</a>
    <h2><?= isset($mode) && $mode === 'create' ? 'Ajouter un produit' : 'Modifier le produit ' . $product->getName(); ?></h2>

    <?php include __DIR__ . '/../partials/errorlist.tpl.php'; ?>

    <form action="" method="POST" class="mt-5">
        <div class="form-group">
            <label for="name">Nom</label>
            <input
                type="text"
                class="form-control"
                id="name"
                placeholder="Nom du produit"
                name="name"
                value="<?= isset($product) ? $product->getName() : ''; ?>"
                >
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description">
                <?= isset($product) ? $product->getDescription() : ''; ?>
            </textarea>
                
                
            <small id="subtitleHelpBlock" class="form-text text-muted">
                Sera affiché sur la page d'accueil comme bouton devant l'image
            </small>
        </div>
        <div class="form-group">
            <label for="price">Prix</label>
            <input
                type="text"
                class="form-control"
                id="price"
                placeholder="Prix du produit"
                aria-describedby="subtitleHelpBlock"
                name="price"
                value="<?= isset($product) ? $product->getPrice() : ''; ?>"
                >
            <small id="subtitleHelpBlock" class="form-text text-muted">
                Prix de l'article
            </small>
        </div>
        <div class="form-group">
            <label for="picture">Image</label>
            <input
                type="text"
                class="form-control"
                id="picture"
                placeholder="image jpg, gif, svg, png"
                aria-describedby="pictureHelpBlock"
                name="picture"
                value="<?= isset($product) ? $product->getPicture() : ''; ?>"
                >
            <small id="pictureHelpBlock" class="form-text text-muted">
                URL relative d'une image (jpg, gif, svg ou png) fournie sur <a href="https://benoclock.github.io/S06-images/" target="_blank">cette page</a>
            </small>
        </div>

        <div class="form-group">
            <label for="brandId">Marque</label>
            <select class="form-control" id="brandId" name="brandId">
                <?php foreach($allBrands as $brand): ?>
                <option value="<?= $brand->getId(); ?>" <?= ((isset($product) && $product->getBrandId() == $brand->getId())) ? 'selected' : ''; ?>><?= $brand->getName(); ?></option>
                <?php endforeach; ?>
            </select>
            <small id="brandHelpBlock" class="form-text text-muted">
                Marque du produit
            </small>
        </div>

        <div class="form-group">
            <label for="categoryId">Catégorie</label>
            <select class="form-control" id="categoryId" name="categoryId">
                <?php foreach($allCategories as $category): ?>
                <option value="<?= $category->getId(); ?>" <?= ((isset($product) && $product->getCategoryId() == $category->getId())) ? 'selected' : ''; ?>><?= $category->getName(); ?></option>
                <?php endforeach; ?>
            </select>
            <small id="categoryHelpBlock" class="form-text text-muted">
            Catégorie du produit
            </small>
        </div>

        <div class="form-group">
            <label for="typeId">Type</label>
            <select class="form-control" id="typeId" name=typeId>
                <?php foreach($allTypes as $type): ?>
                <option value="<?= $type->getId(); ?>" <?= ((isset($product) && $product->getTypeId() == $type->getId())) ? 'selected' : ''; ?>><?= $type->getName(); ?></option>
                <?php endforeach; ?>
            </select>
            <small id="typeHelpBlock" class="form-text text-muted">
            Type du produit
            </small>
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select class="form-control" id="status" name="status">
                <option value="1" <?= ((isset($product) && $product->getStatus() == '1')) ? 'selected' : ''; ?>>Disponible</option>
                <option value="2" <?= ((isset($product) && $product->getStatus() == '2')) ? 'selected' : ''; ?>>Indisponible</option>
            </select>
            <small id="subtitleHelpBlock" class="form-text text-muted">
                Statut du produit
            </small>
        </div>
        <input type="hidden" name="token" value="<?= $_SESSION['token'];  ?>">
        <button type="submit" class="btn btn-primary btn-block mt-5">Valider</button>
    </form>
</div>