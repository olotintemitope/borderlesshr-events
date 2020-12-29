<?php if (isset($_SESSION['error'])) { ?>
    <div class="alert alert-danger" role="alert">
        <?php echo $_SESSION['error'];?>
    </div>
<?php }?>
<?php if (isset($_SESSION['success'])) { ?>
    <div class="alert alert-success" role="alert">
        <?php echo $_SESSION['success'];?>
    </div>
<?php }?>
<?php unset($_SESSION['error'], $_SESSION['success']);?>