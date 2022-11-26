<?php

namespace App\Test\Controller;

use App\Entity\Blog;
use App\Repository\BlogRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BlogControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private BlogRepository $repository;
    private string $path = '/blog/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Blog::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Blog index');

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
            'blog[name]' => 'Testing',
            'blog[date]' => 'Testing',
            'blog[imageName]' => 'Testing',
            'blog[detail]' => 'Testing',
            'blog[createdAt]' => 'Testing',
            'blog[updatedAt]' => 'Testing',
        ]);

        self::assertResponseRedirects('/blog/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Blog();
        $fixture->setName('My Title');
        $fixture->setDate('My Title');
        $fixture->setImageName('My Title');
        $fixture->setDetail('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setUpdatedAt('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Blog');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Blog();
        $fixture->setName('My Title');
        $fixture->setDate('My Title');
        $fixture->setImageName('My Title');
        $fixture->setDetail('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setUpdatedAt('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'blog[name]' => 'Something New',
            'blog[date]' => 'Something New',
            'blog[imageName]' => 'Something New',
            'blog[detail]' => 'Something New',
            'blog[createdAt]' => 'Something New',
            'blog[updatedAt]' => 'Something New',
        ]);

        self::assertResponseRedirects('/blog/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getName());
        self::assertSame('Something New', $fixture[0]->getDate());
        self::assertSame('Something New', $fixture[0]->getImageName());
        self::assertSame('Something New', $fixture[0]->getDetail());
        self::assertSame('Something New', $fixture[0]->getCreatedAt());
        self::assertSame('Something New', $fixture[0]->getUpdatedAt());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Blog();
        $fixture->setName('My Title');
        $fixture->setDate('My Title');
        $fixture->setImageName('My Title');
        $fixture->setDetail('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setUpdatedAt('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/blog/');
    }
}
