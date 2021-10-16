<?php require APPROOT . '/views/inc/header.php'; ?>
  <a href="<?php echo URLROOT; ?>/pages" class="btn btn-light"><i class="fa fa-backward"></i> Back</a>
  <?php flash('post_message'); ?>
  <div class="card card-body bg-light mt-5">
    <h2>Add Category</h2>
    <p>Create a post with this form</p>
    <form action="<?php echo URLROOT; ?>/categories/add" method="post">
      <div class="form-group">
        <label for="libelle">Libelle: <sup>*</sup></label>
        <input type="text" name="libelle" class="form-control form-control-lg <?php echo (!empty($data['libelle_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['libelle']; ?>">
        <span class="invalid-feedback"><?php echo $data['libelle_err']; ?></span>
      </div>
      <input type="submit" class="btn btn-success" value="Add">
    </form>
  </div>
<?php require APPROOT . '/views/inc/footer.php'; ?>