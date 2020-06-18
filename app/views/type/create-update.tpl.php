<div class="container my-4">
        <a href="<?=$router->generate('type-list'); ?>" class="btn btn-success float-right">Retour</a>
        <h2><?= isset($mode) && $mode === 'create' ? 'Ajouter un type' : 'Modifier le type ' . $type->getName(); ?></h2>


        <?php
// On inclut des sous-vues => "partials"
    include __DIR__.'/../partials/errorlist.tpl.php';
?>

        
        <form action="" method="POST" class="mt-5">
            <div class="form-group">
                <label for="name">Nom</label> 
                <input type="text" class="form-control" id="name" name="name" placeholder="Nom du type" value="<?= isset($type) ? $type->getName() : ''; ?>">
            </div>
            
            <input type="hidden" name="token" value="<?= $_SESSION['token'];  ?>">
            <button type="submit" class="btn btn-primary btn-block mt-5">Valider</button>
        </form>
    </div>