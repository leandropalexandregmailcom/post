<?php

namespace App\Jobs;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CommentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $description;
    private int $post_id;
    private int $user_id;
    private string $action;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $description, int $post_id, int $user_id, string $action)
    {
        $this->description = $description;
        $this->post_id = $post_id;
        $this->user_id = $user_id;
        $this->action = $action;
    }

    public function handle()
    {
        return $this->action == "create" ? $this->create() : $this->update();
    }

    private function create() {
        $comment = Comment::create([
            "description"  => $this->description,
            "post_id"      => $this->post_id,
            "user_id"      => $this->user_id
        ]);

        return $comment;
    }

    private function update() {
        $comment = Comment::where(['id' => $this->id, 'post_id' => $this->post_id, 'user_id' => $this->user_id])->update([
            'description' => $this->description
        ]);

        return $comment;
    }
}
