<nav class="navbar navbar-expand-lg navbar-dark bg-success mb-4">
  <div class="container">
    <a class="navbar-brand" href="index.php">BorneoPedia</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="about.php">About Us</a></li>
        <li class="nav-item"><a class="nav-link" href="contents.php">Contents</a></li>
      </ul>
      <ul class="navbar-nav">
        <?php if(isset($_SESSION['status']) && $_SESSION['status'] == 'login'): ?>
            <li class="nav-item"><span class="nav-link text-white">Hi, <?= $_SESSION['username'] ?></span></li>
            <li class="nav-item"><a class="nav-link btn btn-warning text-dark btn-sm mx-2" href="upload.php">Upload +</a></li>
            <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
        <?php else: ?>
            <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
            <li class="nav-item"><a class="nav-link" href="register.php">Daftar</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>