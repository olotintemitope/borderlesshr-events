<?php $title = 'List Events';?>
<?php include_once $viewPath . 'partials/header.php' ?>
<body>
<?php include_once $viewPath . 'partials/nav.php' ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-10 mx-auto">
            <h2 class="mt-5 mb-5">Events</h2>
            <div class="row row-cols-1 row-cols-md-3 g-4">

                <?php if (count($events) > 0) {?>
                        <?php foreach ($events as $event) {?>
                        <a class="text-decoration-none" href="/events/<?php echo strtolower(str_replace(" ", "-", $event['title'])) . '--'.$event['id'] ?>" title="<?php echo $event['title'];?>">
                            <div class="col">
                                <div class="card h-100">
                                    <img src="<?php echo $viewPath . "../../uploads/".$event['img_cover']?>" class="card-img-top" alt="<?php echo $event['title'];?> image" height="200">
                                    <div class="card-body">
                                        <h5 class="card-title text-black"><?php echo $event['title'];?></h5>
                                        <p class="card-text lh-8 text-black-50"><?php echo substr($event['description'], 0, 600) . "...";?></p>
                                        <p class="flex align-items-end">
                                        <?php foreach (explode(",", $event['types']) as $type) {?>
                                            <span class="badge rounded-pill bg-primary"><?php echo $type;?></span>
                                        <?php } ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <?php } ?>
                <?php }  else { ?>
                <div class="col">No available events</div>
                <?php } ?>
            </div>

        </div>
    </div>
</div>
<?php include_once $viewPath . 'partials/footer.php' ?>
