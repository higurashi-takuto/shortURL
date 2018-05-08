<?php

function makeRandStr($length=3){
    $str = array_merge(range('a', 'z'), range('0', '9'), range('A', 'Z'));
    $rand_str = null;
    for ($i = 0; $i < $length; $i++) {
        $rand_str .= $str[rand(0, count($str) - 1)];
    }
    return $rand_str;
}

function checkStr($str){
    $sql = 'SELECT COUNT(shortURL) AS num FROM short WHERE shortURL = ?';
    $pdo = new PDO('sqlite:url.db');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(1, $str);
    $stmt->execute();
    while($row = $stmt->fetch()){
        $num = $row['num'];
    }
    $stmt = null;
    $pdo = null;
    return empty($num);
}

if(isset($_POST['url'])){
    do{
        $str = makeRandStr();
    }while(!checkStr($str));
    $sql = 'INSERT INTO short (originalURL, shortURL) VALUES (?, ?)';
    $pdo = new PDO('sqlite:url.db');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(1, $_POST['url']);
    $stmt->bindValue(2, $str);
    $stmt->execute();
    $stmt = null;
    $pdo = null;
    $url  = empty($_SERVER["HTTPS"]) ? "http://" : "https://";
    $url .= $_SERVER["HTTP_HOST"] . '/' . $str;
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>登録完了</title>
</head>
<body>
    <h1><a href="<?=$url?>"><?=$url?></a>に登録されました。</h1>
</body>
</html>