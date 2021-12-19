<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use App\Repository\WorkshopRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/workshop/{workshop_slug}/article')]
class ArticleController extends AbstractController
{
    #[Route('/', name: 'workshop_article_index', methods: ['GET'])]
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render('admin/workshop/article/index.html.twig', [
            'articles' => $articleRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'workshop_article_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, WorkshopRepository $workshopRepository, $workshop_slug): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        $workshop = $workshopRepository->findOneBy(['slug' => $workshop_slug]);

        if ($form->isSubmitted() && $form->isValid()) {

            $article->setWorkshop($workshop);
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('workshop_edit', ['slug' => $workshop->getSlug() ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/workshop/article/new.html.twig', [
            'article' => $article,
            'form' => $form,
            'workshop' => $workshop
        ]);
    }

    #[Route('/{slug}/edit', name: 'workshop_article_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Article $article, EntityManagerInterface $entityManager, WorkshopRepository $workshopRepository, $workshop_slug): Response
    {
        $workshop = $workshopRepository->findOneBy(['slug' => $workshop_slug]);
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('workshop_edit', ['slug' => $workshop->getSlug()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/workshop/article/edit.html.twig', [
            'article' => $article,
            'form' => $form,
            'workshop' => $workshop
        ]);
    }

    #[Route('/{slug}', name: 'workshop_article_delete', methods: ['POST'])]
    public function delete(Request $request, Article $article, EntityManagerInterface $entityManager, $workshop_slug): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getSlug(), $request->request->get('_token'))) {
            $entityManager->remove($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('workshop_edit', ['slug' => $workshop_slug], Response::HTTP_SEE_OTHER);
    }
}
