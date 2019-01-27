<?php

namespace App\Controller\Manage;
use App\Controller\Manage\AppController;
use Cake\I18n\Time;
use DateTime;
use Cake\Http\Session;
use Cake\Collection\Collection;

class ReservationsController extends AppController {

    public $paginate = [
        'order' => [
            'Reservations.sort_order' => 'asc',
        ]
    ];

    public function index()
    {
        if ($this->request->is(['post', 'put'])) {
            $user_id = $this->request->getData('user_id');
            if ($user_id) {
                $reservations = $this->Reservations->find()->contain('Users')->where(['user_id' => $user_id]);
            } else {
                $reservations = $this->Reservations->find()->contain('Users');
            }
        } else {
            $reservations = $this->Reservations->find()->contain('Users');
        }
        $reservations = $this->paginate($reservations);
        $reservations = $this->__createColorTable($reservations);
        $users = $this->Reservations->Users->find('list');
        $this->set(compact('reservations', 'users'));
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
        $users = $this->Reservations->Users->find('list')->toArray();
        $this->set('reservation', $reservation);
        $this->set(compact('users'));
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
        $users = $this->Reservations->Users->find('list');
        $this->set(compact('users', 'reservation'));
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
            if($reservation->end_time < $now) {
                $reservation->isColor = true;
            }
        }
        return $reservations;
    }

    public function saveOrder() {
        $this->autoRender = false;
        $reservations = $this->Reservations->find();
        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->getData();
            $data = json_decode($data['sort_order_json'], true);

            $data = new Collection($data);
            $data = $data->map(function($value, $key) {
                $value['sort_order'] = $key + 1;
                return $value;
            })->toArray();

            $reservations = $this->Reservations->patchEntities($reservations, $data, ['fieldList' => ['sort_order']]);

            if($this->Reservations->saveMany($reservations)) {
                $this->Flash->success(__('Your Reservation has been updated.'));
            } else {
                foreach($reservations as $reservation) {
                    //ここにエラーメッセージを表示
                }
                $this->Flash->error(__('Unable to update your Reservation.'));
            }
        }
        return $this->redirect(['action' => 'index']);
    }
}
