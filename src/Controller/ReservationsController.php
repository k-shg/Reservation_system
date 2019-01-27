<?php

namespace App\Controller;
use App\Controller\AppController;
use App\Model\Entity\User;
use DateTime;
class ReservationsController extends AppController {

    public function index()
    {
        $this->loadComponent('Paginator');
        $reservations = $this->Reservations->find()->where(['user_id' => $this->Auth->user('id')]);
        $reservations = $this->Paginator->paginate($reservations);
        $reservations = $this->__createColorTable($reservations);
        $this->set(compact('reservations'));
    }

    public function view($id = null)
    {
        $reservation = $this->Reservations->findById($id)->firstOrFail();
        $this->set(compact('reservation'));
    }

    public function add()
    {
        $reservation = $this->Reservations->newEntity();

        if ($this->request->is('post')) {
            $reservation = $this->Reservations->patchEntity($reservation, $this->request->getData());
            $reservation->user_id = $this->Auth->user('id');

            if ($this->Reservations->save($reservation)) {
                $this->Flash->success(__('Your reservation has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add your reservation.'));
        }
        $this->set(compact('reservation'));
    }

    public function edit($id)
    {
        $reservation = $this->Reservations->findById($id)->firstOrFail();
        if ($this->request->is(['post', 'put'])) {
            $this->Reservations->patchEntity($reservation, $this->request->getData());

            if ($this->Reservations->save($reservation)) {
                $this->Flash->success(__('Your Reservation has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to update your Reservation.'));
        }
        $this->set(compact('reservation'));
    }

    public function delete($id)
    {
        $this->request->allowMethod(['post', 'delete']);
        $reservation = $this->Reservations->findById($id)->firstOrFail();
        if ($this->Reservations->delete($reservation)) {
            $this->Flash->success(__('The {0} reservation has been deleted.', $reservation->id));
            return $this->redirect(['action' => 'index']);
        }
    }

    public function __createColorTable($reservations)
    {
        $now = new DateTime('now');

        foreach ($reservations as $reservation) {
            $reservation->isColor = false;
            //予約終了時間と現在時刻を比較
            if ($reservation->end_time < $now) {
                $reservation->isColor = true;
            }
        }
        return $reservations;
    }
}
