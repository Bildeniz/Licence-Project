<?php
    function import_css(){
        echo '<link rel="stylesheet" href="/static/bootstrap/css/bootstrap.css">';
    }

    function import_js(){
        echo '<script src="/static/bootstrap/js/bootstrap.bundle.js"></script>';
    }

    function navbar()
    {
        echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-lg">
              <div class="container">
                <a class="navbar-brand fw-bold" href="/dashboard.php">Licence Project</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                  aria-controls="navbarNav" aria-expanded="false" aria-label="menu-collapse">
                  <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                  <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        '.$_SESSION["username"].'
                      </a>
                      <ul class="dropdown-menu" style="z-index: 1021;">
                        <li><a class="dropdown-item" href="/logout.php">Logout</a></li>
                        <li><a class="dropdown-item" href="/change_password.php">Change Password</a></li>
                      </ul>
                    </li>
                  </ul>
                </div>
              </div>
            </nav>
            ';
    }
?>