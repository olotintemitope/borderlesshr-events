<?php $title = 'Login';?>
<?php include_once $viewPath . 'partials/header.php' ?>
    <body>
<?php include_once $viewPath . 'partials/nav.php' ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-6 mx-auto">
                <h2 class="mt-5 mb-5">Login</h2>
                <div class="card">
                    <div class="card-body">
                        <form method="post" action="/auth/login" enctype="application/x-www-form-urlencoded">
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Username</label>
                                <input type="email" class="form-control" id="exampleInputEmail1"
                                       aria-describedby="emailHelp">
                                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Password</label>
                                <input type="password" class="form-control" id="exampleInputPassword1">
                            </div>
                            <button type="submit" class="btn btn-primary">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include_once $viewPath . 'partials/footer.php' ?>