<?php

namespace App\Http\Controllers\Api;

use App\Models\Like;
use App\Models\Post;
use App\Jobs\LikeJob;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLikeRequest;
use App\Http\Requests\UpdateLikeRequest;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function index()
    {
        return response()->json(Like::where(["user_id" => auth()->user()->id])->get());
    }

    /**
     * @OA\Post(
     *      path="/like",
     *      operationId="storeLike",
     *      tags={"Like"},
     *      summary="Store new Like",
     *      description="Create Like",
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
     *          name="like",
     *          description="like or unlike",
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
     *          @OA\Property(property="like", type="string")
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
    public function store(StoreLikeRequest $request)
    {
        $like = LikeJob::dispatch(
            $request->like,
            intval($request->post_id),
            intval(auth()->user()->id),
            'create'
        );

        return response()->json([
            "status"    => 200,
            "message"   => "created",
            "data"      => $like
        ]);
    }


      /**
     * @OA\Get(
     *
     *      path="/like/id",
     *      tags={"Like"},
     *      summary="Get like by id",
     *      description="Returns like",
     *      security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="like id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="post_id",
     *          description="post id",
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
            ->json(Like::where([
                "user_id" => auth()->user()->id,
                "post_id" => $request->post_id,
                "id" => $request->id])->first());
    }

    /**
     * @OA\Put(
     *      path="/like/update",
     *      operationId="updateLike",
     *      tags={"Like"},
     *      summary="Update like",
     *      description="Update like",
     *      security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="Like id",
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
     *      @OA\Parameter(
     *          name="like",
     *          description="like or unlike",
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
     *          @OA\Property(property="like", type="string")
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
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
    public function update(UpdateLikeRequest $request)
    {
        LikeJob::dispatch(
            $request->like,
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
     *      path="/like/delete",
     *      operationId="deleteLike",
     *      tags={"Like"},
     *      summary="delete like",
     *      description="Delete like",
     *      security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="Like id",
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
     *      @OA\RequestBody(
     *          required=true,
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
        Like::where([
            'id' => $request->id,
            'user_id' => auth()->user()->id,
            'post_id' => $request->post_id])
            ->delete();

            return response()->json([
                "status"    => 200,
                "message"   => "deleted"
            ]);
    }
}
