# shortURL
短縮URLを作成するプログラムです。htmlは最低限しか書いてないので、デザイン要素が皆無です。  
SQLiteを使っているので小規模向けです。  
URLは「ドメイン/〇〇〇」と三文字のランダムな文字列となります。

# 動作環境
PHP / .htaccessを使える環境

# index.php
トップページで、URLの一覧の確認と新規登録を行えます。  
<img src="https://user-images.githubusercontent.com/29699789/39768987-cf0b07de-5325-11e8-8b15-a26c98a23f97.png">

# make.php
短縮URLを作成します。

# url.db
URLを登録しておくデータベースです。  
テーブル: short  
カラム: originalURL＜text＞, shortURL＜text＞, count＜int＞

# .htaccess
短縮URLの書き換えを行います。