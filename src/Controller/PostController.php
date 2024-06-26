<?php
declare(strict_types=1);

namespace App\Controller;

use App\Service\ImageServiceInterface;
use App\Service\PostServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\ForbiddenOverwriteException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class PostController extends AbstractController
{

    public function __construct(
        private PostServiceInterface $postService,
        private ImageServiceInterface $imageService,
    )
    {
    }

    public function publishPost(Request $request): Response
    {
        $user = $this->getUser();
        if ($user === null)
        {
            throw new UnauthorizedHttpException('');
        }
        $roles = $user->getRoles();
        if (!in_array('ROLE_ADMIN', $roles))
        {
            throw new ForbiddenOverwriteException();
        }
        if ($user->getUserIdentifier() !== $request->get('email', ''))
        {
            throw new ForbiddenOverwriteException();
        }

        $imagePath = (isset($_FILES['image'])) ? $this->imageService->moveImageToUploads($_FILES['image']) : null;

        $postId = $this->postService->savePost(
            $request->get('title'),
            $request->get('subtitle'),
            $request->get('content'),
            $imagePath,
        );

        return $this->redirectToRoute(
            'show_post',
            ['postId' => $postId],
            Response::HTTP_SEE_OTHER
        );
    }

    public function viewPost(int $postId): Response
    {
        $post = $this->postService->getPost($postId);

        return $this->render('post/post.html.twig', [
            'post' => $post
        ]);
    }

    public function deletePost(int $postId): Response
    {
        $this->postService->deletePost($postId);

        return $this->redirectToRoute('list_posts');
    }

    public function listPosts(): Response
    {
        $posts = $this->postService->listPosts();
        $postsView = [];
        foreach ($posts as $post)
        {
            $postsView[] = $post->toArray();
        }

        return $this->render('post/list.html.twig', [
            'posts_list' => $postsView
        ]);
    }
}
