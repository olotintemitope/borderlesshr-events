<?php $title = 'List Event Types';?>
<?php include_once $viewPath . 'partials/header.php' ?>
<body>
<?php include_once $viewPath . 'partials/nav.php' ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-8 mx-auto">
            <h2 class="mt-5 mb-5">Events</h2>
            <?php include_once $viewPath . 'flash/messages.php' ?>
            <a class="btn btn-success float-right mb-5" href="/admin/event" role="button">Create Event</a>
            <div class="card">
                <div class="card-body">
                    <?php if (count($events) > 0) { ?>
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Title</th>
                                <th scope="col">Number of Participants</th>
                                <th scope="col">Date Opened</th>
                                <th scope="col">Registration Deadline</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($events as $index => $event) { ?>
                                <tr>
                                    <th scope="row"><?php echo $index + 1; ?></th>
                                    <td><?php echo $event['title']; ?></td>
                                    <td><?php echo $event['number_of_participants']; ?></td>
                                    <td><?php echo $event['date_opened']; ?></td>
                                    <td><?php echo $event['registration_deadline_date']; ?></td>
                                    <td><a class="btn-link" href="/admin/event/edit/<?php echo $event['id'];?>"><i class="fa fa-pencil"></i> Edit</a></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    <?php }  else { ?>
                        <span>There are currently no events</span>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once $viewPath . 'partials/footer.php' ?>
