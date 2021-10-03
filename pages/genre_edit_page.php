<?php
$updateId = filter_input(INPUT_GET, 'uid');
if (isset($updateId)) {
    $link = new PDO("mysql:host=localhost; dbname=demo_pw220211",
    "root","");
    $link->setAttribute(PDO::ATTR_AUTOCOMMIT, false);
    $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = "SELECT id, name FROM genre WHERE id=?";
    $stmt = $link->prepare($query);
    $stmt->bindParam(1, $updateId, PDO::PARAM_INT);
    $stmt->execute();
    $genre = $stmt->fetch();
    $link = null;
}

$submitted = filter_input(INPUT_POST,"btnUpdate");
if($submitted){
    $name = filter_input(INPUT_POST, "txtName");
    $link = new PDO("mysql:host=localhost; dbname=demo_pw220211", 
    "root","");
    $link->setAttribute(PDO::ATTR_AUTOCOMMIT, false);
    $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = "UPDATE genre SET name = ? WHERE id = ?";
    $stmt = $link->prepare($query);
    $stmt->bindParam(1, $name, PDO::PARAM_STR);
    $stmt->bindParam(2, $genre['id'], PDO::PARAM_INT);
    $link->beginTransaction();
    if ($stmt->execute()){
        $link->commit();
        header("location:index.php?mn=genre");
    } else{
        $link->rollBack();
    }
    $link = null;
}
?>




<form action="" method="post">
    <label for="">ID</label>
    <input type="text" name="txtId" id="idField" readonly value="<?php echo $genre
    ['id']?>">
    <label for="nameId">Name</label>
    <input type="text" name="txtName" id="nameId" maxlength="100" placeholder="Genre Name"
    value="<?php echo $genre['name']?>">
    <input type="submit" value="Update" name="btnUpdate">
</form>