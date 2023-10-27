<?php

namespace App\Services\Comment;

use App\Models\Comment;
use App\Models\User;
use App\Services\HtmlPurifier\HtmlPurifierService;
use HTMLPurifier;
use HTMLPurifier_Config;
use Illuminate\Http\Request;

class CommentService
{
    /**
     * Store a new comment.
     *
     * @param  Request $request
     * @param  HtmlPurifierService $htmlPurifierService
     * @return Comment
     */
    public function store(Request $request, HtmlPurifierService $htmlPurifierService): Comment
    {
        $user = User::firstOrCreate(
            ['email' => $request->input('email'), 'password' => 'anonymous'],
            ['name' => $request->input('name')]
        );

        $filteredText = $htmlPurifierService->sanitizeComment($request->input('text'));

        $comment = new Comment([
            'homepage' => $request->input('homepage'),
            'text' => $filteredText,'parent_id' => $request->input('parent_id')
        ]);

        $user->comments()->save($comment);

        $comment->load('user','replies');

        return $comment;
    }
}
