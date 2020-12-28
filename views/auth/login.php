<?php $title = 'Login';?>
<?php include_once $viewPath . 'partials/header.php' ?>
    <body>
<?php include_once $viewPath . 'partials/nav.php' ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-6 mx-auto mt-5">
                <?php if (isset($_SESSION['error'])) { ?>
                    <div class="alert alert-danger" role="alert">
                       <?php echo $_SESSION['error'];?>
                    </div>
                    <?php unset($_SESSION['error']);?>
                <?php }?>
                <h2 class="mt-5 mb-5">Login</h2>
                <div class="card">
                    <div class="card-body">
                        <form method="post" action="/auth/login" enctype="application/x-www-form-urlencoded">
                            <div class="mb-3">
                                <label for="email" class="form-label">Username</label>
                                <input type="email" name="username" class="form-control" id="email" aria-describedby="emailHelp" required/>
                                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" id="password" required/>
                            </div>
                            <button type="submit" class="btn btn-primary" name="submit">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include_once $viewPath . 'partials/footer.php' ?>
