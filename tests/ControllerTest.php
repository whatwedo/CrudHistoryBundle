<?php

declare(strict_types=1);

namespace whatwedo\CrudHistoryBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Routing\RouterInterface;
use whatwedo\CrudHistoryBundle\Tests\App\Factory\CompanyFactory;
use whatwedo\CrudHistoryBundle\Tests\App\Helper\ResetDatabase;
use Zenstruck\Foundry\Test\Factories;

class ControllerTest extends WebTestCase
{
    use Factories;
    use ResetDatabase;

    public function testSomething(): void
    {
        // This calls KernelTestCase::bootKernel(), and creates a
        // "client" that is acting as the browser
        $client = static::createClient();

        $this->_resetDatabase();

        $company = CompanyFactory::createOne()->object();

        /** @var RouterInterface $router */
        $router = self::getContainer()->get(RouterInterface::class);

        $url = $router->generate('whatwedo_crud_history_tests_app_company_history', [
            'id' => $company->getId(),
        ]);
        // Request a specific page
        $crawler = $client->request('GET', $url);

        // Validate a successful response and some content
        $this->assertResponseIsSuccessful();

        $this->assertnotSame('', $crawler->html());
    }
}
