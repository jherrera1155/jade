<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Form\Annotation\AnnotationBuilder;
use Doctrine\ORM\EntityManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> Fixed merge conflicts
use Application\Service\ActivityStreamLogger;
use Application\Entity\Job;
use Application\Entity\Activity;
<<<<<<< HEAD
use Application\Entity\User;
=======
=======
use Application\Service\ActivityRecorder;
=======
=======
>>>>>>> Added activity recording service and activity stream in case view
=======
>>>>>>> Updated service names
use Application\Service\ActivityStreamLogger;
>>>>>>> Updated service names
use Application\Entity\Job;
<<<<<<< HEAD
use Application\Entity\Activity;
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> Added activity recording service and activity stream in case view
use Application\Form\ConfirmationForm;
>>>>>>> Redefined confirmation form as modal invoked via AJAX. Updated across controllers. Closes #51.
=======
=======
>>>>>>> Updated service
<<<<<<< HEAD
use Application\Form\ConfirmationForm;
=======
use Application\Entity\User;
>>>>>>> Updated service
<<<<<<< HEAD
>>>>>>> Updated service
=======
=======
use Application\Service\ActivityRecorder;
=======
use Application\Service\ActivityStreamLogger;
>>>>>>> Updated service names
use Application\Entity\Job;
use Application\Entity\Activity;
>>>>>>> Added activity recording service and activity stream in case view
<<<<<<< HEAD
>>>>>>> Added activity recording service and activity stream in case view
=======
=======
use Application\Entity\User;
>>>>>>> Updated service
<<<<<<< HEAD
>>>>>>> Updated service
=======
=======
=======
>>>>>>> Fixed merge conflicts
use Application\Entity\User;
use Application\Form\ConfirmationForm;
<<<<<<< HEAD
>>>>>>> Redefined confirmation form as modal invoked via AJAX. Updated across controllers. Closes #51.
>>>>>>> Redefined confirmation form as modal invoked via AJAX. Updated across controllers. Closes #51.
=======
>>>>>>> Fixed merge conflicts

class JobController extends AbstractActionController
{
    private $em;
    
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> Added activity recording service and activity stream in case view
=======
>>>>>>> Updated service names
=======
>>>>>>> Fixed merge conflicts
    public function __construct(EntityManager $em, ActivityStreamLogger $asl)
    {
        $this->em = $em;
        $this->asl = $asl;
        // TODO replace with authenticated user
        $this->user = new User();
        $this->user->setId(1);
<<<<<<< HEAD
<<<<<<< HEAD
=======
    public function __construct(EntityManager $em, ActivityRecorder $ar)
    {
        $this->em = $em;
        $this->ar = $ar;
>>>>>>> Added activity recording service and activity stream in case view
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> Updated service names
=======
    public function __construct(EntityManager $em, ActivityStreamLogger $asl)
    {
        $this->em = $em;
        $this->asl = $asl;
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> Updated service names
=======
        // TODO replace with authenticated user
        $this->user = new User();
        $this->user->setId(1);
>>>>>>> Updated service
=======
>>>>>>> Added activity recording service and activity stream in case view
=======
>>>>>>> Updated service names
>>>>>>> Updated service names
=======
>>>>>>> Updated service
=======
>>>>>>> Fixed merge conflicts
    }

    public function indexAction()
    {
        $jobs = $this->em->getRepository(Job::class)->findBy(array(), array('created' => 'DESC'));
        return new ViewModel(array('jobs' => $jobs));
    }
    
    public function viewAction()
    {   
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('jobs');
        }
        $job = $this->em->getRepository(Job::class)->find($id);
        $activities = $this->em->getRepository(Activity::class)->findBy(
            array('jobId' => $job->getId()),
            array('created' => 'DESC')
        );
        return new ViewModel(array('job' => $job, 'activities' => $activities));
    }    
    
    public function saveAction()
    {   
        $id = (int) $this->params()->fromRoute('id', 0);
        $job = $this->em->getRepository(Job::class)->find($id);        
        if (!$job) {
            $job = new Job();
            $job->setCreated(new \DateTime("now"));
        }
        $builder = new AnnotationBuilder();
        $hydrator = new DoctrineHydrator($this->em);
        $form = $builder->createForm($job);
        $form->setHydrator($hydrator);
        $form->bind($job);
        $request = $this->getRequest();
        if ($request->isPost()){
            $form->setData($request->getPost());
            if ($form->isValid()){  
                $this->em->persist($job); 
                $this->em->flush();
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> Updated service
=======
>>>>>>> Added activity recording service and activity stream in case view
=======
>>>>>>> Updated service names
=======
=======
>>>>>>> Updated service
>>>>>>> Updated service
=======
>>>>>>> Fixed merge conflicts
                if ($job->getEntityOperationType() == Job::OPERATION_TYPE_CREATE) {
                    $this->asl->log(
                        Job::OPERATION_TYPE_CREATE, 
                        $job,
                        $this->user, 
                        $job
                    );                    
                } else if ($job->getEntityOperationType() == Job::OPERATION_TYPE_UPDATE) {
                    $this->asl->log(
                        Job::OPERATION_TYPE_UPDATE, 
                        $job,
                        $this->user, 
                        $job, 
                        $job->getEntityChangeSet()
                    );                    
                }
<<<<<<< HEAD

<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> Updated service
=======
                $this->ar->record(
=======
                $this->asl->log(
>>>>>>> Updated service names
<<<<<<< HEAD
=======
=======
                $this->ar->record(
>>>>>>> Added activity recording service and activity stream in case view
=======
>>>>>>> Updated service names
                    $job->getEntityOperationType(), 
                    Activity::ENTITY_TYPE_JOB, 
                    $job->getId(), 
                    $job->getId(),
                    $job->getEntityChangeSet()
                );
>>>>>>> Added activity recording service and activity stream in case view
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> Updated service
=======
>>>>>>> Added activity recording service and activity stream in case view
=======
=======
>>>>>>> Updated service
>>>>>>> Updated service
=======
>>>>>>> Fixed merge conflicts
                return $this->redirect()->toRoute('jobs');
            }
        }
         
        return new ViewModel(array(
            'form' => $form,
            'id' => $job->getId(),
        ));
    }
    
    public function deleteAction()
    {   
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('jobs');
        }

        $job = $this->em->getRepository(Job::class)->find($id);
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
        $clone = clone $job;
        $this->em->remove($job);
        $this->em->flush();
        $this->asl->log(
            Job::OPERATION_TYPE_DELETE, 
            $clone,
            $this->user, 
            $clone
        );        
        return $this->redirect()->toRoute('jobs');
=======
=======
>>>>>>> Updated service names
=======
>>>>>>> Updated service
=======
>>>>>>> Updated service
=======
=======
>>>>>>> Redefined confirmation form as modal invoked via AJAX. Updated across controllers. Closes #51.
>>>>>>> Redefined confirmation form as modal invoked via AJAX. Updated across controllers. Closes #51.
=======
>>>>>>> Fixed merge conflicts
        if (!$job) {
            return $this->redirect()->toRoute('jobs');
        }

        $builder = new AnnotationBuilder();
        $form = $builder->createForm(new ConfirmationForm());
        $form->setAttribute('action', $this->url()->fromRoute('jobs', array('action' => 'delete', 'id' => $id)));
        $form->get('cancelTo')->setValue($this->url()->fromRoute('jobs'));
        
        $request = $this->getRequest();
        if ($request->isPost()){
            $form->setData($request->getPost());
            if ($form->isValid()) { 
                $data = $form->getData();
                if ($data['confirm'] == 1) {
                    $clone = clone $job;
                    $this->em->remove($job);
                    $this->em->flush(); 
                    $this->asl->log(
                        Job::OPERATION_TYPE_DELETE, 
                        $clone,
                        $this->user, 
                        $clone
                    );                        
                } 
            }
            return $this->redirect()->toRoute('jobs');
        } 

        $viewModel = new ViewModel(array(
            'form' => $form,
            'entityType' => 'job',
            'entityDescriptor' => $job->getTitle(),            
        ));
        $viewModel->setTerminal($request->isXmlHttpRequest());
        $viewModel->setTemplate('application/common/confirm.phtml');
        return $viewModel;
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> Redefined confirmation form as modal invoked via AJAX. Updated across controllers. Closes #51.
=======
=======
>>>>>>> Redefined confirmation form as modal invoked via AJAX. Updated across controllers. Closes #51.
=======
=======
        $clone = clone $job;
>>>>>>> Updated service
=======
        $clone = clone $job;
>>>>>>> Updated service
        $this->em->remove($job);
        $this->em->flush();
<<<<<<< HEAD
<<<<<<< HEAD
        $this->asl->log(
            Job::OPERATION_TYPE_DELETE, 
            $clone,
            $this->user, 
            $clone
=======
        $this->ar->record(
=======
        $this->asl->log(
<<<<<<< HEAD
>>>>>>> Updated service names
            Activity::ENTITY_OPERATION_TYPE_DELETE, 
            Activity::ENTITY_TYPE_JOB, 
            $id, 
            $id
>>>>>>> Added activity recording service and activity stream in case view
=======
            Job::OPERATION_TYPE_DELETE, 
            $clone,
            $this->user, 
            $clone
>>>>>>> Updated service
        );        
        return $this->redirect()->toRoute('jobs');
>>>>>>> Updated service names
<<<<<<< HEAD
>>>>>>> Updated service names
=======
=======
>>>>>>> Redefined confirmation form as modal invoked via AJAX. Updated across controllers. Closes #51.
>>>>>>> Redefined confirmation form as modal invoked via AJAX. Updated across controllers. Closes #51.
=======
>>>>>>> Fixed merge conflicts
    }
    
}
