<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="jumbotron jumbotron-flud text-center">    
    <div class="container">
    <?php if(isset($data['category']['Error'])){?>
        <h2>No Posts for this category</h2>
    <?php }else{?>
    <?php foreach($data['category'] as $cate): ?> 
    <h1 class="display-3"><?php echo $cate->titre; ?></h1>
    <p class="lead"><?php echo substr($cate->contenu, 0, 200).'...'?></p>
    <button class="w3-button w3-padding-large w3-white w3-border"><a href="<?php echo URLROOT; ?>/pages/article/<?= $cate->id ?>"><b>EN SAVOIR PLUS »</b></a></button>
    <?php endforeach; ?>
    <?php }?>
    </div> 
  </div> 
<?php require APPROOT . '/views/inc/footer.php'; ?>