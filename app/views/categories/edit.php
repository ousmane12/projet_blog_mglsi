<?php require APPROOT . '/views/inc/header.php'; ?>
  <a href="<?php echo URLROOT; ?>/pages" class="col-sm-2 btn btn-outline-secondary"><i class="fa fa-backward"></i> Back</a>
  <?php flash('post_message'); ?>
  <div class="card card-body bg-light mt-5">
    <h2>Edit Category</h2>
    <p>Create a Category with this form</p>
    <form action="<?php echo URLROOT; ?>/categories/edit/<?php echo $data['id']; ?>" method="post">
      <div class="form-group">
        <label for="categories">Categorie a Modifier: <sup>*</sup></label>
        <select name="categories" class="form-control form-control-lg <?php echo (!empty($data['categories_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['categories']; ?>" aria-label="Disabled select example">
            <?php foreach($data['categories'] as $categorie): ?>
            <option type="submit"><?php echo $categorie->libelle; ?></option>
            <?php endforeach?>
        </select>
        <span class="invalid-feedback"><?php echo $data['categorie_err']; ?></span> 
      </div>
      <div class="form-group">
        <label for="libelle">Nouvelle Categorie: <sup>*</sup></label>
        <input type="text" name="libelle" class="form-control form-control-lg <?php echo (!empty($data['libelle_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['libelle']; ?>">
        <span class="invalid-feedback"><?php echo $data['titre_err']; ?></span>
      </div>
      <input type="submit" class="btn btn-success" value="Update">
    </form>
  </div>
<?php require APPROOT . '/views/inc/footer.php'; ?>