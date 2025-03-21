<?php

namespace ContatoSeguro\Tests\Unit\Model;

use PHPUnit\Framework\TestCase;
use Contatoseguro\TesteBackend\Model\Category;

class CategoryTest extends TestCase
{

    public function testHydrateByFetch(): void
    {
        $fetch = [
            'id' => 1,
            'company_id' => 2,
            'title' => 'Test category',
            'active' => true,
        ];

        $category = Category::hydrateByFetch($fetch);

        $this->assertEquals(1, $category->id);
        $this->assertEquals(2, $category->companyId);
        $this->assertEquals('Test category', $category->title);
        $this->assertTrue($category->active);
    }
    public function testSetCategory(): void
    {
        $category = new Category(1, 2, 'Test Category', true);
        $this->assertEquals('Test Category', $category->title);
        $this->assertEquals(1, $category->id);
        $this->assertEquals(2, $category->companyId);
        $this->assertTrue($category->active);
    }
}
