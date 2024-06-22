<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PostController extends AbstractController
{

    public function __construct(
        private readonly PostRepository $postRepository,
    )
    {
    }

    public function index(): Response
    {
        return $this->render('post/add_post_form.html.twig');
    }

    public function publishPost(Request $request): Response
    {
        $post = new Post(
            null,
            $request->get('title'),
            $request->get('subtitle'),
            $request->get('content'),
            '',
            new \DateTimeImmutable(),
        );
        $postId = $this->postRepository->store($post);

        return $this->redirectToRoute('show_post', ['postId' => $postId], Response::HTTP_SEE_OTHER);
    }

    public function viewPost(int $postId): Response
    {
        $post = $this->postRepository->findById($postId);
        if ($post === null) {
            throw $this->createNotFoundException();
        }

        return $this->render('post/view_post.html.twig', [
            'post' => $post
        ]);
    }

    public function listPosts(): Response
    {
        $posts = $this->postRepository->findAll();
        return $this->render('post/post_list.html.twig', [
            'posts_list' => $posts,
        ]);
    }
}
