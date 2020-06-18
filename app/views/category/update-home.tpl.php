<div class="container my-4">
    <a href="categories.html" class="btn btn-success float-right">Retour</a>
    <h2>Gestion de la page d'accueil</h2>

    <?php include __DIR__ . '/../partials/errorlist.tpl.php'; ?>

    <form action="" method="POST" class="mt-5">
    <div class="row">
        <div class="col">
            <div class="form-group">
                <label for="emplacement1">Emplacement #1</label>
                <select class="form-control" id="emplacement1" name="emplacement[]">
                    <option value="">choisissez :</option>
                    <option value="1" selected>Détente</option>
                    <option value="2">Au travail</option>
                    <option value="3">Cérémonie</option>
                    <option value="4">Sortir</option>
                    <option value="5">Vintage</option>
                </select>
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label for="emplacement2">Emplacement #2</label>
                <select class="form-control" id="emplacement2" name="emplacement[]">
                    <option value="">choisissez :</option>
                    <option value="1">Détente</option>
                    <option value="2" selected>Au travail</option>
                    <option value="3">Cérémonie</option>
                    <option value="4">Sortir</option>
                    <option value="5">Vintage</option>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="form-group">
                <label for="emplacement3">Emplacement #3</label>
                <select class="form-control" id="emplacement3" name="emplacement[]">
                    <option value="">choisissez :</option>
                    <option value="1">Détente</option>
                    <option value="2">Au travail</option>
                    <option value="3">Cérémonie</option>
                    <option value="4" selected>Sortir</option>
                    <option value="5">Vintage</option>
                </select>
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label for="emplacement4">Emplacement #4</label>
                <select class="form-control" id="emplacement4" name="emplacement[]">
                    <option value="">choisissez :</option>
                    <option value="1">Détente</option>
                    <option value="2">Au travail</option>
                    <option value="3">Cérémonie</option>
                    <option value="4">Sortir</option>
                    <option value="5" selected>Vintage</option>
                </select>
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label for="emplacement5">Emplacement #5</label>
                <select class="form-control" id="emplacement5" name="emplacement[]">
                    <option value="">choisissez :</option>
                    <option value="1">Détente</option>
                    <option value="2">Au travail</option>
                    <option value="3" selected>Cérémonie</option>
                    <option value="4">Sortir</option>
                    <option value="5">Vintage</option>
                </select>
            </div>
        </div>
    </div>
    <input type="hidden" name="token" value="<?= $_SESSION['token'];  ?>">
    <button type="submit" class="btn btn-primary btn-block mt-5">Valider</button>
</form>

</div>