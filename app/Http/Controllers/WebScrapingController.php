<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;

class WebScrapingController extends Controller
{
    public function parseHtml()
    {
        $httpClient = HttpClient::create();
        $response = $httpClient->request('GET', 'https://www.cineco.cc/');
        $htmlContent = $response->getContent();

        $crawler = new Crawler($htmlContent);

        $filePath = storage_path('app/public/scraped_content.html');

        file_put_contents($filePath, $htmlContent);

        return response()->json(['file_path' => $filePath]);

    }

    public function parseTxt()
    {
        $httpClient = HttpClient::create();
        $response = $httpClient->request('GET', 'https://www.cineco.cc/');
        $htmlContent = $response->getContent();

        $crawler = new Crawler($htmlContent);

        $bodyText = $crawler->filter('body')->text();

        $filePath = storage_path('app/public/scraped_text.txt');

        file_put_contents($filePath, $bodyText);

        return response()->json(['file_path' => $filePath]);
    }


    public function scrapeAndSaveCleanHtml()
    {
        $url = 'https://www.cineco.cc/';
        $outputFile = public_path('parsed_output.html'); // Файл будет сохранен в папке public

        // Создаем HTTP-клиент
        $client = HttpClient::create();
        $response = $client->request('GET', $url);

        // Получаем HTML-контент страницы
        $htmlContent = $response->getContent();

        // Парсим HTML-контент
        $crawler = new Crawler($htmlContent);

        // Получаем текст из каждого блока и сохраняем с тегами, но без классов и ID
        $textContent = $crawler->filter('body *')->each(function (Crawler $node) {
            $tagName = $node->nodeName();
            $text = $node->text();
            return "<$tagName>$text</$tagName>";
        });

        // Записываем результат в файл
        file_put_contents($outputFile, implode(PHP_EOL, $textContent));

        return response()->download($outputFile);
    }
}
