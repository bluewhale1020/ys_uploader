# ys_uploader
cakePHP3・AdminLTE Themeで作成した簡易アップローダー

## システム概要 ##
シンプルな機能のアップローダーで、認証機能がついています。これ自体がシステムとして単純ですが完成されていますので、
設定等最低限必要な処理をした後、直ぐに運用開始できます。
[CakePHP3](https://cakephp.org/)をフレームワークとして利用していますので、足りない機能等を後から追加するのも容易です。
UIのテーマとして[AdminLTE Theme](https://github.com/maiconpinto/cakephp-adminlte-theme)を使用していますので、
UI変更の際はそちらのドキュメントをご参照ください。

## インストール ##
ys_uploaderのプロジェクトをダウンロード／クローンして中身のフォルダ名を`ys_uploader`に変更し、
WWWサーバーのhtdocs(或いはサイトで公開するコンテンツの置き場所)に移動します。

**htdocs内のフォルダ構造**
```
root/ys_uploader
　├ bin/
　├ config/
　├ logs/
　├ plugins/
　├ src/
　├ tests/
　├ tmp/ 
　├ webroot/  
　└ その他のファイル
```
## サーバーの設定 ##
### cakePHP3に必要 ###

**php**
```
5.6.0 以上
```

**extension**
```
mbstring 
intl 
simplexml 
```

### imagickのインストール ###
サーバーに`imagick`をインストールして下さい。既にインストールされているかは、`phpinfo()`で確認できます。


**WindowsOSの注意点**
```
WindowsOS上のサーバーにimagickをインストールするのは、かなり複雑な手続きが必要です。`phpinfo()`でphpの
仕様を十分確認の上、下記のURLを参考にインストールして下さい。
```


**参考URL**
```uri
https://bonz-net.com/setting/windows%E7%89%88xampp%EF%BC%88php7-2-x%EF%BC%89%E3%81%ABimagemagick%E3%82%92%E3%82%A4%E3%83%B3%E3%82%B9%E3%83%88%E3%83%BC%E3%83%AB%E3%81%99%E3%82%8B%E6%96%B9%E6%B3%95/
```
phpの構成とダウンロードファイルの組み合わせは以下を参考
```uri
https://mlocati.github.io/articles/php-windows-imagick.html
```


## データベース設定 ##
フォルダ内の`uploaddb.sql`はシステムが利用するDBのテーブルを作成するSQLファイルです。データベースを作成後、
ファイルをインポートして下さい。

## システムの設定 ##

`config/app.default.php`をコピーして`app.php`を作成し、以下の内容を環境に合わせて設定します。

**データベースの接続**
```php
    'Datasources' => [
        'default' => [
            'host' => 'localhost',
            'username' => 'my_app',
            'password' => 'secret',
            'database' => 'my_app',
            //'encoding' => 'utf8mb4',
            'timezone' => 'UTC',
        ],
```

## 登録済のユーザーログイン情報 ##

**管理者(admin)**
```
username:admin
password:admin
```

**ゲスト(guest)**
```
username:guest
password:guest
```

## システム利用方法 ##

### 権限による利用制限 ###
**admin**
```
全ての機能を利用できます。
パスありファイルをパス入力無しでダウンロード・削除可能
```

**user**
```
アップロード機能の利用と自分のユーザー情報編集のみ可能です。
```


### ログイン方法 ###

ブラウザで以下のURLにアクセスします。
```uri
サーバーのURL/ys_uploader/users/login
```
ログイン後、アップロードファイル一覧画面に移動します。


### システム上の機能 ###

**アップロード機能**
* **ファイルをアップロード** ファイルをアップロードし、パスワードを設定できます（任意）。
* **アップロードファイルの分類**　カテゴリごとにファイルを分類して一覧表示します。
* **ダウンロード** ファイルをダウンロードします。パスワード設定のあるものは、パスワードの入力を要求します。
* **ファイルの削除** ファイルを削除します。パスワード設定のあるものは、パスワードの入力を要求します。
* **アップロードファイルの制限** アップロードのファイルは登録されたファイル種類(MimeType)のもののみ受け付けます。`MimeType管理`を参照。

**カテゴリ管理**
* ファイルを分類するカテゴリの新規作成・更新・削除機能を提供

**ユーザー管理**
* ユーザーの新規作成・更新・削除機能を提供

**MimeType管理**
* 受け付けるファイルの種類を管理します。
* MimeTypeには、それだけでは拡張子が特定できないものがあります。その場合、登録の際に拡張子欄を`空欄`にし、拡張子が`非特定`と設定します。

**debugページ**
* 基本的に、cakePHPの`home.ctp`の内容が表示されます。` src/Template/Pages/home.ctp`ファイルを差し替えれば内容を変更できます。










































