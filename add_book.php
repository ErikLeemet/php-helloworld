<?php
    require_once "connection.php";

    if ( isset($_POST['submit'])) {
            $stmt = $pdo->prepare('INSERT INTO books (title, release_date, cover_path, language, summary, price, stock_saldo, pages, type) VALUES (:title, :release_date, :cover_path, :language, :summary, :price, :stock_saldo, :pages, :type);');
            $stmt->execute(['title' => $_POST['title'], 'release_date' => $_POST['release_date'], 'cover_path' => $_POST['cover_path'], 'language' => $_POST['language'], 'summary' => $_POST['summary'], 'price' => $_POST['price'], 'stock_saldo' => $_POST['stock_saldo'], 'pages' => $_POST['pages'], 'type' => $_POST['type']]);
            $id = $pdo ->lastInsertId();
            $stmt = $pdo->prepare('INSERT INTO book_authors (book_id, author_id) VALUES (:book_id, :author_id);');
            $stmt->execute(['book_id' => $id , 'author_id' => $_POST["author"]]);
    }
    $stmt = $pdo->query('SELECT * FROM authors order by id desc');
    var_dump($id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="add_book.php" method="post">
        Pealkiri: <input type="text" name="title">
        <br><br>
        Author: <select name="author">
            <?php while ($author = $stmt->fetch()): ?>
                <option value="<?= $author['id']; ?>"><?= $author['first_name']; ?> <?= $author['last_name']; ?></option>
        <?php endwhile; ?>
        </select>
        Date: <input type="date" name="release_date">
        <br><br>
        image (URL): <input type="text" name="cover_path">
        <br><br>
        Language: <input type="text" name="language">
        <br><br>
        summary:
        <br>
        <textarea name="summary" rows="6" cols="40"></textarea>
        <br><br>
        price: <input type="text" name="price">
        <br><br>
        stock: <input type="text" name="stock_saldo">
        <br><br>
        pages: <input type="text" name="pages">
        <br><br>
        <select name="type">
            <option value="new">Uus</option>
            <option value="ebook">E-raamat</option>
            <option value="used">kasutatud</option>
        </select>
        <input type="submit" name="submit" value="Lisa">
    </form>
</body>
</html>
