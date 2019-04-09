<?php
namespace Client\Webapp\Tests;

use Silex\WebTestCase;

define('ROOT_PATH', realpath('.'));

class AppTest extends WebTestCase
{
    public function createApplication()
    {
        return require ROOT_PATH . '/src/Client/Webapp/app.php';
    }

    public function testApiRoot()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/');
        $response = $client->getResponse();

        $this->assertTrue($response->isOk());
        $this->assertEquals('Status OK', $response->getContent());
    }

    public function test404()
    {
        $client = $this->createClient();
        $client->request('GET', '/give-me-a-404');
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }

    public function testApiJson()
    {
        $client = $this->createClient();
        $client->followRedirects(true);
        $crawler = $client->request('GET', '/surveys');
        $response = $client->getResponse();

        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
    }

    public function testApiSurveys()
    {
        $client = $this->createClient();
        $client->followRedirects(true);

        $crawler = $client->request('GET', '/surveys');
        $response = $client->getResponse();

        $this->assertTrue($response->isOk());

        $responseData = json_decode($response->getContent(), true);

        /**
         * On pourrait mettre ici une limite de boucle à 5 par exemple et quitter le foreach avec un break
         */
        foreach($responseData as $key => $value) {
            $this->assertArrayHasKey("name", $value);
            $this->assertArrayHasKey("code", $value);
        }
    }

    public function testApiSurveysById()
    {
        $client = $this->createClient();
        $client->followRedirects(true);

        $crawler = $client->request('GET', '/surveys/XX2');
        $response = $client->getResponse();

        $this->assertTrue($response->isOk());

        $responseData = json_decode($response->getContent(), true);
        $this->assertArrayHasKey("name", $responseData);
        $this->assertArrayHasKey("code", $responseData);
        $this->assertArrayHasKey("nbProducts", $responseData);
        $this->assertArrayHasKey("dates", $responseData);
        $this->assertArrayHasKey("products", $responseData);
    }
}
?>