<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Database\Type;

class ReservationsTable extends Table {
    public function initialize(array $config) {
         $this->addBehavior('Timestamp');
         $this->belongsTo('Users');
    }

    public function validationDefault(Validator $validator)
    {
        $validator
            ->notEmpty('user_id');

        $validator
            ->notEmpty('start_time');

        $validator
            ->notEmpty('end_time');

        $validator
            ->maxLength('body', 255)
            ->notEmpty('body');

        $validator
            ->add('start_time', 'existence', $this->timeRules())
            ->add('end_time', 'existence', $this->timeRules())
            ->add('end_time', 'comparison', $this->EndtimeIs());

        return $validator;
    }

    public function timeRules() {
        return [
            'rule' => function($value, $context) {

                $m = (int)$value['month'];
                $d = (int)$value['day'];
                $y = (int)$value['year'];

                if(!checkDate($m, $d, $y)){
                    return false;
                }
                return true;
            },
             'message' => __('there is no date')
        ];
    }

    public function EndtimeIs() {
        return [
            'rule' => function($value, $data){
                    //終了日が開始日より前になっていないかチェック
                    $end = new \Datetime(implode($value));
                    $start = new \Datetime(implode($data['data']['start_time']));
                    return $start < $end;
             },
             'message' => __('End time is after start time')
         ];
     }
    public function statisticReservations($data)
    {
        $hoursList = $this->__createHoursList($data);
        $initNumber = array_fill_keys($hoursList, 0);

        //start_time
        $query = $this->find()->where(['date(start_time)' => $data['date']]);

        $query->enableHydration(false);

        $startNum = $query->select([
            'count' => $query->func()->count('id'),
            'start_hour' => 'DATE_FORMAT(start_time, "%Y-%m-%d-%h")'
        ])
        ->group('DATE_FORMAT(start_time, "%Y-%m-%d-%h")');

        $sumStartNum = $startNum->combine('start_hour', 'count', function() use($data){
            return $data['date'];
        })
        ->map(function($value, $key){
            return array_sum($value);
        })->toArray();

        $startNum = $startNum->combine('start_hour', 'count', function() {
            return 'start';
        })->toArray();

        if(empty($startNum)){
            $startNum = ['start' => 0];
            $startNum['start'] = $initNumber;
        }else {
            $startNum['start'] += $initNumber;
        }

        //end_time
        $query = $this->find()->where(['date(end_time)' => $data['date']]);

        $endNum = $query->select([
            'count' => $query->func()->count('id'),
            'end_hour' => 'DATE_FORMAT(end_time, "%Y-%m-%d-%h")'
        ])
        ->group('DATE_FORMAT(end_time, "%Y-%m-%d-%h")');

        $sumEndNum = $endNum->combine('end_hour', 'count', function() use($data){
            return $data['date'];
        })
        ->map(function($value, $key){
            return array_sum($value);
        })->toArray();

        $endNum = $endNum->combine('end_hour', 'count', function() {
            return 'end';
        })->toArray();

        if(empty($endNum)){
            $endNum = ['end' => 0];
            $endNum['end'] = $initNumber;
        }else {
            $endNum['end'] += $initNumber;
        }

        $result = compact('startNum', 'sumStartNum', 'endNum', 'sumEndNum', 'data', 'initNumber', 'hoursList');

        return $result;
    }

    public function statisticLength($data)
    {
        $hoursList = $this->__createHoursList();
        $monthList = $this->__createMonthList($data);
        $initMonthList = array_fill_keys($monthList, 0);
        $initHours = array_fill_keys($hoursList, 0);
        $init = $initHours;

        $from = $data['from'];
        $to =  $data['to'];
        $fromMonth = substr($from,0,7);

        $query = $this->__createQuery($from, $to, $fromMonth);

        $length = 'if
        (
            MAKETIME(
                hour(
                    TIMEDIFF(
                        end_time, start_time
                    )
                ),0,0
            )
            < TIMEDIFF(
                end_time, start_time
            ),
            hour(
                TIMEDIFF(end_time, start_time)
                )+1,
            hour(
                TIMEDIFF(end_time, start_time)
                )
        )';


        $query->select([
            'start' => 'DATE_FORMAT(start_time, "%Y-%m")',
            'count' => 'COUNT(id)',
            'length' => $length
        ])
        ->group($length)
        ->group( 'DATE_FORMAT(start_time, "%Y-%m")');


        $lengthMonth = $query->combine('length', 'count', 'start')
        ->map(function($value, $key) use($initHours) {
            return $value + $initHours;
        })->toArray();

        $lenghNumber = $query->combine('start', 'count', 'length')
        ->map(function($value, $key) use($initMonthList) {
            return $value + $initMonthList;
        })->toArray();

        foreach ($init as $key => $value) {
            $init[$key] = $initMonthList;
        }
        $lenghNumber += $init;

        //create over24h
        $over24 = $query->andWhere([
            "hour(TIMEDIFF(end_time, start_time)) > '24'",
            "hour(TIMEDIFF(end_time, start_time)) < '48'"
        ]);
        $over24 =$over24->combine('start', 'count')->toArray();


        //create over48h
        $query = $this->__createQuery($from, $to, $fromMonth);
        $query->select([
            'start' => 'DATE_FORMAT(start_time, "%Y-%m")',
            'count' => 'COUNT(id)'
        ])
        ->group('start');

        $over48 = $query->andWhere([
            "hour(TIMEDIFF(end_time, start_time)) >= '48'"
        ]);
        $over48 = $over48->combine('start', 'count')->toArray();

        //total by hour
        $query = $this->__createQuery($from, $to, $fromMonth);
        $query->select([
            'count' => 'COUNT(id)',
            'length' => $length
        ])
        ->group($length);

        $totalByHour = $query->combine('length', 'count')->toArray() + $initHours;

        $result = compact('lengthMonth','lenghNumber', 'hoursList', 'monthList', 'over24', 'over48', 'totalByHour');
        return $result;
    }

    public function __createMonthList($data) {
        $from = $data['from'];
        $to = $data['to'];
        $from = substr($from,0,7);
        $to = substr($to,0,7);

        $list = [$from];
        $count = (strtotime($to) - strtotime($from)) / (60 * 60 * 24 * 30) -1 ;
        for($i=0;$i<$count;$i++) {
            $from = date("Y-m", strtotime($from . "+1 month"));
            $list[] = $from;
        }
        return $list;
    }

    public function __createQuery($from, $to, $fromMonth) {

        $query = $this->find()->where(
            ['or' => [
                "DATE(start_time) BETWEEN '$from' AND '$to'",
                "DATE(end_time) BETWEEN '$from' AND '$to'",
            ]]
        );
        //calculate hours by start month
        $query->where(["DATE_FORMAT(start_time, '%Y-%m') >= '{$fromMonth}'"]);

        $query->enableHydration(false);

        return $query;
    }
    public function __createHoursList($data = null)
    {
        $hoursList = [];
        if(empty($data)) {
            for($i=1;$i<=24;$i++) {
                $hoursList[] = $i;
            }
            return $hoursList;
        }
        $day = $data['date'];
        for($i=1;$i<=24;$i++) {
            $hoursList[] = ($i > 9) ? $day.'-'.$i : $day.'-0'.$i;
        }
        return $hoursList;
    }
}
