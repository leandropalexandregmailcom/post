<?php

namespace App\Http\Controllers\Api;

use App\Models\Like;
use App\Models\Post;
use App\Models\Comment;
use App\Jobs\CommentJob;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{

    public function index()
    {
        return response()->json(Comment::where(["user_id" => auth()->user()->id])->get());
    }

    /**
     * @OA\Post(
     *      path="/comment",
     *      operationId="storeComment",
     *      tags={"Comment"},
     *      summary="Store new Comment",
     *      description="Create Comment",
     *      security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *          name="post_id",
     *          description="Post id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *         @OA\Parameter(
     *          name="description",
     *          description="Comment",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="post_id", type="int"),
     *          @OA\Property(property="description", type="string")
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function store(StoreCommentRequest $request)
    {
        $comment = CommentJob::dispatch($request->description,
            intval($request->post_id),
            intval(auth()->user()->id),
            'create'
        );

        return response()->json([
            "status"    => 200,
            "message"   => "created",
            "data"      => $comment
        ]);
    }

      /**
     * @OA\Get(
     *
     *      path="/comment/id",
     *      tags={"Comment"},
     *      summary="Get comment by id",
     *      description="Returns comment",
     *      security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="comment id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="post_id",
     *          description="Post id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */
    public function show(Request $request)
    {
        return response()
            ->json(Comment::where([
                    'user_id' => auth()->user()->id,
                    'post_id' => $request->post_id,
                    'id'      => $request->id])
            ->first());
    }

    /**
     * @OA\Put(
     *      path="/comment/update",
     *      operationId="updateComment",
     *      tags={"Comment"},
     *      summary="Update comment",
     *      description="Update comment",
     *      security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="Comment id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="description",
     *          description="description",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="post_id",
     *          description="Post id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="post_id", type="int"),
     *          @OA\Property(property="description", type="string")
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function update(UpdateCommentRequest $request)
    {
        CommentJob::dispatch(
            $request->description,
            intval($request->post_id),
            intval(auth()->user()->id),
            'update'
        );

        return response()->json([
            "status"    => 200,
            "message"   => "updated",
        ]);
    }

    /**
     * @OA\Delete(
     *      path="/comment/delete",
     *      operationId="deleteComment",
     *      tags={"Comment"},
     *      summary="Delete comment",
     *      description="Delete comment",
     *      security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="Comment id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="post_id",
     *          description="Post id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function destroy(Request $request)
    {
        Comment::where([
            'user_id' => auth()->user()->id,
            'post_id' => $request->post_id,
            'id' => $request->id])
            ->delete();

            return response()->json([
                "status"    => 200,
                "message"   => "deleted"
            ]);
    }
}
