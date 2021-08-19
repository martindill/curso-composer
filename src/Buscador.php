<?php

namespace Alura\BuscadorDeCursos;

use GuzzleHttp\ClientInterface;
use Symfony\Component\DomCrawler\Crawler;

class Buscador
{
    private $httpClient;
    private $crawler;

    public function __construct(ClientInterface $httpClient, Crawler $crawler)
    {
        $this->httpClient = $httpClient;
        $this->crawler = $crawler;
    }

    public function buscar(string $url): array
    {
        $response = $this->httpClient->request('GET', $url);
        $body = $response->getBody();
        $this->crawler->addHtmlContent($body);
        $elementosCursos = $this->crawler->filter("span.card-curso__nome");
        $cursos = [];
        foreach ($elementosCursos as $elementosCursos) {
            $cursos[] = $elementosCursos->textContent;
        }
        return $cursos;
    }
}
