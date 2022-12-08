<?php

namespace App\Test\Controller;

use App\Entity\About;
use App\Repository\AboutRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AboutControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private AboutRepository $repository;
    private string $path = '/about/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(About::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('About index');

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
            'about[title]' => 'Testing',
            'about[fullName]' => 'Testing',
            'about[imageName]' => 'Testing',
            'about[birthday]' => 'Testing',
            'about[experience]' => 'Testing',
            'about[phone]' => 'Testing',
            'about[email]' => 'Testing',
            'about[address]' => 'Testing',
            'about[freelance]' => 'Testing',
            'about[detail]' => 'Testing',
            'about[createdAt]' => 'Testing',
            'about[updatedAt]' => 'Testing',
        ]);

        self::assertResponseRedirects('/about/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new About();
        $fixture->setTitle('My Title');
        $fixture->setFullName('My Title');
        $fixture->setImageName('My Title');
        $fixture->setExperience('My Title');
        $fixture->setPhone('My Title');
        $fixture->setEmail('My Title');
        $fixture->setAddress('My Title');
        $fixture->setFreelance('My Title');
        $fixture->setDetail('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('About');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new About();
        $fixture->setTitle('My Title');
        $fixture->setFullName('My Title');
        $fixture->setImageName('My Title');
        $fixture->setExperience('My Title');
        $fixture->setPhone('My Title');
        $fixture->setEmail('My Title');
        $fixture->setAddress('My Title');
        $fixture->setFreelance('My Title');
        $fixture->setDetail('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'about[title]' => 'Something New',
            'about[fullName]' => 'Something New',
            'about[imageName]' => 'Something New',
            'about[birthday]' => 'Something New',
            'about[experience]' => 'Something New',
            'about[phone]' => 'Something New',
            'about[email]' => 'Something New',
            'about[address]' => 'Something New',
            'about[freelance]' => 'Something New',
            'about[detail]' => 'Something New',
            'about[createdAt]' => 'Something New',
            'about[updatedAt]' => 'Something New',
        ]);

        self::assertResponseRedirects('/about/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getTitle());
        self::assertSame('Something New', $fixture[0]->getFullName());
        self::assertSame('Something New', $fixture[0]->getImageName());
        self::assertSame('Something New', $fixture[0]->getBirthday());
        self::assertSame('Something New', $fixture[0]->getExperience());
        self::assertSame('Something New', $fixture[0]->getPhone());
        self::assertSame('Something New', $fixture[0]->getEmail());
        self::assertSame('Something New', $fixture[0]->getAddress());
        self::assertSame('Something New', $fixture[0]->getFreelance());
        self::assertSame('Something New', $fixture[0]->getDetail());
        self::assertSame('Something New', $fixture[0]->getCreatedAt());
        self::assertSame('Something New', $fixture[0]->getUpdatedAt());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new About();
        $fixture->setTitle('My Title');
        $fixture->setFullName('My Title');
        $fixture->setImageName('My Title');
        $fixture->setExperience('My Title');
        $fixture->setPhone('My Title');
        $fixture->setEmail('My Title');
        $fixture->setAddress('My Title');
        $fixture->setFreelance('My Title');
        $fixture->setDetail('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/about/');
    }
}
