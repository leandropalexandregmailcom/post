<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;

class PostController extends Controller
{

    /**
     * @OA\Get(
     *
     *      path="/post",
     *      tags={"Post"},
     *      summary="Get list of posts",
     *      description="Returns list of posts",
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
    public function index()
    {
        return response()->json(Post::with("comment")->with("like")->get());
    }

    /**
     * @OA\Post(
     *      path="/post",
     *      operationId="storePost",
     *      tags={"Post"},
     *      summary="Store new post",
     *      description="Create post",
     *      security={{"bearerAuth": {}}},
     *         @OA\Parameter(
     *          name="description",
     *          description="Post description",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *          type="object",
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
    public function store(StorePostRequest $request)
    {
        $post = Post::create([
            "description" => $request->description
        ]);

        return response()->json([
            "status"    => 200,
            "message"   => "created",
            "data"      => $post
        ]);
    }

      /**
     * @OA\Get(
     *
     *      path="/post/{id}",
     *      tags={"Post"},
     *      summary="Get post by id",
     *      description="Returns post",
     *      security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *          name="id",
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
            ->json(Post::where([
                "user_id" => auth()->user()->id,
                "id" => $request->id]));
    }

    /**
     * @OA\Put(
     *      path="/post/update",
     *      operationId="updatePost",
     *      tags={"Post"},
     *      summary="Update post",
     *      description="Update Post",
     *      security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="Post id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="description",
     *          description="Post description",
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
     *          @OA\Property(property="id", type="integer"),
     *          @OA\Property(property="description", type="string")
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
    public function update(UpdatePostRequest $request, $id)
    {
        Post::where([
            "user_id" => auth()->user()->id,
            "id"      => $request->id
            ])
            ->update([
                "description"  => $request->description,
            ]);

        return response()->json([
            "status"    => 200,
            "message"   => "updated",
        ]);
    }

    /**
     * @OA\Delete(
     *      path="/post/delete",
     *      operationId="deletePost",
     *      tags={"Post"},
     *      summary="delete post",
     *      description="Delete Post",
     *      security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *          name="id",
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
     *          @OA\Property(property="id", type="integer"),
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
        Post::where([
            'id' => $request->id,
            'user_id' => auth()->user()->id
            ])
            ->delete();

            return response()->json([
                "status"    => 200,
                "message"   => "deleted"
            ]);
    }
}
