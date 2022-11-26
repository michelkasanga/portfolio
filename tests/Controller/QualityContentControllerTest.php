<?php

namespace App\Test\Controller;

use App\Entity\QualityContent;
use App\Repository\QualityContentRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class QualityContentControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private QualityContentRepository $repository;
    private string $path = '/quality/content/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(QualityContent::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('QualityContent index');

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
            'quality_content[post]' => 'Testing',
            'quality_content[company]' => 'Testing',
            'quality_content[startedAt]' => 'Testing',
            'quality_content[endedAt]' => 'Testing',
            'quality_content[createdAt]' => 'Testing',
            'quality_content[updatedAt]' => 'Testing',
            'quality_content[content]' => 'Testing',
            'quality_content[quality]' => 'Testing',
        ]);

        self::assertResponseRedirects('/quality/content/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new QualityContent();
        $fixture->setPost('My Title');
        $fixture->setCompany('My Title');
        $fixture->setStartedAt('My Title');
        $fixture->setEndedAt('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setUpdatedAt('My Title');
        $fixture->setContent('My Title');
        $fixture->setQuality('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('QualityContent');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new QualityContent();
        $fixture->setPost('My Title');
        $fixture->setCompany('My Title');
        $fixture->setStartedAt('My Title');
        $fixture->setEndedAt('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setUpdatedAt('My Title');
        $fixture->setContent('My Title');
        $fixture->setQuality('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'quality_content[post]' => 'Something New',
            'quality_content[company]' => 'Something New',
            'quality_content[startedAt]' => 'Something New',
            'quality_content[endedAt]' => 'Something New',
            'quality_content[createdAt]' => 'Something New',
            'quality_content[updatedAt]' => 'Something New',
            'quality_content[content]' => 'Something New',
            'quality_content[quality]' => 'Something New',
        ]);

        self::assertResponseRedirects('/quality/content/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getPost());
        self::assertSame('Something New', $fixture[0]->getCompany());
        self::assertSame('Something New', $fixture[0]->getStartedAt());
        self::assertSame('Something New', $fixture[0]->getEndedAt());
        self::assertSame('Something New', $fixture[0]->getCreatedAt());
        self::assertSame('Something New', $fixture[0]->getUpdatedAt());
        self::assertSame('Something New', $fixture[0]->getContent());
        self::assertSame('Something New', $fixture[0]->getQuality());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new QualityContent();
        $fixture->setPost('My Title');
        $fixture->setCompany('My Title');
        $fixture->setStartedAt('My Title');
        $fixture->setEndedAt('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setUpdatedAt('My Title');
        $fixture->setContent('My Title');
        $fixture->setQuality('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/quality/content/');
    }
}
