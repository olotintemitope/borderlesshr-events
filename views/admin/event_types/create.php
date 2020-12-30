<?php $title = 'Create a new event type';?>
<?php include_once $viewPath . 'partials/header.php' ?>
<body>
<?php include_once $viewPath . 'partials/nav.php' ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-6 mx-auto mt-5">
            <h2 class="mt-5 mb-5">Create Event Type</h2>

            <?php include_once $viewPath . 'flash/messages.php' ?>

            <div class="card">
                <div class="card-body">
                    <form method="post" action="/admin/event-type/create" enctype="application/x-www-form-urlencoded">
                        <div class="mb-3">
                            <label for="email" class="form-label">Type</label>
                            <input type="text" name="type" class="form-control" id="type" required/>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="0" id="is_premium" name="is_premium" onclick="checkPremium();">
                                <label class="form-check-label" for="is_premium">
                                    Is Premium?
                                </label>
                            </div>
                            <script>
                                function checkPremium (){
                                    const isChecked = document.getElementById('is_premium');
                                    document.getElementById('is_premium').value === "0" ? isChecked.value = "1" : isChecked.value = "0";
                                }
                            </script>
                        </div>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once $viewPath . 'partials/footer.php' ?>
