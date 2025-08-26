<h3><?= htmlspecialchars($article['title']) ?></h3>
<p class="text-muted">Created by: <?= htmlspecialchars($article['username'] ?? 'Unknown') ?></p>

<?php if (!empty($article['image'])): ?>
  <p>Category: <?= htmlspecialchars($article['category_name']) ?></p>
  <img src="uploads/<?= htmlspecialchars($article['image']) ?>" style="width:100%;max-height:400px;object-fit:cover">
<?php endif; ?>

<p class="card-text"><?= nl2br(htmlspecialchars($article['content'])) ?></p>

<h5 class="mt-4">Comments</h5>
<div id="commentsList">
  <?php while ($c = $comments->fetch_assoc()): ?>
    <div class="border p-2 mb-2"><strong><?= htmlspecialchars($c['username']) ?>:</strong> <?= htmlspecialchars($c['comment_text']) ?></div>
  <?php endwhile; ?>
</div>

<?php if (!empty($_SESSION['user_id'])): ?>
  <form id="commentForm" method="POST">
    <input type="hidden" name="article_id" value="<?= $article['id'] ?>">
    <div class="mb-3">
      <textarea name="comment_text" class="form-control" rows="3" required></textarea>
    </div>
    <button class="btn btn-success btn-sm">Add Comment</button>
  </form>
<?php else: ?>
  <p><a href="index.php?action=login" style="text-decoration: none;"><b>Login</b></a> to comment</p>
<?php endif; ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).on("submit", "#commentForm", function(e){
    e.preventDefault();

    $.post("index.php?action=comments.ajaxStore", $(this).serialize(), function(data){
        if(data.success){
            $("#commentsList").prepend(
                `<div class="border p-2 mb-2"><strong>${data.username}:</strong> ${data.comment_text}</div>`
            );
            $("#commentForm textarea").val("");
        } else {
            alert(data.message);
        }
    }, "json");
});
</script>