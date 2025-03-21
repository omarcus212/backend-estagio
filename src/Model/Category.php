<?php

namespace Contatoseguro\TesteBackend\Model;

class Category
{

    public $category;

    public function __construct(
        public int $id,
        public int $companyId,
        public string $title,
        public bool $active,

    ) {
    }

    public static function hydrateByFetch($fetch): self
    {

        return new self(
            (int) $fetch["id"],
            (int) $fetch["company_id"],
            (string) $fetch["title"],
            (bool) $fetch["active"],
        );
    }

}
