<?php require APPROOT . '/views/inc/header.php'; ?>
  <a href="<?php echo URLROOT; ?>/pages" class="btn btn-light"><i class="fa fa-backward"></i> Back</a>
  <?php flash('post_message'); ?>
  <div class="card card-body bg-light mt-5">
    <h2>Add Post</h2>
    <p>Create a post with this form</p>
    <form action="<?php echo URLROOT; ?>/posts/add" method="post">
      <div class="form-group">
        <label for="title">Titre: <sup>*</sup></label>
        <input type="text" name="titre" class="form-control form-control-lg <?php echo (!empty($data['titre_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['titre']; ?>">
        <span class="invalid-feedback"><?php echo $data['titre_err']; ?></span>
      </div>
      <div class="form-group">
        <label for="contenu">Contenu: <sup>*</sup></label>
        <textarea name="contenu" class="form-control form-control-lg <?php echo (!empty($data['contenu_err'])) ? 'is-invalid' : ''; ?>"><?php echo $data['contenu']; ?></textarea>
        <span class="invalid-feedback"><?php echo $data['contenu_err']; ?></span>
      </div>
      <div class="form-group">
        <label for="categories">Categorie: <sup>*</sup></label>
        <select name="categories" class="form-control form-control-lg <?php echo (!empty($data['categories_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['categories']; ?>" aria-label="Disabled select example">
            <?php foreach($data['categories'] as $categorie): ?>
            <option selected><?php echo $categorie->libelle; ?></option>
            <?php endforeach?>
        </select>
        <span class="invalid-feedback"><?php echo $data['categorie_err']; ?></span> 
      </div>
      <input type="submit" class="btn btn-success" value="Add">
    </form>
  </div>
<?php require APPROOT . '/views/inc/footer.php'; ?>