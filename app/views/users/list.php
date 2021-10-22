<?php require APPROOT . '/views/inc/header.php'; ?>
<?php flash('post_message'); ?>
<a href="<?php echo URLROOT; ?>/posts" class="btn btn-light"><i class="fa fa-backward"></i> Back</a>
<br><br>
<?php if(isset($data['users']['Error'])){?>
        <h2>No user found </h2>
    <?php }else{?>

<table class="table">
<h2 class="display-5">List of users</h2>
  <caption>List of users</caption>
  <thead>
    <tr>
      <th scope="col">Nom</th>
      <th scope="col">Email</th>
      <th scope="col">Username</th>
      <th scope="col">Token</th>
      <th scope="col">Role</th>
      <th scope="col">Delete</th>
      <th scope="col">Edit</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach($data['users'] as $cate): ?>
    <tr>
      <td><?php echo $cate->nom; ?></td>
      <td><?php echo $cate->email; ?></td>
      <td><?php echo $cate->username; ?></td>
      <td><?php echo $cate->token; ?></td>
      <td><?php echo $cate->role; ?></td>
      <td><a class="btn btn-outline-danger delete_row" href="<?php echo URLROOT; ?>/users/delete/<?php echo $cate->id; ?>">remove</a></td>
      <td><a class="btn btn-outline-warning delete_row" href="<?php echo URLROOT; ?>/users/edit/<?php echo $cate->id; ?>">edit</a></td>
    </tr>
    <?php endforeach; ?>
    <?php }?>
  </tbody>
</table>
<?php require APPROOT . '/views/inc/footer.php'; ?>