<?php

namespace App\Controller;

use App\Entity\KanbanColumn;
use App\Entity\Project;
use App\Entity\Sprint;
use App\Entity\Task;
use App\Form\KanbanColumnType;
use App\Repository\ProjectRepository;
use App\Repository\SprintRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ProjectCreateType;
use App\Form\TaskCreateType;
use ArrayObject;
use DateTime;
use phpDocumentor\Reflection\Types\Array_;

class ProjectController extends AbstractController
{

    /**
     * @Route("/project", name="app_project",methods={"GET", "POST"} )
     */
    public function index(ProjectRepository $repoProject): Response
    {
        $user = $this->getUser();
        $projects = $user->getProjects();
        return $this->render('project/project.html.twig', ['projects' => $projects]);
    }
    /**
     * @Route("/createProject", name="app_createProject",methods={"GET", "POST"} )
     */
    public function createProject(Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(ProjectCreateType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $project = $form->getData();
            $em->persist($project);
            $em->flush();
            $this->addFlash('success', 'User successfully created');
            return $this->redirectToRoute('app_home');
        }

        return $this->render('project/createProject.html.twig', ['createProjectForm' => $form->createView()]);
    }
    /**
     * @Route("/openedProject/{projectId}", name="app_openedProject",methods={"GET", "POST"} )
     */
    public function openProject($projectId, Request $request): Response
    {
        $repository = $this->getDoctrine()->getRepository(Project::class);
        $project = $repository->findOneBy(['id' => $projectId]);

        dd($project);
        return $this->render('project/openedProject.html.twig', ['project' => $project]);
    }


    /**
     * @Route("/sprint_create/{projectId}", name="app_sprint_create",methods={"GET", "POST"} )
     */
    public function createSprint($projectId, Request $request, EntityManagerInterface $em): Response
    {

        $repository = $this->getDoctrine()->getRepository(Project::class);
        $project =  $repository->findOneBy(['id' => $projectId]);


        $sprint = new Sprint;

        //On ajoute le Sprint au projet
        $project->addSprintList($sprint);

        $em->persist($sprint);
        $em->persist($project);

        $em->flush();



        return $this->redirectToRoute('app_list_sprint', ['projectId' => $projectId]);
    }


    /**
     * @Route("app_createColumn/{projectId}/{sprintId}", name="app_column_create",methods={"GET", "POST"} )
     */
    public function createColumn($projectId, $sprintId, Request $request, EntityManagerInterface $em): Response
    {

        $form = $this->createForm(KanbanColumnType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $column = $form->getData();
            $em->persist($column);

            ///////////////////////////////////////////////////////
            $repository = $this->getDoctrine()->getRepository(Sprint::class);
            $sprint =  $repository->findOneBy(['id' => $sprintId]);

            $sprint->addKanbanTab($column);
            $em->persist($sprint);
            $em->flush();
            $this->addFlash('success', 'Column successfully created');
            return $this->redirectToRoute('app_view_tab', ['projectId' => $projectId, 'sprintId' => $sprintId]);
        }


        return $this->render('sprint_tab/kanbanColumnForm.html.twig', ['createFormKanban' => $form->createView()]);
    }


    //////////////////////////////////////Edit column////////////////////////////////////////////////////////////////////

    /**
     * @Route("app_editColumn/{projectId}/{sprintId}/{columnId}", name="app_column_edit",methods={"GET", "POST"} )
     */
    public function editColumn($projectId, $sprintId, $columnId, Request $request, EntityManagerInterface $em): Response
    {

        $repository = $this->getDoctrine()->getRepository(KanbanColumn::class);
        $column =  $repository->findOneBy(['id' => $columnId]);

        $form = $this->createForm(KanbanColumnType::class, $column);


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $column = $form->getData();
            $em->persist($column);

            ///////////////////////////////////////////////////////
            $repository = $this->getDoctrine()->getRepository(Sprint::class);
            $sprint =  $repository->findOneBy(['id' => $sprintId]);

            $sprint->addKanbanTab($column);
            $em->persist($sprint);
            $em->flush();
            $this->addFlash('success', 'Column successfully created');
            return $this->redirectToRoute('app_view_tab', ['projectId' => $projectId, 'sprintId' => $sprintId]);
        }


        return $this->render('sprint_tab/kanbanColumnForm.html.twig', ['createFormKanban' => $form->createView()]);
    }
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





    /**
     * @Route("/createTask/{projectId}/{sprintId}/{columnId}", name="app_createTask",methods={"GET", "POST"} )
     */
    public function createTask($projectId, $sprintId, $columnId, Request $request, EntityManagerInterface $em): Response
    {
        $repository = $this->getDoctrine()->getRepository(KanbanColumn::class);

        $column = $repository->findOneBy(['id' => $columnId]);

        if ($column->getNbMaxTasks() == $column->getTaskList()->count()) {

            $this->addFlash('error', 'Vous avez atteint le nombre maximal de tâches pour cette colonne');
            return $this->redirectToRoute('app_view_tab', ['projectId' => $projectId, 'sprintId' => $sprintId]);
        }


        $task = new Task();
        $form = $this->createForm(TaskCreateType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $users = $form->get('assignation')->getData();
            foreach ($users as $user) {
                $user->addTask($task);
                $em->persist($user);
            }

            //Mettre à jour la colonne 

            $em->persist($task);
            /////////////////////////////////////////////////////////////


            /////////////////////////////////////////////////////////////
            $repository = $this->getDoctrine()->getRepository(Sprint::class);

            $sprint = $repository->findOneBy(['id' => $sprintId]);


            $sprint->addTaskList($task);




            $column->addTaskList($task);



            $em->persist($column);


            $em->flush();
            $this->addFlash('success', 'Task successfully created');

            return $this->redirectToRoute('app_view_tab', ['projectId' => $projectId, 'sprintId' => $sprintId]);
        }


        return $this->render('task.html.twig', ['createTaskForm' => $form->createView()]);
    }





    /**
     * @Route("/deleteTask/{projectId}/{sprintId}/{columnId}/{taskId}", name="app_deleteTask",methods={"GET", "POST"} )
     */
    public function deleteTask($projectId, $sprintId, $columnId, $taskId, Request $request, EntityManagerInterface $em): Response
    {


        /////////////////////////////////////////////////////
        $repository = $this->getDoctrine()->getRepository(Task::class);

        $task = $repository->findOneBy(['id' => $taskId]);

        /////////////////////////////////////////////////////////////
        $repository = $this->getDoctrine()->getRepository(Sprint::class);

        $sprint = $repository->findOneBy(['id' => $sprintId]);



        $sprint->removeTaskList($task);

        ////////////////////////////////////////////////////
        $repository = $this->getDoctrine()->getRepository(KanbanColumn::class);

        $column = $repository->findOneBy(['id' => $columnId]);

        $column->removeTaskList($task);

        $em->persist($sprint);
        $em->persist($column);




        $em->flush();
        $this->addFlash('success', 'Task deleted successfully');

        return $this->redirectToRoute('app_view_tab', ['projectId' => $projectId, 'sprintId' => $sprintId]);
    }

    /**
     * @Route("/deleteColumn/{projectId}/{sprintId}/{columnId}", name="app_deleteColumn",methods={"GET", "POST"} )
     */
    public function deleteColumn($projectId, $sprintId, $columnId, Request $request, EntityManagerInterface $em): Response
    {


        /////////////////////////////////////////////////////

        /////////////////////////////////////////////////////////////
        $repository = $this->getDoctrine()->getRepository(Sprint::class);

        $sprint = $repository->findOneBy(['id' => $sprintId]);

        ////////////////////////////////////////////////////
        $repository = $this->getDoctrine()->getRepository(KanbanColumn::class);

        $column = $repository->findOneBy(['id' => $columnId]);

        $sprint->removeKanbanTab($column);

        $em->persist($sprint);

        $em->flush();
        $this->addFlash('success', 'Column deleted successfully');

        return $this->redirectToRoute('app_view_tab', ['projectId' => $projectId, 'sprintId' => $sprintId]);
    }


    /////////////////////////////////////////////////////////////////////////////////////


    /**
     * @Route("/editTask/{projectId}/{sprintId}/{columnId}/{taskId}", name="app_editTask",methods={"GET", "POST"} )
     */
    public function editTask($projectId, $sprintId, $columnId, $taskId,  Request $request, EntityManagerInterface $em): Response
    {
        $repository = $this->getDoctrine()->getRepository(Task::class);

        $task = $repository->findOneBy(['id' => $taskId]);


        $form = $this->createForm(TaskCreateType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $users = $form->get('assignation')->getData();
            foreach ($users as $user) {
                $user->addTask($task);
                $em->persist($user);
            }


            $em->persist($task);

            $em->flush();
            $this->addFlash('success', 'Task successfully created');

            return $this->redirectToRoute('app_view_tab', ['projectId' => $projectId, 'sprintId' => $sprintId]);
        }


        return $this->render('task.html.twig', ['createTaskForm' => $form->createView()]);
    }


    /////////////////////////////////////////////////////////////////////////////////////


    /**
     * @Route("/appTask/{projectId}/{sprintId}/{columnId}/{taskId}", name="app_viewTask",methods={"GET", "POST"} )
     */
    public function viewTask($projectId, $sprintId, $columnId, $taskId,  Request $request, EntityManagerInterface $em): Response
    {

        $repository = $this->getDoctrine()->getRepository(Task::class);

        $task = $repository->findOneBy(['id' => $taskId]);


        $repository = $this->getDoctrine()->getRepository(Project::class);

        $project = $repository->findOneBy(['id' => $projectId]);


        $repository = $this->getDoctrine()->getRepository(Sprint::class);

        $sprint = $repository->findOneBy(['id' => $sprintId]);

        $repository = $this->getDoctrine()->getRepository(KanbanColumn::class);

        $column = $repository->findOneBy(['id' => $columnId]);


        return $this->render('taskDetails.html.twig', ['project' => $project,  'sprint' => $sprint, 'kanbanColumn' => $column, 'task' => $task]);
    }
}
