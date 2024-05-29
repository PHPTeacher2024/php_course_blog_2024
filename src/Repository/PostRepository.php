<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;

class PostRepository
{
    public function __construct(
        private EntityManagerInterface $em,
    )
    {
    }

    public function findById(int $id): ?Post
    {
        return $this->em->find(Post::class, $id);
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