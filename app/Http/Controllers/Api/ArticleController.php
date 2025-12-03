<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Article;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::all();

        return response()->json([
            'articles' => $articles,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate($this->validationRules());

        // 現在認証されているユーザーの記事として作成
        $article = $request->user()->articles()->create($validated);

        return response()->json([
            'message' => 'Created successfully',
            'article' => $article,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // findOrFail()を使用すると、見つからない場合に自動的に404を返す
        $article = Article::findOrFail($id);

        return response()->json([
            'article' => $article,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $article = Article::findOrFail($id);

        // 権限チェック: 記事の所有者のみが更新可能
        if (!$this->isAuthorized($request->user(), $article)) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $validated = $request->validate($this->validationRules());
        $article->update($validated);

        return response()->json([
            'message' => 'Updated successfully',
            'article' => $article
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $article = Article::findOrFail($id);

        // 権限チェック: 記事の所有者のみが削除可能
        if (!$this->isAuthorized($request->user(), $article)) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $article->delete();

        return response()->json([], 204);
    }

    /**
     * 現在のユーザーが記事の所有者かどうかをチェック
     */
    private function isAuthorized($user, Article $article): bool
    {
        return $user && $user->id === $article->user_id;
    }

    /**
     * バリデーションルールを返す
     */
    private function validationRules(): array
    {
        return [
            'title' => 'required|max:255',
            'content' => 'required',
        ];
    }
}
