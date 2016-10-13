<?php
// src/ozyx/PlatformBundle/Antispam/ozyxClientdetect.php

namespace ozyx\PlatformBundle\Clientdetect;

use Symfony\Component\HttpFoundation\requestStack;
use Sinergi\BrowserDetector\Browser;
use Sinergi\BrowserDetector\Device;
use Sinergi\BrowserDetector\Os;

class ozyxClientdetect
{
  protected $requestStack;

  public function __construct(requestStack $requestStack)
  {
    $this->requestStack = $requestStack;
  }

  /**
   * Retourne les infos du client: Navigateur, Os, adresse IP etc.
   *
   * @return array $clientIp, $browser, $device, $os
   */
  public function clientInfo()
  {
    //On récupère l'IP et les infos sur le navigateur, le matériel et le système d'exploitation.
    $request  = $this->requestStack->getCurrentRequest();
    $clientIP = $request->getClientIp();
    $browser  = new Browser();
    $device   = new Device();
    $os       = new Os();

    //On récupére en string le nom et la version du navigateur.
    $browserN = $browser->getName();
    $browserV = $browser->getVersion();
    
    //On récupère le nom du matériel de on crée un variable bool à false si le matériel n'est pas reconnu.
    $deviceN = $device->getName();
    if ($deviceN === "unknown") {
      $deviceBool = false;
      $deviceN = "inconnu";
    }else{
      $deviceBool = true;
    }

    //On récupère le nom du système d'exploitation
    $osN = $os->getName();

    return array(
        'clientIP'   => $clientIP,
        'browserN'   => $browserN,
        'browserV'   => $browserV,
        'deviceN'    => $deviceN,
        'deviceBool' => $deviceBool,
        'osN'        => $osN
    );
  }
}

    /*
    $browserN = "";
    $browser = new Browser();
    $device = new Device();
    $os = new Os();

    $clientIP =  $request->getClientIp();

    $browserN .= "Vôtre IP: ";
    $browserN .= $clientIP;
    $browserN .= " / Vôtre navigateur: ";
    $browserN .= $browser->getName();
    $browserN .= " en version ";
    $browserN .= $browser->getVersion();
    
    $deviceKnown = $device->getName();
    if ($deviceKnown==="unknown") {
      $deviceKnown = "";
    }else{
      $browserN .= " / Votre appareil: ";
      $browserN .= $deviceKnown; 
    }

    $browserN .= " / Votre Système d'exploitation: ";
    $browserN .= $os->getName();
  Si safari choisir mp4, sinon webm
  */