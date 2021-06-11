<?php

namespace Alura\BuscadorDeCursos;

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class Buscador
{
    private Crawler $crawler;
    private Client $clienteHttp;

    public function __construct(Client $clienteHttp, Crawler $crawler)
    {
        $this->crawler = $crawler;
        $this->clienteHttp = $clienteHttp;
    }

    public function buscar(string $url): array
    {
        $response = $this->clienteHttp->request('GET', $url);

        $html = $response->getBody();

        $this->crawler->addHtmlContent($html);
        $elementosCurso = $this->crawler->filter("span.card-curso__nome");

        $cursos = [];

        foreach ($elementosCurso as $elemento) {
            array_push($cursos, $elemento->textContent);
        }
        return $cursos;
    }
}
