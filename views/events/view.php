<?php $title = 'View ' . $event['title'];?>
<?php include_once $viewPath . 'partials/header.php' ?>
<body>
<?php include_once $viewPath . 'partials/nav.php' ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-10 mx-auto">
            <h2 class="mt-5 mb-5"><?php echo $event['title']; ?></h2>
            <?php include_once $viewPath . 'flash/messages.php' ?>
            <div class="row">
                <div class="col">
                    <?php if ($event['is_premium']) {?>
                        <main class="container">
                            <div class="alert alert-warning" role="alert">
                                This is a premium event. Please see our pricing
                            </div>
                            <?php include_once $viewPath . '/partials/events/pricing.php'?>
                        </main>
                    <?php }  else { ?>
                    <div class="card h-100">
                        <img src="<?php echo $viewPath . "../../uploads/" . $event['img_cover'] ?>" class="card-img-top"
                             alt="<?php echo $event['title']; ?> image" height="500">
                        <div class="card-body">
                            <h3 class="card-title"><?php echo $event['title']; ?> </h3>
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
                                    <a href="/events/apply/<?php echo strtolower(str_replace(" ", "-", $event['title'])) . '--'.$event['id'] ?>" class="btn btn-warning text-white">Apply</a>
                                <?php } else {?>
                                    <span class='badge bg-light text-dark'>Application will open on: <?php echo (new \DateTime($event['date_opened']))->format('Y-m-d') ?></span>
                                <?php } ?>
                            </p>
                            <p class="flex align-items-end">
                                <?php foreach (explode(",", $event['types']) as $type) { ?>
                                    <span class="badge rounded-pill <?php echo in_array($type, $specialEvents) ? "bg-danger" : "bg-primary";?>"><?php echo $type; ?></span>
                                <?php } ?>
                            </p>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once $viewPath . 'partials/footer.php' ?>
