# お問い合わせフォーム


## 環境構築
Dockerビルド
  1. `git clone github.com:yun-0312/flea-market.git`
  2. `docker-compose up -d --build`

Laravel環境構築
  1. `docker-compose exec php bash`
  2. `composer install`
  3. 「.env.example」ファイルを 「.env」ファイルに命名を変更。または、新しく.envファイルを作成、環境変数を変更
  4. 環境変数を以下に修正
``` text
     DB_CONNECTION=mysql<br />
     DB_HOST=mysql<br />
     DB_PORT=3306<br />
     DB_DATABASE=laravel_db<br />
     DB_USERNAME=laravel_user<br />
     DB_PASSWORD=laravel_pass<br />
```
  5.アプリケーションキーの作成
``` bash
php artisan key:generate
```
  6.マイグレーションの実行
``` bash
php artisan migrate
```
  7.シーディングの実行
``` bash
php artisan db:seed
```

## 使用技術
  <img src="https://img.shields.io/badge/-PHP-777BB4.svg?logo=php&style=plastic"> <img src="https://img.shields.io/badge/-Laravel-E74430.svg?logo=laravel&style=plastic"> <img src="https://img.shields.io/badge/-Composer-885630.svg?logo=composer&style=plastic"> <img src="https://img.shields.io/badge/-Mysql-4479A1.svg?logo=mysql&style=plastic"> <img src="https://img.shields.io/badge/-Nginx-269539.svg?logo=nginx&style=plastic"> <img src="https://img.shields.io/badge/-Docker-1488C6.svg?logo=docker&style=plastic"><br />
  ・php 8.4.12<br />
  ・Laravel 8.83.29<br />
  ・composer 2.8.12<br />
  ・MySQL 8.0.43<br />
  ・nginx 1.21.1<br />
  ・Docker 28.4.0<br />

## ER図
<img width="711" height="391" alt="Image" src="https://github.com/user-attachments/assets/9ce38803-408d-45fb-a29e-8b4e4211a3dd" />

## URL
　・開発環境：http://localhost/<br />
  　・phpMyAdmin：http://localhost:8080/
