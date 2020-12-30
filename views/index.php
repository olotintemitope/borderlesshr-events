<?php include_once 'partials/header.php'?>
<body>
<?php include_once 'partials/nav.php' ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-10 mx-auto">
            <h1 class="card-title mt-5 mb-5 ">Welcome to Event Manager</h1>
            <p class="card-text">We have the most eventful events</p>
            <div class="card mt-5 mb-5">
                <div class="card-body">
                    <div class="row row-cols-1 row-cols-md-3 g-4">
                        <?php if (count($events) > 0) {?>
                            <?php foreach ($events as $index => $event) {?>
                                    <?php if ($index === 4) { break;}?>
                                <a class="text-decoration-none" href="/events/<?php echo strtolower(str_replace(" ", "-", $event['title'])) . '--'.$event['id'] ?>" title="<?php echo $event['title'];?>">
                                    <div class="col">
                                        <div class="card h-100">
                                            <img src="<?php echo $viewPath . "../../uploads/".$event['img_cover']?>" class="card-img-top" alt="<?php echo $event['title'];?> image" height="200">
                                            <div class="card-body">
                                                <h5 class="card-title text-black"><?php echo $event['title'];?></h5>
                                                <p class="card-text lh-8 text-black-50"><?php echo substr($event['description'], 0, 600) . "...";?></p>
                                                <p class="flex align-items-end">
                                                    <?php foreach (explode(",", $event['types']) as $type) {?>
                                                        <span class="badge rounded-pill <?php echo in_array($type, $specialEvents) ? "bg-danger" : "bg-primary";?>"><?php echo $type;?></span>
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
                    <p class="mt-5 mb-5"> <a href="/events" class="btn btn-primary">View more events</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once 'partials/footer.php'?>