<?php

namespace App\Controller;

use App\Entity\Sprint;
use App\Entity\Project;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class SprintTabController extends AbstractController
{

    /**
     * @Route("/kanbanTab/{projectId}/{sprintId}", name="app_view_tab",methods={"GET", "POST"} )
     */
    public function viewKanbanTab($projectId, $sprintId): Response
    {

        $repo = $this->getDoctrine()->getRepository(Sprint::class);
        $sprint = ($repo->findOneBy(['id' => $sprintId]));

        $repo = $this->getDoctrine()->getRepository(Project::class);
        $project = ($repo->findOneBy(['id' => $projectId]));


        $colorArray = [
            'priorité très forte' => 'badge bg-danger',
            'priorité forte' => 'badge bg-warning',
            'priorité moyenne' => 'badge bg-primary',
            'priorité faible' => 'badge bg-success'

        ];

        return $this->render('sprint_tab/kanbanTab.html.twig', ['project' => $project, 'kanbanTabs' => $sprint->getKanbanTab(), 'sprint' => $sprint, 'colorArray' => $colorArray]);
    }
    /**
     * @Route("/listSprint/{projectId}", name="app_list_sprint",methods={"GET", "POST"} )
     */
    public function listSprint($projectId, EntityManagerInterface $em, Request $request): Response
    {


        $form = $this->createFormBuilder()
            ->add('select', EntityType::class, [
                'class' => Sprint::class,
                // uses the User.username property as the visible option string
                'choice_label' => 'id',
                'label' => 'Select',
                'placeholder' => 'select',

                // used to render a select box, check boxes or radios
                // 'multiple' => true
                // 'expanded' => true
            ])
            ->getForm();
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $sprint = $form->get('select')->getData();
            $sprintId = $sprint->getId();
            // dd($sprint);
            // dd($sprint->getId());
            return $this->redirectToRoute('app_view_tab', ['projectId' => $projectId, 'sprintId' => $sprint->getId()]);
        }

        $repo = $repo = $this->getDoctrine()->getRepository(Project::class);
        $project = ($repo->findOneBy(['id' => $projectId]));
        return $this->render('project/openedProject.html.twig', ['listSprintForm' => $form->createView(), 'project' => $project]);
    }
}
