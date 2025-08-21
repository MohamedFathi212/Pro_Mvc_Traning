<h3>Edit Article</h3>
<form method="POST" action="index.php?action=articles.update" enctype="multipart/form-data">
  <input type="hidden" name="id" value="<?= $article['id'] ?>">
  <div class="mb-3">
    <label>Title</label>
    <input type="text" name="title" class="form-control" required value="<?= htmlspecialchars($article['title']) ?>">
  </div>
  <div class="mb-3">
    <label>Content</label>
    <textarea name="content" class="form-control" rows="5" required><?= htmlspecialchars($article['content']) ?></textarea>
  </div>

    <div class="mb-3">
    <label class="form-label">Category</label>
    <select name="category_id" class="form-select" required>
      <?php while($c = $categories->fetch_assoc()): ?>
        <option value="<?= $c['id'] ?>" <?= ($c['id']==$article['category_id'])?'selected':'' ?>>
          <?= htmlspecialchars($c['name']) ?>
        </option>
      <?php endwhile; ?>
    </select>
  </div>
  
  <div class="mb-3">
    <label>Image</label>
    <input type="file" name="image" class="form-control">
    <?php if(!empty($article['image'])): ?>
      <img src="uploads/<?= $article['image'] ?>" style="height:100px; margin-top:10px">
    <?php endif; ?>
  </div>
  <div class="mb-3">
    <label>Active</label>
    <select name="is_active" class="form-select" required>
      <option value="1" <?= $article['is_active']==1?'selected':'' ?>>Active</option>
      <option value="0" <?= $article['is_active']==0?'selected':'' ?>>Inactive</option>
    </select>
  </div>
  <button class="btn btn-primary">Update Article</button>
</form>
