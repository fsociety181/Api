<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResouce extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'text' => $this->text,
            'image' => $this->getArticleImage(),
            'comment' => CommentResource::collection($this->comments),
            'like' => LikeResource::collection($this->like),
            'countLike' => $this->like()->count(),
        ];
    }
}
