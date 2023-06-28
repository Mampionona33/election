<?php

namespace controller;

use model\CandidatModel;

class CandidatController
{
    private $candidatModel;
    public function __construct()
    {
        $this->candidatModel = new CandidatModel;
    }
}
