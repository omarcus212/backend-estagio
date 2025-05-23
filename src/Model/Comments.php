<?php

namespace Contatoseguro\TesteBackend\Model;

class Comments
{
    public $comments;

    public function __construct(
        public int $id,
        public int $product_id,
        public int $parent_id,
        public int $admin_user_id,
        public string $comment_text,
        public string $created_at,
        public string $updated_at,

    ) {
    }

    public static function hydrateByFetch($fetch): self
    {

        return new self(
            (int) $fetch["id"],
            (int) $fetch["product_id"],
            (int) $fetch["parent_id"],
            (string) $fetch["admin_user_id"],
            (string) $fetch["comment_text"],
            (string) $fetch["created_at"],
            (string) $fetch["updated_at"],
        );
    }

    public function setParentid($parent_id)
    {
        $this->parent_id = $parent_id;
    }
}
