# CLAUDE.md

このファイルは、このリポジトリでコードを扱う際のClaude Code (claude.ai/code) へのガイダンスを提供します。

## 言語設定

**このリポジトリで作業する際は、必ず日本語で返答してください。**

## プロジェクト概要

これはモダンなPHPバックエンド開発を学習するための **Laravel 11** REST APIバックエンドチュートリアルプロジェクト(Partsone バックエンド研修課題)です。このアプリケーションは、Users、Articles、Commentsを含むブログプラットフォームを実装しています。

**技術スタック:**
- PHP 8.2+ with Laravel 11.9
- MySQL 8.0 (via Docker)
- Laravel Sail (Docker開発環境)
- Vite 5.0 + Tailwind CSS 3.4
- Laravel Sanctum (API認証)
- OpenAPI 3.1.0 (APIドキュメント)

## 開発コマンド

**セットアップ:**
```bash
# 初期セットアップ
bash setup.sh

# または手動で:
cp .env.example .env
docker run --rm -v $(pwd):/opt -w /opt laravelsail/php83-composer:latest bash -c "composer install"
ln -s ./vendor/bin/sail ./sail
./sail up -d --build
./sail artisan key:generate
./sail artisan migrate
```

**開発モード:**
```bash
# すべてのサービスを同時実行 (Laravel server, queue, logs, Vite)
composer run dev

# または個別のサービス:
./sail artisan serve              # Laravel開発サーバー
./sail npm run dev                # Vite開発サーバー (HMR)
./sail artisan queue:listen       # バックグラウンドジョブ処理
./sail artisan pail --timeout=0   # リアルタイムログストリーミング
```

**データベース操作:**
```bash
./sail artisan migrate              # 未実行のマイグレーションを実行
./sail artisan migrate:fresh        # データベースをリセットして全マイグレーションを再実行
./sail artisan db:seed             # データベースシーダーを実行
./sail artisan tinker              # モデルがロードされた対話型PHPシェル
```

**テスト:**
```bash
./sail artisan test                     # 全テストを実行
./sail artisan test tests/Unit          # ユニットテストのみ実行
./sail artisan test tests/Feature       # フィーチャーテストのみ実行
./sail artisan test --filter=TestName   # 特定のテストを実行
```

**コードフォーマット:**
```bash
./sail composer run pint    # Laravel PintでPHPコードをフォーマット
./sail npm run build        # 本番用アセットをビルド
```

**Artisanジェネレーター:**
```bash
./sail artisan make:model ModelName           # モデルを作成
./sail artisan make:migration create_table    # マイグレーションを作成
./sail artisan make:controller NameController # コントローラーを作成
./sail artisan make:seeder NameSeeder        # シーダーを作成
./sail artisan make:factory NameFactory      # ファクトリーを作成
./sail artisan make:test NameTest            # テストを作成
```

**Docker操作:**
```bash
./sail up        # 全コンテナを起動
./sail down      # 全コンテナを停止
./sail shell     # アプリコンテナのシェルにアクセス
./sail mysql     # MySQL CLIにアクセス
```

## アーキテクチャ

### データベーススキーマ

**主要テーブル:**
- `users` (id, name, email, password) - 認証とユーザープロフィール
- `articles` (id, user_id FK, title, content) - ブログ記事
- `comments` (id, user_id FK, article_id FK, body) - 記事へのコメント

**リレーション:**
- User → Articles (1対多)
- User → Comments (1対多)
- Article → Comments (1対多)

**重要な注意事項:**
- articlesの`content`フィールドは`string()`ではなく`text()`または`longText()`を使用すること
- commentsの`body`フィールドは`string()`ではなく`text()`を使用すること
- すべてのモデルはモデルファイル内でEloquentリレーションを定義すること
- 一括代入保護のため`$fillable`または`$guarded`を使用すること

### API構造

**ベースURL:** `http://localhost/api`

**認証** (routes/api.php):
- `POST /api/register` - ユーザー登録
- `POST /api/login` - ログイン (Sanctumトークンを返却)
- `DELETE /api/logout` - ログアウト (認証必須)

**Articles** (作成・更新・削除には認証が必要):
- `GET /api/articles` - 全記事を取得
- `POST /api/articles` - 記事を作成
- `GET /api/articles/{id}` - 単一記事を取得
- `PUT /api/articles/{id}` - 記事を更新
- `DELETE /api/articles/{id}` - 記事を削除

**Comments** (作成・更新・削除には認証が必要):
- `GET /api/articles/{article}/comments` - 記事のコメント一覧を取得
- `POST /api/articles/{article}/comments` - コメントを作成
- `PUT /api/articles/{article}/comments/{id}` - コメントを更新
- `DELETE /api/articles/{article}/comments/{id}` - コメントを削除

**認証:**
- Laravel Sanctumを使用したトークンベースAPI認証
- 保護されたルートには`Authorization: Bearer {token}`ヘッダーが必要
- トークンは`/api/login`レスポンスから取得

### Laravelの規約

**モデルリレーション:**
```php
// Article.php内
public function user() {
    return $this->belongsTo(User::class);
}

public function comments() {
    return $this->hasMany(Comment::class);
}
```

**コントローラーパターン:**
- リソースコントローラーを使用 (index, show, store, update, destroy)
- 適切なHTTPステータスコードでJSONレスポンスを返却
- 入力検証には`request()->validate()`を使用
- 自動モデル注入にはルートモデルバインディングを使用

**マイグレーションパターン:**
- 外部キーには`foreignId()->constrained()`を使用
- created_at/updated_atのため常に`timestamps()`を含める
- `down()`メソッドで逆操作を定義

## 開発ワークフロー

1. 新しいテーブル/カラムのマイグレーションを作成
2. `./sail artisan migrate`でマイグレーションを実行
3. リレーションとfillableフィールドを持つEloquentモデルを作成/更新
4. リソースメソッドを持つコントローラーを作成
5. `routes/api.php`でルートを定義
6. フィーチャーテストを作成
7. `composer run pint`でコードをフォーマット

## アクセスポイント

- **アプリケーション:** http://localhost
- **API:** http://localhost/api
- **Swagger UI:** http://localhost:8002 (APIドキュメント)
- **ReDoc:** http://localhost:8003 (代替APIドキュメント)
- **Mailpit:** http://localhost:8025 (メールテストUI)

## 環境設定

主要な`.env`変数:
- `DB_HOST=mysql` (Dockerサービス名、localhostではない)
- `DB_USERNAME=sail`, `DB_PASSWORD=password`
- `QUEUE_CONNECTION=database` (ジョブはデータベースに保存)
- `SESSION_DRIVER=database` (セッションはデータベースに保存)
- `MAIL_MAILER=smtp`, `MAIL_HOST=mailpit` (ローカルメールテスト)
- `OPENAPI_FILE_NAME=template.yml` (提供するAPI仕様ファイル)

## ドキュメント

`docs/`に日本語ドキュメントがあります:
- `docs/研修ER図.drawio.pdf` - エンティティ関係図
- `docs/研修テーブル定義書.xlsx` - テーブル定義書
- `docs/API設計書.xlsx` - API設計仕様書
- `docs/api/template.yml` - OpenAPI 3.1.0仕様書
