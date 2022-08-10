<?php

namespace App\Jobs;

use Exception;
use App\Dao\CommentDao;
use App\Models\Comment;
use Illuminate\Bus\Queueable;
use App\Classe\Comment as ClassComment;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CommentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private ClassComment $comment;
    private CommentDao $commentDao;
    private string $action;
    /**
     * Create a new job instance.
     *
     * @return void
     */

    public function __construct(ClassComment $comment, string $action)
    {
        $this->comment = $comment;
        $this->action = $action;
    }

    public function handle()
    {
        $commentDao = new CommentDao;
        if(!method_exists($commentDao, $this->action)) {
            throw new Exception("O método {$this->action} não existe em: {$commentDao}");
        }
        return $commentDao->{$this->action}($this->comment);
    }
}
