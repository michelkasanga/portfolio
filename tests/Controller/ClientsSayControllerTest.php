<?php

namespace App\Test\Controller;

use App\Entity\ClientsSay;
use App\Repository\ClientsSayRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ClientsSayControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private ClientsSayRepository $repository;
    private string $path = '/clients/say/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(ClientsSay::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('ClientsSay index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'clients_say[fullName]' => 'Testing',
            'clients_say[profession]' => 'Testing',
            'clients_say[imageName]' => 'Testing',
            'clients_say[message]' => 'Testing',
            'clients_say[createdAt]' => 'Testing',
            'clients_say[updatedAt]' => 'Testing',
        ]);

        self::assertResponseRedirects('/clients/say/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new ClientsSay();
        $fixture->setFullName('My Title');
        $fixture->setProfession('My Title');
        $fixture->setImageName('My Title');
        $fixture->setMessage('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setUpdatedAt('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('ClientsSay');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new ClientsSay();
        $fixture->setFullName('My Title');
        $fixture->setProfession('My Title');
        $fixture->setImageName('My Title');
        $fixture->setMessage('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setUpdatedAt('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'clients_say[fullName]' => 'Something New',
            'clients_say[profession]' => 'Something New',
            'clients_say[imageName]' => 'Something New',
            'clients_say[message]' => 'Something New',
            'clients_say[createdAt]' => 'Something New',
            'clients_say[updatedAt]' => 'Something New',
        ]);

        self::assertResponseRedirects('/clients/say/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getFullName());
        self::assertSame('Something New', $fixture[0]->getProfession());
        self::assertSame('Something New', $fixture[0]->getImageName());
        self::assertSame('Something New', $fixture[0]->getMessage());
        self::assertSame('Something New', $fixture[0]->getCreatedAt());
        self::assertSame('Something New', $fixture[0]->getUpdatedAt());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new ClientsSay();
        $fixture->setFullName('My Title');
        $fixture->setProfession('My Title');
        $fixture->setImageName('My Title');
        $fixture->setMessage('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setUpdatedAt('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/clients/say/');
    }
}
