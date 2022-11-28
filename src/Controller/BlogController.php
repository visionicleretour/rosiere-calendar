<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    #[Route('/blog', name: 'app_blog')]
    public function index(EntityManagerInterface $em): Response
    {
        $articles = $em->getRepository(Article::class)->findAll();

        $articles = array_reverse($articles);

        return $this->render('blog/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    #[Route('/blog/{id}', name: 'app_see_article')]
    public function seeArticle(int $id, EntityManagerInterface $em): Response
    {
        $article = $em->getRepository(Article::class)->find($id);

        if (empty($article)) {
            $this->addFlash('error', 'Article introuvable');
            return $this->redirectToRoute('app_blog');
        }

        return $this->render('blog/see.html.twig', [
            'article' => $article,
        ]);
    }

    #[Route('/admin/blog', name: 'app_blog_admin')]
    public function indexAdmin(Request $request, EntityManagerInterface $em): Response
    {
        $article = new Article();

        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $article->setCreatedAt(new DateTimeImmutable());
            $article->setAuthor($this->getUser());

            $em->persist($article);
            $em->flush();

            $this->addFlash('success', 'Votre article a bien été créé');

            return $this->redirectToRoute('app_see_article', ['id' => $article->getId()]);
        }


        return $this->renderForm('blog/new.html.twig', [
            'form' => $form
        ]);
    }
}
