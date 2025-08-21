<h3>Add Article</h3>
<form method="POST" action="index.php?action=articles.store" enctype="multipart/form-data">
  <div class="mb-3">
    <label>Title</label>
    <input type="text" name="title" class="form-control" required>
  </div>
  <div class="mb-3">
    <label>Content</label>
    <textarea name="content" class="form-control" rows="5" required></textarea>
  </div>
  <div class="mb-3">
    <label class="form-label">Category</label>
    <select name="category_id" class="form-select" required>
      <?php while($c = $categories->fetch_assoc()): ?>
        <option value="<?= $c['id'] ?>">
          <?= htmlspecialchars($c['name']) ?>
        </option>
      <?php endwhile; ?>
    </select>
  </div>
  <div class="mb-3">
    <label>Image</label>
    <input type="file" name="image" class="form-control">
  </div>
  <div class="mb-3">
    <label>Active</label>
    <select name="is_active" class="form-select" required>
      <option value="1" selected>Active</option>
      <option value="0">Inactive</option>
    </select>
  </div>
  <button class="btn btn-success">Add Article</button>
</form>
