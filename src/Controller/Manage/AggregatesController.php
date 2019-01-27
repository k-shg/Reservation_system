<?php
namespace App\Controller\Manage;
use App\Controller\Manage\AppController;
use App\Model\Entity\User;


class AggregatesController extends AppController
{
    public function index()
    {

    }

    public function statisticReservations()
    {
        if($this->request->is(['post', 'put'])) {
            $data = $this->request->getData();
            $this->loadModel('Reservations');
            $result = $this->Reservations->statisticReservations($data);
        }
        $this->set(compact('result'));
    }

    public function statisticLength()
    {
        if($this->request->is(['post', 'put'])) {
            $data = $this->request->getData();
            $this->loadModel('Reservations');
            $result = $this->Reservations->statisticLength($data);
        }
        $this->set(compact('result'));
    }
}
