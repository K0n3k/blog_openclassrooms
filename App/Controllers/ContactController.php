<?php

namespace App\Controllers;

use App\Interfaces\TreatmentsInterface;
use App\Services\MyMailer;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email; 
class ContactController extends Controller implements TreatmentsInterface {

    public function __construct(protected array $parameters)
    {
        parent::__construct($parameters);

        $this->twigFile = 'Public' . DIRECTORY_SEPARATOR . "Contact.twig";

        $this->parameters["method"] === "GET" ? $this->getTreatment() : $this->postTreatment();
    }

    public function getTreatment() : void
    {
        $this->render($this->twigFile);
    }

    public function postTreatment(): void
    {
        // send email

        $mail = new MyMailer(
            new Address($this->cleanData($this->parameters['post']['emailAdress'])),
            $this->cleanData($this->parameters['post']['subject']),
            $this->cleanData($this->parameters['post']['content'])
        );
    }
}
