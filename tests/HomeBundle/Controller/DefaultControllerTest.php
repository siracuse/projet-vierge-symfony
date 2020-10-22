<?php

namespace HomeBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testRedirect()
    {
        $client = self::createClient();
        $client->request('GET', '/fr/admin');
        $this->assertTrue($client->getResponse()->isRedirect());
    }
}