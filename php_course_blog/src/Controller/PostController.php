<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use App\View\PhpTemplateEngine;
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
        $contents = PhpTemplateEngine::render('add_post_form.php');
        return new Response($contents);
    }

    public function publishPost(Request $request): Response
    {
        $post = new Post(
            null,
            $request->get('title'),
            $request->get('subtitle'),
            $request->get('content'),
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

        $contents = PhpTemplateEngine::render('post.php', [
            'post' => $post
        ]);
        return new Response($contents);
    }
}
