<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-3">
<div class="container">
      <h5 class="navbar-brand" ><?php echo SITENAME; ?></h5>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="<?php echo URLROOT; ?>">Accueil</a>
          </li>
          <?php foreach($data['categories'] as $cat): ?>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo URLROOT; ?>/pages/categorie/<?php echo $cat->id; ?>"><?php echo $cat->libelle; ?></a>
          </li>
          <?php endforeach; ?>
        </ul>
        
        <ul class="navbar-nav ml-auto">
          <?php if(isset($_SESSION['user_id'])) : ?>
            <div class="row">

            <div class="col-md-6">

              <a href="<?php echo URLROOT; ?>/posts/add" class="btn btn-primary pull-right">
                <i class="fa fa-pencil"></i> Add Post
              </a>
            </div>
  </div>
        <li class="nav-item">
        <span class="nav-link"><?php print_r($_SESSION['user_email']); ?></span>
      </li>
          <li class="nav-item">
              <a class="nav-link" href="<?php echo URLROOT; ?>/users/logout">Logout</a>
          </li>
          <?php else : ?>
            
            <li class="nav-item">
              <a class="nav-link" href="<?php echo URLROOT; ?>/users/login">Login</a>
            </li>
          <?php endif; ?>
        </ul>
      </div>
      </div>
    </nav>
    <hr>

    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-3">
      <div class="container">  
            <ul class="navbar-nav ml-auto">
              <?php if(isset($_SESSION['user_id'])) : ?>
                <div class="row">

                <div class="col-md-6">

                  <a href="<?php echo URLROOT; ?>/categories/add" class="btn btn-primary pull-right">
                    <i class="fa fa-pencil"></i> Add Category
                  </a>
      </div>
      </div>
        
          <li class="nav-item">
              <a class="btn btn-outline-warning" href="<?php echo URLROOT; ?>/categories/load"><i class="fa fa-pencil"></i>Edit Category</a>
          </li>
          
          <li class="nav-item">
              <a class="btn btn-outline-danger" href="<?php echo URLROOT; ?>/categories/delete">Delete Category</a>
            </li>
            <?php if( isset($_SESSION['user_status']) == 'admin')?>
            <li class="nav-item">
              <a class="btn btn-outline-info" href="<?php echo URLROOT; ?>/users/list">List Users</a>
            </li>
            <li class="nav-item">
              <a class="btn btn-outline-dark" href="<?php echo URLROOT; ?>/users/register">Ajouter Users</a>
            </li>
            
          <?php endif; ?>
          
        </ul>
      </div>
      
    </nav>


    