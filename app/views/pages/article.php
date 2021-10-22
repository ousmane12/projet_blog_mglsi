<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="jumbotron jumbotron-flud text-center"> 
   
<div class="container">
    <h1 class="col"><?= $data['article'][0]->titre ?></h1>
	<p><?= $data['article'][0]->contenu ?></p>
    <span>Date de publication: <?= $data['article'][0]->dateCreation ?></span><br>
    <span>Date de Modification: <?= $data['article'][0]->dateModification ?></span><br>
    <span>Auteur: <?= $data['article'][0]->auteur ?></span>
</div>
<hr>
<a href="<?php echo URLROOT; ?>/pages" class="col-sm-2 btn btn-outline-secondary"><i class="fa fa-backward"></i> Back</a>
<?php if(($data['article'][0]->auteur == $_SESSION['user_name']) || ($_SESSION['user_role'] == 'admin')  ) : ?>
  
  <a href="<?php echo URLROOT; ?>/posts/edit/<?php echo $data['article'][0]->id; ?>" class="col-sm-2 btn btn-outline-warning">Edit</a>
  <form class="col-sm col-sm-4 pull-right" action="<?php echo URLROOT; ?>/posts/delete/<?php echo $data['article'][0]->id; ?>" method="post">
    <input type="submit" value="Delete" class="btn btn-outline-danger">
  </form>
<?php endif; ?>
<br>
</div> 

<?php require APPROOT . '/views/inc/footer.php'; ?>