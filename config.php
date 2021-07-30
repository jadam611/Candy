<?php
session_start();

$conn = new SQLite3("DB") or die ("unable to open database");

function createTable($sqlStmt, $tableName)
{
    global $conn;
    $stmt = $conn->prepare($sqlStmt);
    if ($stmt->execute()) {
        echo "<p style='color: green'>".$tableName. ": Table Created Successfully</p>";
    } else {
        echo "<p style='color: red'>".$tableName. ": Table Created Failure</p>";
    }
}

function addUser($username, $unhashedPassword, $name, $profilePic, $accessLevel) {
    global $conn;
    $hashedPassword = password_hash($unhashedPassword, PASSWORD_DEFAULT);
    $sqlstmt = $conn->prepare("INSERT INTO user (username, password, name, profilePic, accessLevel) VALUES (:userName, :hashedPassword, :name, :profilePic, :accessLevel)");
    $sqlstmt->bindValue(':userName', $username);
    $sqlstmt->bindValue(':hashedPassword', $hashedPassword);
    $sqlstmt->bindValue(':name', $name);
    $sqlstmt->bindValue(':profilePic', $profilePic);
    $sqlstmt->bindValue(':accessLevel', $accessLevel);
    if ($sqlstmt->execute()) {
        echo "<p style='color: green'>User: ".$username. ": Created Successfully</p>";
    } else {
        echo "<p style='color: red'>User: ".$username. ": Created Failure</p>";
    }
}
function add_product($productName, $productCategory, $productQuantity, $productPrice, $productImage, $productCode) {
    global$conn;
    $sqlstmt = $conn->prepare("INSERT INTO products (productName, category, quantity, price, image, code) VALUES (:name, :category, :quantity, :price, :image, :code)");
    $sqlstmt->bindValue(':name', $productName);
    $sqlstmt->bindValue(':category', $productCategory);
    $sqlstmt->bindValue(':quantity', $productQuantity);
    $sqlstmt->bindValue(':price', $productPrice);
    $sqlstmt->bindValue(':image', $productImage);
    $sqlstmt->bindValue(':code', $productCode);

    if($sqlstmt->execute()) {
        echo"<p style='color: green'>Product:".$productName.": Created Successfully</p>";
    }else{
        echo"<p style='color: red'>Product:".$productName.": Created Failure</p>";
    }
}
$query= $conn->query("SELECT COUNT(*) as count FROM user");
$rowCount = $query->fetchArray();
$userCount = $rowCount["count"];


$query = file_get_contents("sql/create-user.sql");
createTable($query, "User");

$query = file_get_contents("sql/Products.sql");
createTable($query, "Products");

if ($userCount == 0) {
    addUser("admin", "admin", "Administrator", "admin.jpg", "Administrator");
    addUser("user", "user", "User", "user.jpg", "User");
    addUser("ryan", "ryan", "Ryan", "ryan.jpg", "User");
}
$query= $conn->query("SELECT COUNT(*) as count FROM products");
$rowCount = $query->fetchArray();
$productCount = $rowCount["count"];

if($productCount == 0) {
    add_product('Takis Fuego','Chips', 75, 5.99,'takisf.jpg','TAKISF9102');
    add_product('Takis Blue Heat','Chips', 45, 5.99,'takisb.jpg','TAKISB9102');
    add_product('Flamin Hot Cheetos' ,'Chips', 29, 5.99,'flamin.jpg','CHEET9102');
    add_product('Twizzlers Raspberry','Lollies', 145, 4.99,'twizzlersr.jpg','TWIZR9102');
    add_product('Twizzlers Strawberry','Lollies', 62, 4.99,'twizzlerss.jpg','TWIZS9102');
    add_product('Mike and Ike Sour','Lollies', 34, 6.99,'MAIS.jpg','MAIS9102');
    add_product('Mike and Ike Mega','Lollies', 49, 6.99,'MAIA.jpg','MAIA9102');
    add_product('Hersheys Chocolate ','Chocolate', 193, 3.50,'hershey.jpg','HERSH9102');
    add_product('Reeces Peanutbutter Cups','Chocolate', 128, 3.50,'reeces.jpg','REEC9102');
    add_product('Milk Duds','Chocolate', 32, 4.50,'milkd.jpg','MILKD9102');
}
?>
