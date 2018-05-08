<?php

function h($str){
    return htmlspecialchars($str);
}

if(isset($_GET['short'])){
    $sql = 'SELECT originalURL, count FROM short WHERE shortURL = ?';
    $pdo = new PDO('sqlite:url.db');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(1, $_GET['short']);
    $stmt->execute();
    while($row = $stmt->fetch()){
        $url = $row['originalURL'];
        $count = $row['count'];
    }
    $sql = 'UPDATE short SET count = ? WHERE shortURL = ?';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(1, $count + 1);
    $stmt->bindValue(2, $_GET['short']);
    $stmt->execute();
    $stmt = null;
    $pdo = null;
    header('Location: ' . $url);
    exit;
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>shortURL</title>
</head>
<body>
    <form action="/make.php" method="post">
        <input type="text" name="url">
        <button type="submit">作成</button>
    </form>
    <?php
    $sql = 'SELECT * FROM short';
    $pdo = new PDO('sqlite:url.db');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    echo '<table border="1"><th>オリジナルURL</th><th>短縮URL</th><th>クリック数</th>';
    while($row = $stmt->fetch()){
        echo '<tr>';
        echo '<td>' . $row['originalURL'] .'</td>';
        echo '<td>' . $_SERVER["HTTP_HOST"] . '/' . $row['shortURL'] .'</td>';
        echo '<td align="right">' . $row['count'] .'</td>';
        echo '</tr>';
    }
    $stmt = null;
    $pdo = null;
    echo '</table>';
    ?>
</body>
</html>