<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LandRouteTest extends WebTestCase
{
    /**
     * @return array<mixed[]>
     */
    public static function additionProviderSuccessful(): array
    {
        return [
            ['POL/POL', '{"route":["POL"]}'],
            ['POL/CZE', '{"route":["POL","CZE"]}'],
            ['POL/CHN', '{"route":["POL","RUS","CHN"]}'],
            ['POL/ITA', '{"route":["POL","CZE","AUT","ITA"]}'],
            ['POL/IDN', '{"route":["POL","RUS","CHN","MMR","THA","MYS","IDN"]}'],
        ];
    }

    /**
     * @return array<mixed[]>
     */
    public static function additionProviderBadRequest(): array
    {
        return [
            ['POL/CYP'],
        ];
    }

    /**
     * @dataProvider additionProviderSuccessful
     */
    public function testFindLandRoadSuccessful(string $pathParameter, string $result): void
    {
        $client = static::createClient([], ['base_uri' => 'http://127.0.0.1:8000']);
        $crawler = $client->request('GET', '/routing/' . $pathParameter);
        $content = $client->getResponse()->getContent();
        $this->assertResponseIsSuccessful();
        $this->assertEquals($content, $result);
    }

    /**
     * @dataProvider additionProviderBadRequest
     */
    public function testFindLandRoadBadRequest(string $pathParameter): void
    {
        $client = static::createClient([], ['base_uri' => 'http://127.0.0.1:8000']);
        $crawler = $client->request('GET', '/routing/' . $pathParameter);
        $this->assertResponseStatusCodeSame(400);
    }
}
