<div class="container my-4">
    <h3 class="mb-4"> Articles</h3>

    <?php
    if ($articles->num_rows > 0):
        echo "<p>Total Articles: " . $articles->num_rows . "</p>";
    else:
        echo "<p>No Articles Found</p>";
    endif;
    ?>

    <div class="row">
        <?php while ($row = $articles->fetch_assoc()): ?>
            <div class="col-sm-6 col-md-4 mb-3">
                <div class="card h-100">
                    <?php if (!empty($row['image'])): ?>
                        <img src="uploads/<?= htmlspecialchars($row['image']) ?>" class="card-img-top" style="height:180px; object-fit:cover">
                    <?php endif; ?>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?= htmlspecialchars($row['title']) ?></h5>
                        <p class="card-text"><?= ($row['content'])?>...</p>
                        <p>Category: <?= htmlspecialchars($row['category_name']) ?></p>
                        <p>Status: <?= $row['is_active'] == 1 ? 'Active' : 'Inactive' ?></p>
                        <a href="index.php?action=articles.show&id=<?= $row['id'] ?>"
                            class="btn btn-primary mt-auto"
                            style="padding: 2px 3px; font-size: 15px; line-height: 2;">
                            View
                        </a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>