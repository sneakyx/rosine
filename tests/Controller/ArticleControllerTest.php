<?php

namespace App\Test\Controller;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ArticleControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/article/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Article::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Article index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'article[artName]' => 'Testing',
            'article[artUnit]' => 'Testing',
            'article[artPrice]' => 'Testing',
            'article[artTax]' => 'Testing',
            'article[artStocknr]' => 'Testing',
            'article[artInstock]' => 'Testing',
            'article[artNote]' => 'Testing',
            'article[generated]' => 'Testing',
            'article[changed]' => 'Testing',
        ]);

        self::assertResponseRedirects('/sweet/food/');

        self::assertSame(1, $this->getRepository()->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Article();
        $fixture->setArtName('My Title');
        $fixture->setArtUnit('My Title');
        $fixture->setArtPrice('My Title');
        $fixture->setArtTax('My Title');
        $fixture->setArtStocknr('My Title');
        $fixture->setArtInstock('My Title');
        $fixture->setArtNote('My Title');
        $fixture->setGenerated('My Title');
        $fixture->setChanged('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Article');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Article();
        $fixture->setArtName('Value');
        $fixture->setArtUnit('Value');
        $fixture->setArtPrice('Value');
        $fixture->setArtTax('Value');
        $fixture->setArtStocknr('Value');
        $fixture->setArtInstock('Value');
        $fixture->setArtNote('Value');
        $fixture->setGenerated('Value');
        $fixture->setChanged('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'article[artName]' => 'Something New',
            'article[artUnit]' => 'Something New',
            'article[artPrice]' => 'Something New',
            'article[artTax]' => 'Something New',
            'article[artStocknr]' => 'Something New',
            'article[artInstock]' => 'Something New',
            'article[artNote]' => 'Something New',
            'article[generated]' => 'Something New',
            'article[changed]' => 'Something New',
        ]);

        self::assertResponseRedirects('/article/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getArtName());
        self::assertSame('Something New', $fixture[0]->getArtUnit());
        self::assertSame('Something New', $fixture[0]->getArtPrice());
        self::assertSame('Something New', $fixture[0]->getArtTax());
        self::assertSame('Something New', $fixture[0]->getArtStocknr());
        self::assertSame('Something New', $fixture[0]->getArtInstock());
        self::assertSame('Something New', $fixture[0]->getArtNote());
        self::assertSame('Something New', $fixture[0]->getGenerated());
        self::assertSame('Something New', $fixture[0]->getChanged());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Article();
        $fixture->setArtName('Value');
        $fixture->setArtUnit('Value');
        $fixture->setArtPrice('Value');
        $fixture->setArtTax('Value');
        $fixture->setArtStocknr('Value');
        $fixture->setArtInstock('Value');
        $fixture->setArtNote('Value');
        $fixture->setGenerated('Value');
        $fixture->setChanged('Value');

        $$this->manager->remove($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/article/');
        self::assertSame(0, $this->repository->count([]));
    }
}
