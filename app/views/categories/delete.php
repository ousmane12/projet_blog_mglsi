<?php require APPROOT . '/views/inc/header.php'; ?>
  <a href="<?php echo URLROOT; ?>/pages" class="col-sm-2 btn btn-outline-secondary"><i class="fa fa-backward"></i> Back</a>
  <?php flash('post_message'); ?>
  <div class="card card-body bg-light mt-5">
    <h2>Delete Category</h2>
    <p>Delete a Category with this form</p>
    <form action="<?php echo URLROOT; ?>/categories/delete" method="post">
      <div class="form-group">
        <label for="libelle">Categorie a Supprimer: <sup>*</sup></label>
        <select name="libelle" class="form-control form-control-lg <?php echo (!empty($data['categories_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['categories']; ?>" aria-label="Disabled select example">
            <?php foreach($data['categories'] as $categorie): ?>
            <option selected><?php echo $categorie->libelle; ?></option>
            <?php endforeach?>
        </select>
        <span class="invalid-feedback"><?php echo $data['categorie_err']; ?></span> 
      </div>
      <input type="submit" value="Delete" class="btn btn-outline-danger">
    </form>
  </div>
<?php require APPROOT . '/views/inc/footer.php'; ?>