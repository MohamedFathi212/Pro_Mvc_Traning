<div class="row justify-content-center">
  <div class="col-md-4">
    <h3>Login</h3>
    <?php if(!empty($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
    <form method="POST" action="index.php?action=doLogin">
      <div class="mb-3">
        <label>Email</label>
        <input type="email" placeholder="Enter your email" name="email" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Password</label>
        <input type="password" placeholder="Enter your password" name="password" class="form-control" required>
      </div>
      <button class="btn btn-primary w-100">Login</button>
    </form>
  </div>
</div>
