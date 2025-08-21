<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!doctype html>
<html lang="en" dir="ltr">
<head>
  <meta charset="UTF-8">
  <title>Blogs MVC</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="index.php?action=articles.index">All Blogs</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav"><span class="navbar-toggler-icon"></span></button>
    <div id="nav" class="collapse navbar-collapse">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link" href="index.php?action=articles.all">Blogs </a></li>
        <?php if(!empty($_SESSION['user_id'])): ?>
          <li class="nav-item"><a class="nav-link" href="index.php?action=articles.create">Add Article</a></li>
        <?php endif; ?>
      </ul>
      <div class="d-flex">
        <?php if(!empty($_SESSION['user_id'])): ?>
          <span class="navbar-text text-white me-3">Hi, <?= htmlspecialchars($_SESSION['username']) ?></span>
          <a class="btn btn-outline-light btn-sm" href="index.php?action=logout">Logout</a>
        <?php else: ?>
          <a class="btn btn-outline-light btn-sm me-2" href="index.php?action=login">Login</a>
          <a class="btn btn-warning btn-sm" href="index.php?action=register">Register</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>
<div class="container mt-4">
