<?php $title = 'Create a new event type';?>
<?php include_once $viewPath . 'partials/header.php' ?>
<body>
<?php include_once $viewPath . 'partials/nav.php' ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-6 mx-auto mt-5">
            <h2 class="mt-5 mb-5">Create Event</h2>

            <?php include_once $viewPath . 'flash/messages.php' ?>

            <div class="card">
                <div class="card-body">
                    <form method="post" action="/admin/event/create" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" id="title" required/>
                        </div>
                        <div class="mb-3">
                            <label for="number_of_participants" class="form-label">Number of participants</label>
                            <input type="text" name="number_of_participants" class="form-control" id="number_of_participants" required/>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description of event</label>
                            <textarea type="text" name="description" class="form-control" id="description" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="date_opened" class="form-label">Event Types</label>
                            <select name="event_types[]" class="form-control" id="event_types" required multiple="multiple">
                                <?php foreach($eventTypes as $eventType) { ?>
                                    <option value="<?php echo $eventType['id']?>"><?php echo $eventType['type']?></option>
                                <?php }?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="date_opened" class="form-label">Date Open</label>
                            <input type="date" name="date_opened" class="form-control" id="date_opened" required></input>
                        </div>
                        <div class="mb-3">
                            <label for="registration_deadline_date" class="form-label">Registration Deadline</label>
                            <input type="date" name="registration_deadline_date" class="form-control" id="registration_deadline_date" required></input>
                        </div>
                        <div class="mb-3">
                            <label for="number_of_participants" class="form-label">Image Cover</label>
                            <input type="file" name="img_cover" class="form-control" id="img_cover" required/>
                        </div>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once $viewPath . 'partials/footer.php' ?>
