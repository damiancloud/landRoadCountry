<?php

namespace App\Tests\Service;

use App\Service\LandRoute;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class LandRouteTest extends KernelTestCase
{
     /**
     * @return array<mixed[]>
     */
    public static function additionProvider(): array
    {
        return [
            ['POL', 'POL', ["POL"]],
            ['POL', 'CZE', ["POL","CZE"]],
            ['POL', 'CHN', ["POL","RUS", "CHN"]],
            ['POL', 'ITA', ["POL","CZE","AUT","ITA"]],
            ['POL', 'IDN', ["POL","RUS","CHN","MMR","THA","MYS","IDN"]],
            ['POL', 'CYP', false],
        ];
    }

    /**
     * @dataProvider additionProvider
     * @param array<mixed[]>|bool $result
     */
    public function testFindLandRoad(string $originCountryCode, string $destinationCountryCode, array|bool $result): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $landRoute = $container->get(LandRoute::class);

        $route = $landRoute->find($originCountryCode, $destinationCountryCode);
        $this->assertEquals($result, $route);
    }
}
