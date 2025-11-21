# フリマアプリ

## プロジェクトの概要
このプロジェクトは、Laravelを使用したフリマアプリです。<br />
Dockerを利用した環境構築が可能で、ユーザー登録、商品の出品・購入、お気に入り登録、
コメント機能を実装しています。


## 環境構築
Dockerビルド
  1. `git clone git@github.com:yun-0312/flea-market.git`
  2. `docker-compose up -d --build`

Laravel環境構築
  1. `docker-compose exec php bash`
  2. `composer install`
  3. 「.env.example」ファイルを 「.env」ファイルに命名を変更。または、新しく.envファイルを作成
  4. .envファイルの環境変数を以下に修正
``` text
    #　データベース設定
     DB_CONNECTION=mysql
     DB_HOST=mysql
     DB_PORT=3306
     DB_DATABASE=laravel_db
     DB_USERNAME=laravel_user
     DB_PASSWORD=laravel_pass

    # MailHog設定
      MAIL_MAILER=smtp
      MAIL_HOST=mailhog
      MAIL_PORT=1025
      MAIL_USERNAME=null
      MAIL_PASSWORD=null
      MAIL_ENCRYPTION=null
      MAIL_FROM_ADDRESS="noreply@example.com"
      MAIL_FROM_NAME="${APP_NAME}"

    #　Stripe設定
    STRIPE_PUBLIC=[pk_test_xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx] #[]に取得した公開可能キーを記載
    STRIPE_SECRET=[sk_test_xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx] #[]に取得した秘密キーを記載
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

  8.ストレージリンクを作成
``` bash
php artisan strage:link
```

## サンプルユーザーアカウント（動作確認用）
UsersTableSeedeで登録されるメール認証済みのテストユーザーです。<br />
・鈴木　一郎（商品１、３、５、７、９を出品）<br />
Email: user1@test.com<br />
Password: testtest<br />
・田中　花子（商品２、４、６、８、１０を出品）<br />
Email: user2@test.com<br />
Password: testtest<br />
・木村　次郎（出品なし）<br />
Email: user3@test.com<br />
Password: testtest<br />

## 使用技術
  <img src="https://img.shields.io/badge/-PHP-777BB4.svg?logo=php&style=plastic"> <img src="https://img.shields.io/badge/-Laravel-E74430.svg?logo=laravel&style=plastic"> <img src="https://img.shields.io/badge/-Composer-885630.svg?logo=composer&style=plastic"> <img src="https://img.shields.io/badge/-Mysql-4479A1.svg?logo=mysql&style=plastic"> <img src="https://img.shields.io/badge/-Nginx-269539.svg?logo=nginx&style=plastic"> <img src="https://img.shields.io/badge/-Docker-1488C6.svg?logo=docker&style=plastic"> <img src="https://img.shields.io/badge/-Stripe-008CDD.svg?logo=stripe&style=plastic"> <br />
  ・php 8.4.12<br />
  ・Laravel 8.83.29<br />
  ・composer 2.8.12<br />
  ・MySQL 8.0.43<br />
  ・nginx 1.21.1<br />
  ・Docker 28.4.0<br />
  ・MailHog（ローカル環境でのメール送信確認）<br />
  ・Stripe（オンライン決済機能）<br />

## テスト
このプロジェクトでは、Laravelのテスト機能を用いてユニットテストおよび機能テストを実装しています。<br />
主に以下の機能に対してテストを行っています。<br />
  1.会員登録機能<br />
  2.ログイン機能<br />
  3.ログアウト機能<br />
  4.商品一覧取得<br />
  5.マイリスト一覧取得<br />
  6.商品検索機能<br />
  7.商品詳細情報取得<br />
  8.いいね機能<br />
  9.コメント送信機能<br />
  10.商品購入機能
  11.支払い方法選択機能<br />
  12.配送先変更機能<br />
  13.ユーザー情報取得<br />
  14.ユーザー情報変更<br />
  15.出品商品情報登録<br />
  16.メール認証機能<br />

## ER図
<img width="711" height="391" alt="Image" src="https://github.com/user-attachments/assets/9ce38803-408d-45fb-a29e-8b4e4211a3dd" />

## URL
　・開発環境：http://localhost/<br />
  　・phpMyAdmin：http://localhost:8080/<br />
    ・MailHog：http://localhost:8025
