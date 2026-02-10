<?php

namespace App\Tests\Application\School;

use App\Application\School\SchoolMatcher;
use App\Domain\School\School;
use PHPUnit\Framework\TestCase;

class SchoolMatcherTest extends TestCase
{
    private SchoolMatcher $matcher;
    private array $schools;

    protected function setUp(): void
    {
        $this->matcher = new SchoolMatcher();

        $this->schools = [
            new School(
                'I Liceum Ogólnokształcące im. Adama Mickiewicza',
                ['LO Mickiewicza', 'Mickiewicz', 'I LO', 'Pierwsze LO'],
                'Warszawa',
                'liceum'
            ),
            new School(
                'XIV Liceum Ogólnokształcące im. Stanisława Staszica',
                ['Staszic', 'XIV LO', '14 LO', 'Staszica'],
                'Warszawa',
                'liceum'
            ),
        ];
    }

    public function testExactMatch(): void
    {
        /** @var School|null $result */
        $result = $this->matcher->match('Staszic', $this->schools);
        $this->assertNotNull($result);
        $this->assertSame('XIV Liceum Ogólnokształcące im. Stanisława Staszica', $result->officialName());
    }

    public function testAlternativeName(): void
    {
        /** @var School|null $result */
        $result = $this->matcher->match('14 LO', $this->schools);
        $this->assertNotNull($result);
        $this->assertSame('XIV Liceum Ogólnokształcące im. Stanisława Staszica', $result->officialName());
    }

    public function testCaseInsensitive(): void
    {
        /** @var School|null $result */
        $result = $this->matcher->match('mickiewicz', $this->schools);
        $this->assertNotNull($result);
        $this->assertSame('I Liceum Ogólnokształcące im. Adama Mickiewicza', $result->officialName());
    }

    public function testNoMatch(): void
    {
        /** @var School|null $result */
        $result = $this->matcher->match('Nieistniejąca szkoła', $this->schools);
        $this->assertNull($result);
    }
}
