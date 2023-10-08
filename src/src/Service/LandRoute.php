<?php

namespace App\Service;

use Psr\Cache\CacheItemInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class LandRoute
{
    /**
     * @param HttpClientInterface $httpClient An instance of HttpClientInterface.
     * @param CacheInterface $cache An instance of CacheInterface.
     * @param string $apiCountriesUrl The URL for the API endpoint for countries.
     */
    public function __construct(
        private HttpClientInterface $httpClient,
        private CacheInterface $cache,
        #[Autowire('%app.api_countries%')]
        private string $apiCountriesUrl
    ) {}
    
    /**
     * Find the shortest path between two countries using BFS algorithm.
     * @param string $originCountryCode The country code of the origin.
     * @param string $destinationCountryCode The country code of the destination.
     *
     * @return array<mixed[]>|bool
     */
    public function find(string $originCountryCode, string $destinationCountryCode): array|bool
    {
        $countriesData = $this->getCountriesData();

        $queue = [];
        array_push($queue, [$originCountryCode]);
    
        // Keep track of visited countries
        $visited = [];
    
        while (!empty($queue)) {
            $path = array_shift($queue);
            $currentCountryCode = end($path);
    
            if ($currentCountryCode === $destinationCountryCode) {
                return $path;
            }
    
            if (!isset($visited[$currentCountryCode])) {
                $visited[$currentCountryCode] = true;
                $currentCountry = $countriesData[array_search($currentCountryCode, array_column($countriesData, 'cca3'))];
    
                foreach ($currentCountry['borders'] as $borderCountryCode) {
                    if (!isset($visited[$borderCountryCode])) {
                        $newPath = $path;
                        array_push($newPath, $borderCountryCode);
                        array_push($queue, $newPath);
                    }
                }
            }
        }
    
        return false;
    }

    /**
     * @return array<mixed[]>
     */
    private function getCountriesData(): Array 
    {
        return $this->cache->get('api_countries', function(CacheItemInterface $cacheItem) {
            $cacheItem->expiresAfter(5);
            $countriesData = $this->httpClient->request('GET', $this->apiCountriesUrl);
            return $countriesData->toArray();
        });
    }
}
