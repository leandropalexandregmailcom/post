<?php

namespace App\Jobs;

use Exception;
use App\Dao\LikeDao;
use Illuminate\Bus\Queueable;
use PhpParser\Node\Stmt\ClassLike;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class LikeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private ClassLike $like;
    private LikeDao $likeDao;
    private string $action;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(ClassLike $like, string $action)
    {
        $this->like = $like;
        $this->action = $action;
    }

    public function handle()
    {
        if(!method_exists($this->likeDao, $this->action)) {
            throw new Exception("O método {$this->action} não existe em: {$this->likeDao}");
        }

        $this->likeDao->$this->action($this->like);
    }
}
