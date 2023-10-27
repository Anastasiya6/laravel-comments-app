<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\User;
use App\Models\Comment;
use App\Services\HtmlPurifierService\HtmlPurifierService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Comment::with('user','replies')->where('parent_id',0)->get();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CommentRequest $request, HtmlPurifierService $htmlPurifierService): Comment
    {
        Log::info($request);
        $user = User::firstOrCreate(
            ['email' => $request->input('email'), 'password' => 'anonymous'],
            ['name' => $request->input('name')]
        );//ser->save();
        Log::info($user);
        $filteredText = $htmlPurifierService->sanitizeComment($request->input('text'));
        $comment = new Comment([
            'homepage' => $request->input('homepage'),
            'text' => $filteredText,'parent_id' => $request->input('parent_id')
        ]);

        $user->comments()->save($comment);

        $comment->load('user','replies');

        return $comment;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
