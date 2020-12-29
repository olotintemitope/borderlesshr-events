<?php $title = 'Create a new event type';?>
<?php include_once $viewPath . 'partials/header.php' ?>
<body>
<?php include_once $viewPath . 'partials/nav.php' ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-6 mx-auto mt-5">
            <h2 class="mt-5 mb-5">Edit Event</h2>

            <?php include_once $viewPath . 'flash/messages.php' ?>

            <div class="card">
                <div class="card-body">
                    <form method="post" action="/admin/event/update/<?php echo $event['id'];?>" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" id="title" required value="<?php echo $event['title'];?>"/>
                        </div>
                        <div class="mb-3">
                            <label for="number_of_participants" class="form-label">Number of participants</label>
                            <input type="text" name="number_of_participants" class="form-control" id="number_of_participants" required value="<?php echo $event['number_of_participants'];?>"/>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description of event</label>
                            <textarea type="text" name="description" class="form-control" id="description" required>value="<?php echo $event['description'];?>"</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="date_opened" class="form-label">Date Open</label>
                            <input type="date" name="date_opened" class="form-control" id="date_opened" value="<?php echo (new \DateTime($event['date_opened']))->format('Y-m-d'); ?>" required/>
                        </div>
                        <div class="mb-3">
                            <label for="registration_deadline_date" class="form-label">Registration Deadline</label>
                            <input type="date" name="registration_deadline_date" class="form-control" id="registration_deadline_date" value="<?php echo (new \DateTime($event['registration_deadline_date']))->format('Y-m-d');?>" required/>
                        </div>
                        <div class="mb-3">
                            <img src="<?php echo $viewPath . "../../"?>uploads/<?php echo $event['img_cover'];?>" width="200" height="200">
                            <label for="number_of_participants" class="form-label">Image Cover</label>
                            <input type="file" name="img_cover" class="form-control" id="img_cover"/>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once $viewPath . 'partials/footer.php' ?>
