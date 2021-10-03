<?php
$command = filter_input(INPUT_GET, 'tok');
if (isset($command) && $command == 'del') {
    $deletedIsbn = filter_input(INPUT_GET, 'did');
    if (isset($deletedIsbn)) {
        $link = new PDO(
            "mysql:host=localhost; dbname=demo_pw220211",
            "root","");
        $link->setAttribute(PDO::ATTR_AUTOCOMMIT, false);
        $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = "DELETE FROM book WHERE isbn=?";
        $stmt = $link->prepare($query);
        $stmt->bindParam(1, $deletedIsbn, PDO::PARAM_STR);
        $link->beginTransaction();
        if ($stmt->execute()) {
            $link->commit();
        } else {
            $link->rollback();
        }
        $link = null;
    }
}
$submitted = filter_input(INPUT_POST, 'btnSubmitB');
if ($submitted) {
    $isbn = filter_input(INPUT_POST, 'txtIsbn');
    $title = filter_input(INPUT_POST, 'txtTitle');
    $author = filter_input(INPUT_POST, 'txtAuthor');
    $publisher = filter_input(INPUT_POST, 'txtPub');
    $deskripsi = filter_input(INPUT_POST, 'txtDes');
    $cover = filter_input(INPUT_POST, 'txtCover');
    $gendreId = filter_input(INPUT_POST, 'txtGendreId');
    $link = new PDO(
        "mysql:host=localhost; dbname=demo_pw220211",
        "root","");
    $link->setAttribute(PDO::ATTR_AUTOCOMMIT, false);
    $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = "INSERT INTO book(isbn, title, author, publisher, deskripsi, cover, genre_id) 
    VALUES(?,?,?,?,?,?,?)";
    $stmt = $link->prepare($query);
    $stmt->bindParam(1, $isbn, PDO::PARAM_STR);
    $stmt->bindParam(2, $title, PDO::PARAM_STR);
    $stmt->bindParam(3, $author, PDO::PARAM_STR);
    $stmt->bindParam(4, $publisher, PDO::PARAM_STR);
    $stmt->bindParam(5, $deskripsi, PDO::PARAM_STR);
    $stmt->bindParam(6, $cover, PDO::PARAM_STR);
    $stmt->bindParam(7, $gendreId, PDO::PARAM_INT);
    $link->beginTransaction();
    if ($stmt->execute()) {
        $link->commit();
    } else {
        $link->rollback();
    }
    $link = null;
}
?>

<h1> BOOK </h1>

<form action="" method="post">
    <label for="isbn">ISBN</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="text" id="isbn" name="txtIsbn" placeholder="Isbn" maxlength="100"></br></br>
    <label for="title">Title</label> &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
    <input type="text" id="title" name="txtTitle" placeholder="Title Book" maxlength="100"></br></br>
    <label for="author">Author</label>&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="text" id="author" name="txtAuthor" placeholder="Author" maxlength="100"></br></br>
    <label for="publisher">Publisher</label>
    <input type="text" id="publisher" name="txtPub" placeholder="Publisher" maxlength="100"></br></br>
    <label for="deskripsi">Deskripsi</label>
    <input type="text" id="deskripsi" name="txtDes" placeholder="Deskripsi" maxlength="100"></br></br>
    <label for="cover">Cover</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="text" id="cover" name="txtCover" placeholder="Cover" maxlength="100"></br></br>
    <label for="gendreId">Genre ID</label>
    <input type="text" id="gendreId" name="txtGendreId" placeholder="Genre Id" maxlength="100"></br></br>
    <input type="submit" value="Submit" name="btnSubmitB">
</form>

<table cellspacing="35">
    <thread>
        <th>ISBN</th>
        <th>Title</th>
        <th>Author</th>
        <th>Publisher</th>
        <th>Deskripsi</th>
        <th>Cover</th>
        <th>Genre_ID</th>
    </thread>
    <tbody>
        <?php
        $link = new PDO(
            "mysql:host=localhost; dbname=demo_pw220211",
            "root", "" );
        $link->setAttribute(PDO::ATTR_AUTOCOMMIT, false);
        $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = "SELECT isbn, title, author, publisher, deskripsi, cover, genre_id FROM book";
        $books = $link->query($query);
        foreach($books as $book) {
            echo "<tr>";
            echo "<td>" . $book['isbn'] . "</td>";
            echo "<td>" . $book['title'] . "</td>";
            echo "<td>" . $book['author'] . "</td>";
            echo "<td>" . $book['publisher'] . "</td>";
            echo "<td>" . $book['deskripsi'] . "</td>";
            echo "<td>" . $book['cover'] . "</td>";
            echo "<td>" . $book['genre_id'] . "</td>";
            echo "<td><button onclick='editBook(" . $book['isbn']. ")'>Edit</button>
            <button onclick='deleteBook(" . $book['isbn']. ")'>Delete</button></td>";
            echo "</tr>";
        }
        $link = null;
        ?>
    </tbody>
</table>