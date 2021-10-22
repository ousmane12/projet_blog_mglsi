
<?php require APPROOT . '/views/inc/header.php'; ?>
<a href="<?php echo URLROOT; ?>/posts" class="btn btn-light"><i class="fa fa-backward"></i> Back</a>
<br>
<?php flash('post_message'); ?>
<div class="container">
  <div class="row">
    <div class="col-md-6 mx-auto">
      <div class="card card-body bg-light mt-5">
        <h2>Edit A User</h2>
        <p>Please fill out this form to register a user</p>
        <form action="<?php echo URLROOT; ?>/users/register" method="post">
          <div class="form-group">
            <label for="nom">Name: <sup>*</sup></label>
            <input type="text" name="nom" class="form-control form-control-lg" value="<?php echo $data['nom']; ?>">
          </div>
          <div class="form-group">
            <label for="prenom">Prenom: <sup>*</sup></label>
            <input type="text" name="prenom" class="form-control form-control-lg" value="<?php echo $data['prenom']; ?>">
          </div>
          <div class="form-group">
            <label for="email">Email: <sup>*</sup></label>
            <input type="email" name="email" class="form-control form-control-lg" value="<?php echo $data['email']; ?>">
          </div>
          <div class="form-group">
            <label for="username">Pseudo: <sup>*</sup></label>
            <input type="text" name="username" class="form-control form-control-lg" value="<?php echo $data['username']; ?>">
          </div>
          <div class="form-group">
            <label for="password">Password: <sup>*</sup></label>
            <input type="password" name="password" class="form-control form-control-lg" value="<?php echo $data['password']; ?>">
          </div>
          <div class="form-group">
            <label for="role">Role: <sup>*</sup></label>
            <input type="text" name="role" class="form-control form-control-lg" value="<?php echo $data['role']; ?>">
          </div>
          <div class="form-group">
         
            <label for="token">Token: <sup>*</sup></label>
            <input type="text" name="token" class="form-control form-control-lg <?php echo (!empty($data['token_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['token']; ?>">
            <br><button class="btn btn-outline-success">Generate</button>
            
          </div>

          <div class="row">
            <div class="col">
              <input type="submit" value="Update" class="btn btn-success btn-block">
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  
<?php require APPROOT . '/views/inc/footer.php'; ?>