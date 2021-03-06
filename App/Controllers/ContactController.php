<?php

namespace App\Controllers;

use App\Interfaces\TreatmentsInterface;

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
    }
}
