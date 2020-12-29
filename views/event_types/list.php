<?php $title = 'List Event Types';?>
<?php include_once $viewPath . 'partials/header.php' ?>
    <body>
<?php include_once $viewPath . 'partials/nav.php' ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-8 mx-auto">
                <h2 class="mt-5 mb-5">Event Types</h2>
                <?php include_once $viewPath . 'flash/messages.php' ?>
                <a class="btn btn-success float-right mb-5" href="/admin/event-type" role="button">Create Event Type</a>
                <div class="card">
                    <div class="card-body">
                        <?php if (count($eventTypes) > 0) { ?>
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Type</th>
                                <th scope="col">Is Premium</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php foreach($eventTypes as $index => $eventType) { ?>
                                    <tr>
                                        <th scope="row"><?php echo $index + 1; ?></th>
                                        <td><?php echo $eventType['type']; ?></td>
                                        <td><?php echo $eventType['is_premium'] ? 'Yes' : 'No'; ?></td>
                                        <td><a class="btn-link" href="/admin/event-type/edit/<?php echo $eventType['id'];?>"><i class="fa fa-pencil"></i> Edit</a></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <?php }  else { ?>
                        <span>There are currently no event types</span>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include_once $viewPath . 'partials/footer.php' ?>
