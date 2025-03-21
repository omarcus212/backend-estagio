<?php

namespace ContatoSeguro\Tests\Unit\Model;

use PHPUnit\Framework\TestCase;
use Contatoseguro\TesteBackend\Model\CommentsLikes;

class CommentsLikesTest extends TestCase
{

    public function testHydrateByFetch(): void
    {
        $fetch = [
            'id' => 1,
            'comment_id' => 1,
            'admin_user_id' => 4,
            'created_at' => '2025-01-01',
        ];

        $commentsLike = CommentsLikes::hydrateByFetch($fetch);

        $this->assertEquals(1, $commentsLike->id);
        $this->assertEquals(4, $commentsLike->admin_user_id);
        $this->assertEquals('2025-01-01', $commentsLike->created_at);
    }
    public function testSetcommentsLike(): void
    {
        $commentsLike = new CommentsLikes(1, 2, 4, '2025-01-01');
        $this->assertEquals(1, $commentsLike->id);
        $this->assertEquals(4, $commentsLike->admin_user_id);
        $this->assertEquals('2025-01-01', $commentsLike->created_at);
    }
}
