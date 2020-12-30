<?php $title = 'View ' . $event['title'];?>
<?php include_once $viewPath . 'partials/header.php' ?>
<body>
<?php include_once $viewPath . 'partials/nav.php' ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-10 mx-auto">
            <h2 class="mt-5 mb-5"><?php echo $event['title']; ?></h2>
            <div class="row">
                <div class="col">
                    <div class="card h-100">
                        <img src="<?php echo $viewPath . "../../uploads/" . $event['img_cover'] ?>" class="card-img-top"
                             alt="<?php echo $event['title']; ?> image" height="500">
                        <div class="card-body">
                            <h3 class="card-title"><?php echo $event['title']; ?></h3>
                            <p class="card-text lh-8"><?php echo $event['description']; ?></p>
                            <h4>Registration Deadline</h4>
                            <?php $isClosed = true; ?>
                                <?php
                                    if ((new \DateTime($event['registration_deadline_date'])) > (new \DateTime())) {
                                        $isClosed = false;
                                    }?>
                            <p><?php if ($isClosed) { echo "Application closed";} else { echo "<span class='badge bg-light text-dark'>".(new \DateTime($event['registration_deadline_date']))->format('Y-m-d'). "</span>"; }?></p>
                            <p>
                                <?php if (!$isClosed &&  (new \DateTime()) >= (new \DateTime($event['date_opened']))) {?>
                                    <a href="#" class="btn btn-warning text-white">Apply</a>
                                <?php } else {?>
                                    <span class='badge bg-light text-dark'>Application will open on: <?php echo (new \DateTime($event['date_opened']))->format('Y-m-d') ?></span>
                                <?php } ?>
                            </p>
                            <p class="flex align-items-end">
                                <?php foreach (explode(",", $event['types']) as $type) { ?>
                                    <span class="badge rounded-pill bg-primary"><?php echo $type; ?></span>
                                <?php } ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once $viewPath . 'partials/footer.php' ?>
