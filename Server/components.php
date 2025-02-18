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
                    <li class="nav-item">
                      <a class="nav-link active" href="/logout.php">Logout</a>
                    </li>
                  </ul>
                </div>
              </div>
            </nav>
            ';
    }
?>