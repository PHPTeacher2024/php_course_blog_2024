<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class PostRepository
{
    private EntityRepository $repository;

    public function __construct(
        private EntityManagerInterface $em,
    )
    {
        $this->repository = $em->getRepository(Post::class);
    }

    public function findById(int $id): ?Post
    {
        return $this->repository->find($id);
    }

    /**
     * @return Post[]
     */
    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    public function store(Post $post): int
    {
        $this->em->persist($post);
        $this->em->flush();
        return $post->getId();
    }

    public function delete(Post $post): void
    {
        $this->em->remove($post);
        $this->em->flush();
    }
}