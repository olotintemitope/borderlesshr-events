<?php $title = 'Login';?>
<?php include_once $viewPath . 'partials/header.php' ?>
    <body>
<?php include_once $viewPath . 'partials/nav.php' ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-6 mx-auto mt-5">
                <?php include_once $viewPath . 'flash/messages.php' ?>
                <h2 class="mt-5 mb-5">Login</h2>
                <div class="card">
                    <div class="card-body">
                        <form method="post" action="/auth/login" enctype="application/x-www-form-urlencoded">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" name="username" class="form-control" id="username" required/>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" id="password" required/>
                            </div>

                            <button type="submit" class="btn btn-primary" name="submit">Login</button>

                            <p class="text-right w-100">
                                <span class="form-text">New to this platform? <a href="/auth/register" class="link">Signup</a></span>
                            </p>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include_once $viewPath . 'partials/footer.php' ?>
