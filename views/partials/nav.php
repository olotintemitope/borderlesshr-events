<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">Event Manager</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse float-right" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="/events">Upcoming events</a>
                </li>
                <li class="nav-item">
                    <?php if (!isset($_SESSION['username'])) { ?>
                        <a class="nav-link" href="/auth/login">Login</a>
                    <?php } else { ?>
                        <a class="nav-link">Welcome <?php echo $_SESSION['username']; ?></a>
                    <?php } ?>
                </li>
                <?php if (isset($_SESSION['username'])) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/auth/logout">Logout</a>
                    </li>
                    <li class="nav-item">
                        <span></span><a class="nav-link" href="/admin/events">Events</a>
                    </li>
                    <li class="nav-item">
                        <span></span><a class="nav-link" href="/admin/event-types">Event Types</a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>