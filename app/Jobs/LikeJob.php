<?php

namespace App\Jobs;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class LikeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private int $id;
    private string $like;
    private int $post_id;
    private int $user_id;
    private string $action;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $like, int $post_id, int $user_id, string $action)
    {
        $this->like = $like;
        $this->post_id = $post_id;
        $this->user_id = $user_id;
        $this->action = $action;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        return $this->action == "create" ? $this->create() : $this->update();
    }

    private function create() {
        $like = Like::create([
            "like"         => $this->like,
            "post_id"      => $this->post_id,
            "user_id"      => $this->user_id
        ]);

        return $like;
    }

    private function update() {
        $like = Like::where(['id' => $this->id, 'post_id' => $this->post_id, 'user_id' => $this->user_id])->update([
            'like' => $this->like
        ]);

        return $like;
    }
}
