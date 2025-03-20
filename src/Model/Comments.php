<?php

namespace Contatoseguro\TesteBackend\Model;

class Comments
{
    public $category;

    public function __construct(
        public int $id,
        public int $product_id,
        public int $admin_user_id,
        public string $comment_text,

    ) {
    }

    public static function hydrateByFetch($fetch): self
    {

        return new self(
            (int) $fetch["id"],
            (int) $fetch["product_id"],
            (string) $fetch["admin_user_id"],
            (string) $fetch["comment_text"],
        );
    }

    public function setParentid($parent_id)
    {
        $this->parent_id = $parent_id;
    }
}
