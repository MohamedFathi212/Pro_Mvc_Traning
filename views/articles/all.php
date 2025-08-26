<div class="container my-4">
    <h3 class="mb-4"> Articles</h3>

    <?php
    if ($articles->num_rows > 0):
        echo "<p>Total Articles: " . $articles->num_rows . "</p>";
    else:
        echo "<p>No Articles Found</p>";
    endif;
    ?>

    <div class="row g-3">
  <?php while ($row = $articles->fetch_assoc()): ?>
    <div class="col-md-4">
      <div class="card h-100">
        <?php if (!empty($row['image'])): ?>
          <img src="uploads/<?= htmlspecialchars($row['image']) ?>" class="card-img-top" alt="image" style="max-height:200px; object-fit:cover;">
        <?php endif; ?>
        <div class="card-body">
          <h5 class="card-title"><?= htmlspecialchars($row['title']) ?></h5>
          <p class="text-muted mb-1">Category: <?= htmlspecialchars($row['category_name'] ?? '—') ?></p>
          <p class="text-muted mb-1">Published by: <?= htmlspecialchars($row['username'] ?? 'Unknown') ?></p>
          <p class="card-text"><?= substr(strip_tags($row['content']), 0, 100) ?>...</p>
          <p class="card-text"><b> Status </b>: <?= $row['is_active'] ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Inactive</span>' ?></p>
          <a class="btn btn-sm btn-outline-secondary" href="index.php?action=articles.show&id=<?= $row['id'] ?>">Read</a>
          <?php if (!empty($_SESSION['user_id']) && $_SESSION['user_id'] == $row['user_id']): ?>
            <a class="btn btn-sm btn-outline-primary" href="index.php?action=articles.edit&id=<?= $row['id'] ?>">Edit</a>
            <a class="btn btn-sm btn-outline-danger" href="index.php?action=articles.delete&id=<?= $row['id'] ?>" onclick="return confirm('Delete this article?')">Delete</a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  <?php endwhile; ?>
</div>
