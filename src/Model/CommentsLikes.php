<?php

namespace Contatoseguro\TesteBackend\Model;

class CommentsLikes
{
    public $category;

    public function __construct(
        public int $id,
        public int $comment_id,
        public int $admin_user_id,
        public string $created_at,

    ) {
    }

    public static function hydrateByFetch($fetch): self
    {

        return new self(
            (int) $fetch["id"],
            (int) $fetch["comment_id"],
            (string) $fetch["admin_user_id"],
            (string) $fetch["created_at"],
        );
    }

}
