<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Comment;
use App\Models\Article;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $articleId)
    {
        $article = Article::findOrFail($articleId);
        $comments = $article->comments()->get();

        return response()->json([
            'comments' => $comments,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $articleId)
    {
        $article = Article::findOrFail($articleId);
        $validated = $request->validate($this->validationRule());

        $comment = $article->comments()->create([
            'body' => $validated['body'],
            'user_id' => $request->user()->id,
        ]);

        return response()->json([
            'message' => 'Created successfully',
            'comment' => $comment,
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $articleId, string $id)
    {
        $comment = Comment::findOrFail($id);
        
        if(!$this->isAuthorized($request->user(), $comment)) {
            return response()->json(['message' => 'Forbidden'], 403);
        }
        
        $validated = $request->validate($this->validationRule());
        $comment->update($validated);

        return response()->json([
            'message' => 'Updated successfully',
            'comment' => $comment,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $articleId, string $id)
    {
        $comment = Comment::findOrFail($id);

        if(!$this->isAuthorized($request->user(), $comment)) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $comment->delete();

        return response()->json([], 204);
    }

    private function validationRule(): array
    {
        return [
            'body' => 'required|max:255',
        ];
    }

    private function isAuthorized($user, Comment $comment) {
        return $user && $user->id === $comment->user_id;
    }
}
