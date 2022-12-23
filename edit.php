<?php
$pdo = new PDO('sqlite:data.db', null, null, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
]);
$error = null;
$id = $pdo->quote($_GET['id']);

try {
    if(isset($_POST['name'], $_POST['content'])){
        
    }
    $query = $pdo->prepare('SELECT * FROM posts WHERE id = :id');
    $query->execute([
        'id' => $_GET['id']
    ]);
    $posts = $query->fetch();
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
            <form action="" method="post">
                <div class="form-group mt-4">
                    <input type="text" class="form-control" name="name"
                           value="<?php echo htmlentities($posts->name) ?>">
                </div>
                <div class="form-group mt-4">
                    <textarea class="form-control" name="content"><?php echo htmlentities($posts->content) ?></textarea>
                </div>
                <button class="btn btn-primary mt-4">Sauvegarder</button>
            </form>
        <?php endif; ?>
    </div>

<?php
require 'footer.php';
?>