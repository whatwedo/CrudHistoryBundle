<?php

declare(strict_types=1);

namespace whatwedo\CrudHistoryBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Routing\RouterInterface;
use whatwedo\CrudHistoryBundle\Tests\App\Factory\CompanyFactory;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class ControllerTest extends WebTestCase
{
    use Factories;
    use ResetDatabase;

    public function testGetHistory(): void
    {
        $client = static::createClient();

        $company = CompanyFactory::createOne()->object();

        /** @var RouterInterface $router */
        $router = self::getContainer()->get(RouterInterface::class);

        $url = $router->generate('whatwedo_crud_history_tests_app_company_history', [
            'id' => $company->getId(),
        ]);
        $crawler = $client->request('GET', $url);

        self::assertResponseIsSuccessful();

        $this->assertnotSame('', $crawler->html());
    }
}
