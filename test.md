# Swagger テスト仕様書

Swagger UI (http://localhost:8002) を使用し、API が仕様通りに動作することを確認する。認証が必要なケースは `Authorization: Bearer {token}` を事前に設定する。DB 初期化やシードが必要なら `./sail artisan migrate:fresh --seed` を実行してからテストする。

| No | 大項目 | 中項目 | 具体例 | データパターン | 期待結果 |
| --- | --- | --- | --- | --- | --- |
| 1 | 認証 | 登録成功 | `POST /api/register` | `{ "name":"Test User","email":"unique@example.com","password":"password","password_confirmation":"password" }` | 201 作成、ユーザーとトークン返却 |
| 2 | 認証 | 登録バリデーション | `POST /api/register` | メール形式不正、パスワード未入力 | 422、フィールドごとにエラーメッセージ |
| 3 | 認証 | ログイン成功 | `POST /api/login` | `{ "email":"unique@example.com","password":"password" }` | 200、トークンとユーザー情報返却 |
| 4 | 認証 | ログイン失敗 | `POST /api/login` | 誤パスワード | 401、エラーメッセージ、トークン無し |
| 5 | 認証 | ログアウト | `DELETE /api/logout` | トークン設定済み | 204/200、トークン失効、以降保護ルートは 401 |
| 6 | Articles | 一覧取得 | `GET /api/articles` | - | 200、記事配列 (必要ならページネーション確認) |
| 7 | Articles | 詳細取得 | `GET /api/articles/{id}` | 存在 ID / 不在 ID | 存在:200 で記事返却、不在:404 |
| 8 | Articles | 作成成功 | `POST /api/articles` | `{ "title":"Swagger Test Article","content":"Article body text" }` + トークン | 201、作成記事返却、user_id がログインユーザー |
| 9 | Articles | 作成バリデーション | `POST /api/articles` | タイトル空、content 空 | 422、エラーメッセージ |
| 10 | Articles | 更新成功 | `PUT /api/articles/{id}` | 自記事に対し `{ "title":"Updated Title","content":"Updated body" }` | 200、更新後記事返却 |
| 11 | Articles | 更新権限エラー | `PUT /api/articles/{id}` | 他人記事に対し更新 | 403 Forbidden |
| 12 | Articles | 削除成功 | `DELETE /api/articles/{id}` | 自記事 | 204/200、記事削除 |
| 13 | Articles | 削除権限/存在確認 | `DELETE /api/articles/{id}` | 他人記事 / 不在 ID | 他人:403、不在:404 |
| 14 | Comments | 一覧取得 | `GET /api/articles/{article}/comments` | 存在記事 / 不在記事 | 存在:200 でコメント配列、不在:404 |
| 15 | Comments | 作成成功 | `POST /api/articles/{article}/comments` | `{ "body":"First comment" }` + トークン | 201、コメント返却、user_id がログインユーザー |
| 16 | Comments | 作成バリデーション | `POST /api/articles/{article}/comments` | body 空 | 422、エラーメッセージ (記事不在は 404) |
| 17 | Comments | 更新成功 | `PUT /api/articles/{article}/comments/{id}` | 自コメント `{ "body":"Updated comment" }` | 200、更新後コメント返却 |
| 18 | Comments | 更新権限/存在確認 | `PUT /api/articles/{article}/comments/{id}` | 他人コメント / 不在 ID | 他人:403、不在:404 |
| 19 | Comments | 削除成功 | `DELETE /api/articles/{article}/comments/{id}` | 自コメント | 204/200、コメント削除 |
| 20 | Comments | 削除権限/存在確認 | `DELETE /api/articles/{article}/comments/{id}` | 他人コメント / 不在 ID | 他人:403、不在:404 |
| 21 | セキュリティ | 未認証アクセス拒否 | `POST /api/articles` など | トークン無し | 401、トークン要求エラー |
| 22 | セキュリティ | トークン失効確認 | ログアウト後に保護ルート呼び出し | 失効済みトークン | 401 |
| 23 | セキュリティ | 不正 ID 参照 | `GET /api/articles/{id}` 等 | 存在しない ID | 404、サーバーエラーにならない |

補足:
- Swagger の Try it out 実行前に Body が JSON 形式になっているか確認する。
- 422 時はレスポンスのフィールド名とバリデーションルールの整合性を確認する。
- トークンを切り替える場合は Swagger の「Authorize」で Revoke したうえで再設定する。
