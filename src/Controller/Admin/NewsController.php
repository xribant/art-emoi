<?php

namespace App\Controller\Admin;

use App\Entity\News;
use App\Form\NewsType;
use App\Repository\NewsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/news')]
class NewsController extends AbstractController
{
    #[Route('/', name: 'news_index', methods: ['GET'])]
    public function index(NewsRepository $newsRepository): Response
    {
        return $this->render('admin/news/index.html.twig', [
            'news' => $newsRepository->findAll(),
            'active_menu' => 'news'
        ]);
    }

    #[Route('/new', name: 'news_new', methods: ['GET','POST'])]
    public function new(Request $request): Response
    {
        $news = new News();
        $form = $this->createForm(NewsType::class, $news);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($news);
            $entityManager->flush();

            return $this->redirectToRoute('news_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/news/new.html.twig', [
            'news' => $news,
            'form' => $form,
            'active_menu' => 'news'
        ]);
    }

    #[Route('/{id}/edit', name: 'news_edit', methods: ['GET','POST'])]
    public function edit(Request $request, News $news): Response
    {
        $form = $this->createForm(NewsType::class, $news);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('news_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/news/edit.html.twig', [
            'news' => $news,
            'form' => $form,
            'active_menu' => 'news'
        ]);
    }

    #[Route('/{id}', name: 'news_delete', methods: ['POST'])]
    public function delete(Request $request, News $news): Response
    {
        if ($this->isCsrfTokenValid('delete'.$news->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($news);
            $entityManager->flush();
        }

        return $this->redirectToRoute('news_index', [], Response::HTTP_SEE_OTHER);
    }
}
