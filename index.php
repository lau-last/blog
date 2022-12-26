<?php

require 'Post.php';

$pdo = new PDO('sqlite:data.db', null, null, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
]);
$error = null;
try {
    if (isset($_POST['name'], $_POST['content'])) {
        $query = $pdo->prepare('INSERT INTO posts (name, content, created) VALUES (:name, :content, :created)');
        $query->execute([
            'name' => $_POST['name'],
            'content' => $_POST['content'],
            'created' => time()
        ]);
        header('Location: edit.php?id=' . $pdo->lastInsertId());
        exit();
    }
    $query = $pdo->query('SELECT * FROM posts');
    $posts = $query->fetchAll(PDO::FETCH_CLASS, 'Post');


} catch (PDOException $e) {
    $error = $e->getMessage();
}

require 'header.php';

?>

    <div class="container">
        <?php if ($error): ?>
            <div class="alert alert-danger">
                <?php echo $error ?>
            </div>
        <?php else: ?>
            <ul>
                <?php foreach ($posts as $post): ?>
                    <h2><a href="edit.php?id=<?php echo $post->id ?>"><?php echo htmlentities($post->name) ?></a></h2>
                    <p>
                        <?php echo nl2br(htmlentities($post->getExcerpt())) ?>
                    </p>
                    <p class="small text-muted">
                        Ecrit le <?php echo $post->created->format('d/m/Y à H:i') ?>
                    </p>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <form action="" method="post">
            <div class="form-group mt-4">
                <input type="text" class="form-control" name="name" value="">
            </div>
            <div class="form-group mt-4">
                <textarea class="form-control" name="content"></textarea>
            </div>
            <button class="btn btn-primary mt-4">Sauvegarder</button>
        </form>
    </div>

<?php

require 'footer.php';

?>