<?php
$pdo = new PDO('sqlite:data.db', null, null, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
]);
$error = null;
try {
    $query = $pdo->query('SELECT * FROM posts');
    $posts = $query->fetchAll();
} catch (PDOException $e) {
    $error = $e->getMessage();
}
require 'header.php';
?>

<?php if ($error): ?>
    <div class="alert alert-danger">
    <?php echo $error ?>
    </div>
<?php else: ?>
    <ul>
        <?php foreach ($posts as $post): ?>
            <li><a href="edit.php?id=<?php echo $post->id ?>"><?php echo htmlentities($post->name) ?></a></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php
require 'footer.php';
?>