<!DOCTYPE html>
<html>
<head>
    <title>ESP News | Admin</title>
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <link rel="shortcut icon" href="img/logo.jpg" type="image/x-icon">

    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#">
            <img src="img/logo.jpg" style="max-width:30px;" class="rounded-circle"> ESP News | Admin
        </a>
    </div>
</nav>
 <div class="admin-content" style="margin-top: 100px">
        <div class="container">
            <div class="col-lg-8 offset-lg-2">
                <h2>Mettre en ligne un article</h2>
                <form id="form-create-article">
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Titre de l'article</label>
                        <input type="text" class="form-control" id="exampleFormControlInput1" name="title" placeholder="Tapez le nom de l'article..." required>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Cat&eacute;gorie</label>
                        <select class="form-control" name="category-id" id="list-categories">
                            <option selected="true">Sélectionner une categorie</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Contenu</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" name="content" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Valider</button>
                </form>
            </div>
        </div>
 </div>
 <script type="text/javascript" src="js/admin.js"></script>
 <script src="vendor/jquery/jquery.min.js"></script>
 <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
 </body>
</html>
