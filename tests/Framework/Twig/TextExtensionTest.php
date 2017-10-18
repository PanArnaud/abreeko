<?php
namespace Tests\Framework\Twig;

use PHPUnit\Framework\TestCase;
use Framework\Twig\TextExtension;

class TextExtensionTest extends TestCase
{
    
    private $textExtension;

    public function setUp() 
    {
        $this->textExtension = new TextExtension();
    }

    public function testExcerptWithShortText() 
    {
        $text = "Salut";
        $this->assertEquals($text, $this->textExtension->excerpt($text, 10));
    }

    public function testExcerptWithLongText() 
    {
        $text = "Salut les gens";
        $this->assertEquals("Salut...", $this->textExtension->excerpt($text, 7));
        $this->assertEquals("Salut les...", $this->textExtension->excerpt($text, 12));
    }
}
