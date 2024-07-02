<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="<?php echo APP_URL;?>dashboard/">LOGO</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="<?php echo APP_URL;?>dashboard/">Dashboard</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Usuarios
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Nuevo</a></li>
            <li><a class="dropdown-item" href="#">Lista</a></li>
            <li><a class="dropdown-item" href="#">Buscar</a></li>
          </ul>
          <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            ** User Name **
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Mi cuenta</a></li>
            <li><a class="dropdown-item" href="#">Mi foto</a></li>
            <li><a class="dropdown-item" href="#">Salir</a></li>
          </ul>
        </li>
        </li>
      </ul>
    </div>
  </div>
</nav>