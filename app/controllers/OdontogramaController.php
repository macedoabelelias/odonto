<?php

class OdontogramaController extends Controller
{

    public function index($paciente_id = null)
    {

        $dados = [];

        $this->view('odontograma/index', $dados);

    }

}