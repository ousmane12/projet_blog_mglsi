<?php require APPROOT . '/views/inc/header.php'; ?>
<?php flash('post_message'); ?>
<?php flash('register_success'); ?>
<div class="jumbotron jumbotron-flud text-center">
    <div class="container">
    <?php foreach($data['posts'] as $post): ?>
    <h1 class="display-3"><?php echo $post->titre; ?></h1>
    <p class="lead"><?php echo substr($post->contenu, 0, 200).'...'?></p>
    <button class="w3-button w3-padding-large w3-white w3-border"><a href="<?php echo URLROOT; ?>/pages/article/<?= $post->id ?>"><b>EN SAVOIR PLUS »</b></a></button>
    <?php endforeach; ?>
    </div>
  </div>
  <div class="row">
        <div class="col-lg-12 text-center">
            <?= $data['pagination']; ?>
        </div>
    </div>

    
<?php require APPROOT . '/views/inc/footer.php'; ?>