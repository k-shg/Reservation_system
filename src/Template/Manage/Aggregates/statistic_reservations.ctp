<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/themes/base/jquery-ui.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

<script>
$(function() {
 	$('#datepicker').datepicker({
        showButtonPanel:true,
        changeYear:true,
        changeMonth: true,
        dateFormat:"yy-mm-dd"
    });
});
</script>

<div class="col-md-12">
    <?php
    echo $this->Form->create();
    echo $this->Form->label('日付');
    echo $this->Form->control('date', ['id'=>'datepicker']);
    echo $this->Form->button(__('Search'), ['class' => 'btn btn-info']);
    echo $this->Form->end();

    if(isset($result)){
        $start = $result['startNum']['start'];
        $sumStartNum = $result['sumStartNum'];
        $end = $result['endNum']['end'];
        $sumEndNum = $result['sumEndNum'];
        $date = $result['data']['date'];
        $initNumber = $result['initNumber'];
        $hoursList = $result['hoursList'];
        $hourTatal = 0;
        $res = [];
        $totalNumber = $initNumber;
        foreach($totalNumber as $hour=>$value) {
            $totalNumber[$hour] = $start[$hour] + $end[$hour];
        }
    }
?>

<?php if(isset($result)): ?>
    <table class="table table-hover table-bordered table-striped">
        <thead>
            <tr>
                <th>&emsp;&emsp;&emsp;</th>
                <th></th>
                <th colspan="24">予約時間</th>
                <th>合計</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td></td>
                <td></td>
                <?php for($i=0;$i<24;$i++): ?>
                    <td><?= $i+1 ?>時</td>
                <?php endfor ;?>
                <td></td>
            </tr>
            <tr>
                <td>開始数</td>
                <td></td>
                <?php foreach($hoursList as $hour): ?>
                    <td><?= $start[$hour] ?> </td>
                <?php endforeach;?>
                <td><?= (!empty($sumStartNum)) ? $total = $sumStartNum[$date]: 0; ?></td>
            </tr>
            <tr>
                <td>終了数</td>
                <td></td>
                <?php foreach($hoursList as $hour): ?>
                    <td><?= $end[$hour] ?> </td>
                <?php endforeach;?>
                <td><?= (!empty($sumEndNum)) ? $sumEndNum[$date]: 0; ?></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <?php for($i=0;$i<24;$i++): ?>
                    <td></td>
                <?php endfor ;?>
                <td></td>
            </tr>
            <tr>
                <td>合計数</td>
                <td></td>
                <?php foreach($totalNumber as $num): ?>
                    <td><?= $num ?></td>
                <?php endforeach;?>
                <td><?= array_sum($totalNumber) ?></td>
            </tr>

        </tbody>
    </table>
</div>
<?php endif ;?>
<?php if(!isset($result)): ?>
<table class="table table-hover table-bordered table-striped">
    <thead>
        <tr>
            <th>&emsp;&emsp;&emsp;</th>
            <th></th>
            <th colspan="24">予約時間</th>
            <th>合計</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td></td>
            <td></td>

            <?php for($i=0;$i<24;$i++): ?>
                <td><?= $i+1 ?>時</td>
            <?php endfor ;?>
            <td></td>
        </tr>
        <tr>
            <td>開始数</td>
            <td></td>
            <?php for($i=0;$i<24;$i++): ?>
                <td>*</td>
            <?php endfor ;?>

            <td></td>
        </tr>
        <tr>
            <td>終了数</td>
            <td></td>
            <?php for($i=0;$i<24;$i++): ?>
                <td>*</td>
            <?php endfor ;?>
            <td></td>
        </tr>
        <tr>
            <td>合計数</td>
            <td></td>
            <?php for($i=0;$i<24;$i++): ?>
                <td>*</td>
            <?php endfor ;?>
            <td></td>
        </tr>
    </tbody>
</table>
<?php endif ;?>
