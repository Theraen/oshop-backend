<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?=$router->generate('main-home')?>">oShop</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <?php if($isConnected): ?>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="<?=$router->generate('main-home')?>">Accueil <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?=$router->generate('category-list')?>">Catégories</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?=$router->generate('product-list')?>">Produits</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?=$router->generate('type-list')?>">Types</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?=$router->generate('brand-list')?>">Marques</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Tags</a>
                </li>
                <?php if($isAdmin): ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?=$router->generate('user-list')?>">Utilisateurs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?=$router->generate('category-update-home')?>">Sélections Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Sélections Footer</a>
                </li>
                <?php endif; ?>

            </ul>
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Rechercher" aria-label="Rechercher">
                <button class="btn btn-outline-info my-2 my-sm-0" type="submit">Rechercher</button>
            </form>
        </div>
        <?php endif; ?>

</nav>