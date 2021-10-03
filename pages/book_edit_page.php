<?php
$updatedIsbn = filter_input(INPUT_GET, 'uid');
if (isset($updatedIsbn)){
    $link = new PDO("mysql:host=localhost; dbname=demo_pw220211", 
    "root", "");
    $link->setAttribute(PDO::ATTR_AUTOCOMMIT, false);
    $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = "SELECT isbn, title, author, publisher, deskripsi, cover, genre_id FROM book WHERE isbn = ?";
    $stmt = $link->prepare($query);
    $stmt->bindParam(1, $updatedIsbn, PDO::PARAM_STR);
    $stmt->execute();
    $book = $stmt->fetch();
    $link = null;
}

$submitted = filter_input(INPUT_POST,"btnUpdateB");
if($submitted){
    $isbn = filter_input(INPUT_POST, 'txtIsbn');
    $title = filter_input(INPUT_POST, 'txtTitle');
    $author = filter_input(INPUT_POST, 'txtAuthor');
    $publisher = filter_input(INPUT_POST, 'txtPub');
    $deskripsi = filter_input(INPUT_POST, 'txtDes');
    $cover = filter_input(INPUT_POST, 'txtCover');
    $genreId = filter_input(INPUT_POST, 'txtGenreId');
    $link = new PDO("mysql:host=localhost; dbname=demo_pw220211", 
    "root", "");
    $link->setAttribute(PDO::ATTR_AUTOCOMMIT, false);
    $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = "UPDATE book SET title=?, author=?, publisher=?, 
    deskripsi=?, cover=?, genre_id=? 
    WHERE isbn = ?";
    $stmt = $link->prepare($query);
    $stmt->bindParam(1, $title, PDO::PARAM_STR);
    $stmt->bindParam(2, $author, PDO::PARAM_STR);
    $stmt->bindParam(3, $publisher, PDO::PARAM_STR);
    $stmt->bindParam(4, $deskripsi, PDO::PARAM_STR);
    $stmt->bindParam(5, $cover, PDO::PARAM_STR);
    $stmt->bindParam(6, $genreId, PDO::PARAM_INT);
    $stmt->bindParam(7, $book['isbn'], PDO::PARAM_INT);
    $link->beginTransaction();
    if ($stmt->execute()){
        $link->commit();
        header("location:index.php?mn=book");
    } else{
        $link->rollBack();
    }
    $link = null;
}
?>
<form action="" method="post">
    <label for="isbn">ISBN</label>
    <input type="text" name="txtIsbn" id="isbn" readonly value="<?php echo $book['isbn'] ?>">
    <label for="title">Title</label>
    <input type="text" name="txtTitle" id="title" maxlength="100" placeholder="Title" value="<?php echo $book['title'] ?>">
    <label for="author">Author</label>
    <input type="text" name="txtAuthor" id="author" maxlength="100" placeholder="Author" value="<?php echo $book['author'] ?>">
    <label for="pub">Publisher</label>
    <input type="text" name="txtPub" id="publisher" maxlength="100" placeholder="Publisher" value="<?php echo $book['publisher'] ?>">
    <label for="des">Deskripsi</label>
    <input type="text" name="txtDes" id="deskripsi" maxlength="100" placeholder="Deskripsi" value="<?php echo $book['deskripsi'] ?>">
    <label for="cover">Cover</label>
    <input type="text" name="txtCover" id="cover" maxlength="100" placeholder="Cover" value="<?php echo $book['cover'] ?>">
    <label for="genreID">Genre ID</label>
    <input type="text" name="txtGenreId" id="genreID" maxlength="100" placeholder="Genre ID" value="<?php echo $book['genre_id'] ?>">
    <input type="submit" value="update" name="btnUpdateB">
</form>