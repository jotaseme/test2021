<?php

namespace App\Controller;

use App\Entity\Project;
use App\Filter\ProjectFilterType;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdaterInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProjectController extends AbstractController
{
    #[Route('/project', name: 'new_project')]
    public function new(Request $request, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $form          = $this->createForm(ProjectType::class, $project = new Project());

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($project);
            $entityManager->flush();
            return $this->redirectToRoute('list_projects');
        }
        return $this->renderForm('project/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/projects', name: 'list_projects')]
    public function list(
        Request                       $request,
        ProjectRepository             $repository,
        FilterBuilderUpdaterInterface $filterBuilderUpdater,
        PaginatorInterface            $paginator
    ): Response
    {
        $projectFilterType = $this->createForm(ProjectFilterType::class);

        $filterBuilder = $repository
            ->createQueryBuilder('p')
            ->orderBy('p.startDate', 'desc');
        if ($request->query->has($projectFilterType->getName())) {
            $projectFilterType->submit($request->query->all($projectFilterType->getName()));
            $filterBuilderUpdater->addFilterConditions($projectFilterType, $filterBuilder);
        }
        $projects = $paginator->paginate(
            $filterBuilder,
            $request->query->get('page', 1),
            25
        );

        return $this->render('project/list.html.twig', array(
            'filter'   => $projectFilterType->createView(),
            'projects' => $projects,
        ));
    }
}
