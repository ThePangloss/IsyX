<?php

// src/ozyx/PlatformBundle/Controller/AdvertController.php

namespace ozyx\PlatformBundle\Controller;

use ozyx\PlatformBundle\Entity\Advert;
use ozyx\PlatformBundle\Entity\Image;
use ozyx\PlatformBundle\Entity\Application;
use ozyx\PlatformBundle\Entity\AdvertSkill;
use ozyx\PlatformBundle\Entity\Contact;
use ozyx\PlatformBundle\Form\UserType;
use ozyx\PlatformBundle\Form\ContactType;
use ozyx\PlatformBundle\Form\FileType;
use ozyx\PlatformBundle\Bigbrother\MessagePostEvent;
use ozyx\PlatformBundle\Bigbrother\BigbrotherEvents;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\PropertyAccess\PropertyAccess;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use League\Flysystem\File;
use Sinergi\BrowserDetector\Browser;
use Sinergi\BrowserDetector\Device;
use Sinergi\BrowserDetector\Os;

class AdvertController extends Controller
{
  public function indexAction(Request $request)
  {
    return $this->render('ozyxPlatformBundle:Advert:index.html.twig');
  }
  public function moiAction(Request $request)
  {
    return $this->render('ozyxPlatformBundle:Advert:moi.html.twig');
  }
  
  public function competencesAction(Request $request)
  {
    return $this->render('ozyxPlatformBundle:Advert:competences.html.twig');
  }

  public function experiencesAction(Request $request)
  {
    return $this->render('ozyxPlatformBundle:Advert:experiences.html.twig');
  }

  public function servicesAction(Request $request)
  {
    return $this->render('ozyxPlatformBundle:Advert:services.html.twig');
  }

  public function aproposAction(Request $request)
  {
    return $this->render('ozyxPlatformBundle:Advert:apropos.html.twig');
  }

  public function carouselAction(Request $request)
  {
    return $this->render('ozyxPlatformBundle:Advert:carousel.html.twig');
  }

  public function translationAction($name)
  {
    return $this->render('ozyxPlatformBundle:Blog:translation.html.twig', array(
      'name' => $name));
  }

  public function contactAction(Request $request)
  {
    $em = $this->getDoctrine()->getManager();
    $contact = new Contact();

    $formBuilder = $this->createForm(ContactType::class, $contact);

    if ($formBuilder->handleRequest($request)->isValid()) { 
      //$em->persist($contact);
      //$em->flush();
      /*
      $contact->setDate(new \Datetime());
      $ipClient = $this->container->get('request_stack')->getCurrentRequest()->getClientIp();
      $contact->setIp($ipClient);
      */
      $mailname    = $formBuilder['name']->getData();
      $mailemail   = $formBuilder['email']->getData();
      $mailsubject = $formBuilder['subject']->getData();
      $content     = $formBuilder['body']->getData();
      $mailContent = htmlspecialchars($content);

      $message = \Swift_Message::newInstance()
        ->setSubject($mailsubject)
        ->setFrom($mailemail)
        ->setTo('qvc@isyx.fr')
        ->setBody($mailContent)
    ;
    $this->get('mailer')->send($message);
    $request->getSession()->getFlashBag()->add('info', 'Email envoyé.');
    
    return $this->render('ozyxPlatformBundle:Advert:contactOk.html.twig', array(
        'mailContent' => $mailContent
    ));
    }

    return $this->render('ozyxPlatformBundle:Advert:contact.html.twig', array(
        'formBuilder' => $formBuilder->createView()
    ));
  }

  /**
   * @Security("has_role('ROLE_SUPER_ADMIN')")
   */
  public function editUserAction(Request $request)
  {
    $userManager = $this->get('fos_user.user_manager');
    //$user = new User();
    $formBuilder = $this->createForm(UserType::class);

    if ($formBuilder->handleRequest($request)->isValid()) {

      //Accès aux nom de l'utilisateur de l'objet user.
      //$accessor = PropertyAccess::createPropertyAccessor();

      $username = $formBuilder['user']->getData();
      //$username  = $accessor->getValue($formBuilder['user']->getData(), 'username');
      $userroles = array($formBuilder['roles']->getData());
      $usermail = $formBuilder['email']->getData();
      //$userroles = $formBuilder['roles']->getData();   
      $userpass = $formBuilder['password']->getData();


      //On hydrate puis enregistre l'objet user en question (L'entitymanager provoque le flush tout seul!)
      $user = $userManager->findUserBy(array('username' => $username));
      $user->setEmail($usermail);
      $user->setPlainPassword($userpass);
      $user->setRoles($userroles);
      $userManager->updateUser($user);

      $request->getSession()->getFlashBag()->add('info', 'Utilisateur modifié');
      return $this->redirect($this->generateUrl('ozyx_platform_editUser'));
    }

    return $this->render('ozyxPlatformBundle:Advert:userEdit.html.twig', array(
      'formBuilder' => $formBuilder->createView()));
  }

  public function cvAction()
   {
      $file = "bundles\ozyxplatform\pdf\cv.pdf";
      $response = new BinaryFileResponse($file);
      $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT);

      return $response;
   }

  public function fupAction(Request $request)
   {
    $file = file();
    $filesystem = $this->container->get('oneup_flysystem.local_filesystem');
    $formBuilder = $this->createForm(FileType::class);
   
    if ($formBuilder->handleRequest($request)->isValid()) {
      /*
      $file = new File();
      */
      //$uploadname = $formBuilder['filename']->getData();

      //$file = $request->files->get($uploadname);

      if ($file->isValid()) {
         $stream = fopen($file->getRealPath(), 'r+');
         $filesystem->writeStream('uploads/'.$file->getClientOriginalName(), $stream);
         fclose($stream);
      }
      $request->getSession()->getFlashBag()->add('info', 'Fichier envoyé');
      return $this->redirect($this->generateUrl('ozyx_platform_fup'));
    }

    return $this->render('ozyxPlatformBundle:Advert:fup.html.twig', array(
      'formBuilder' => $formBuilder->createView()));

   }

  /**
   * @Security("has_role('ROLE_AUTEUR')")
   */
  public function editImageAction($advertId)
  {
    $em = $this->getDoctrine()->getManager();

    // On récupère l'annonce
    $advert = $em->getRepository('ozyxPlatformBundle:Advert')->find($advertId);
    // On modifie l'URL de l'image par exemple
    $advert->getImage()->setUrl('test.png');
    // On déclenche la modification
    $em->flush();

    return new Response('OK');
  }
}