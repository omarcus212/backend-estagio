<?php

namespace ContatoSeguro\Tests\Unit\Model;

use PHPUnit\Framework\TestCase;
use Contatoseguro\TesteBackend\Model\Comments;

class CommentsTest extends TestCase
{

    public function testHydrateByFetch(): void
    {
        $fetch = [
            'id' => 1,
            "product_id" => 2,
            "parent_id" => 1,
            "admin_user_id" => 1,
            "comment_text" => "Test comments",
            "created_at" => "2025-01-01 00:00:00",
            "updated_at" => "2025-01-01 00:00:00",
        ];

        $comments = Comments::hydrateByFetch($fetch);

        $this->assertEquals(1, $comments->id);
        $this->assertEquals(2, $comments->product_id);
        $this->assertEquals(1, $comments->admin_user_id);
        $this->assertEquals('Test comments', $comments->comment_text);

    }
    public function testSetcomments(): void
    {
        $comments = new Comments(1, 2, 4, 1, 'Test comments', '2025-01-01', '2025-01-01');
        $comments->setParentid(4);

        $this->assertEquals(1, $comments->id);
        $this->assertEquals(2, $comments->product_id);
        $this->assertEquals(1, $comments->admin_user_id);
        $this->assertEquals('Test comments', $comments->comment_text);
        $this->assertEquals('2025-01-01', $comments->created_at);
        $this->assertEquals('2025-01-01', $comments->updated_at);


    }
}
