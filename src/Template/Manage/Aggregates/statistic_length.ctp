<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/themes/base/jquery-ui.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/i18n/jquery-ui-i18n.min.js"></script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/i18n/jquery.ui.datepicker-ja.js"></script>

<script>
$(function() {
    $.datepicker._gotoToday = function(id) {
        var target = $(id);
        var inst = this._getInst(target[0]);
        var date = new Date();
        this._setDate(inst,date);
        this._hideDatepicker();
    }
    var dateFormat = "yy-mm-dd",
        from = $( "#datepicker-from" )
        .datepicker({
            language: 'ja',
            showButtonPanel:true,
            dateFormat:"yy-mm-dd",
            defaultDate: "+1w",
            changeYear:true,
            changeMonth: true,
            numberOfMonths: 3
        })
        .on( "change", function() {
            to.datepicker( "option", "minDate", getDate( this ) );
        }),
        to = $( "#datepicker-to" ).datepicker({
            language: 'ja',
            showButtonPanel:true,
            dateFormat:"yy-mm-dd",
            defaultDate: "+1w",
            changeYear:true,
            changeMonth: true,
            numberOfMonths: 3
        })
        .on( "change", function() {
            from.datepicker( "option", "maxDate", getDate( this ) );
        });

    function getDate( element ) {
      var date;
      try {
        date = $.datepicker.parseDate( dateFormat, element.value );
      } catch( error ) {
        date = null;
      }
      return date;
    }
});
</script>

<style type="text/css">
.ui-datepicker .ui-datepicker-buttonpane button.ui-datepicker-current {
    background: #ededed;
    color: #2b2b2b;
}
</style>

<?php
    echo $this->Form->create();
    echo $this->Form->label('日付');
    echo $this->Form->control('from', ['id'=>'datepicker-from']);
    echo $this->Form->control('to', ['id'=>'datepicker-to']);
    echo $this->Form->button(__('Search'), ['class' => 'btn btn-info']);
    echo $this->Form->end();

    if(isset($result)){
        $hoursList = $result['hoursList'];
        $lengthMonth = $result['lengthMonth'];
        $monthList = $result['monthList'];
        $over24 = $result['over24'];
        $over48 = $result['over48'];
        $totalByHour = $result['totalByHour'];
        $totalMonth = 0;
        $total = [];
        foreach($lengthMonth as $month=>$data) {
            $total[] = $month;
        }
        $totalOver24 = array_sum($over24);
        $totalOver48 = array_sum($over48);
    }
?>

<?php if(isset($result)): ?>
    <table class="table table-hover table-bordered table-striped">
        <thead>
            <tr>
                <th>&emsp;&emsp;&emsp;</th>
                <th></th>
                <th colspan="28">予約時間の長さ</th>
                <th>合計</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>年月</td>
                <td></td>

                <?php for($i=0;$i<24;$i++): ?>
                    <td><?= $i+1 ?>h</td>
                <?php endfor ;?>
                <td></td>
                <td>1日以上</td>
                <td>2日以上</td>
                <td></td>
                <td></td>
            </tr>
            <?php foreach($monthList as $month):?>
                <?php $totalHour = 0 ?>
                <?php $totalOver = 0 ?>
                <tr>
                    <td><?= $month ?>月</td>
                    <td></td>
                    <?php foreach($hoursList as $hour): ?>
                        <?php if(isset($lengthMonth[$month])): ?>
                            <td><?= $num = $lengthMonth[$month][$hour] ?></td>
                            <?php $totalHour += $num ?>
                        <?php else:?>
                            <td><?= 0 ?></td>
                        <?php endif;?>
                    <?php endforeach;?>
                    <td></td>

                    <?php if(isset($over24[$month])): ?>
                        <td><?= $num = $over24[$month]?></td>
                        <?php $totalOver += $num ?>
                    <?php else:?>
                        <td><?= 0 ?></td>
                    <?php endif;?>

                    <?php if(isset($over48[$month])): ?>
                        <td><?= $num = $over48[$month]?></td>
                        <?php $totalOver += $num ?>
                    <?php else:?>
                        <td><?= 0 ?></td>
                    <?php endif;?>

                    <td></td>
                    <td><?= $totalHour + $totalOver?></td>
                    <?php $totalMonth += $totalHour + $totalOver?>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td></td>
                <td></td>
                <?php for($i=0;$i<25;$i++): ?>
                    <td></td>
                <?php endfor ;?>

                <td></td>
            </tr>
            <tr>
                <td>合計数</td>
                <td></td>
                <?php foreach ($hoursList as $hours):?>
                    <td><?= $totalByHour[$hours] ?></td>
                <?php endforeach; ?>

                <td></td>
                <td><?= $totalOver24 ?></td>
                <td><?= $totalOver48 ?></td>
                <td></td>
                <td><?= $totalMonth ?></td>
            </tr>

        </tbody>
    </table>
<?php endif ;?>
<?php if(!isset($result)): ?>
    <table class="table table-hover table-bordered table-striped">
        <thead>
            <tr>
                <th>&emsp;&emsp;&emsp;</th>
                <th></th>
                <th colspan="28">予約時間の長さ</th>
                <th>合計</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>年月</td>
                <td></td>

                <?php for($i=0;$i<24;$i++): ?>
                    <td><?= $i+1 ?>h</td>
                <?php endfor ;?>
                <td></td>
                <td>1日以上</td>
                <td>2日以上</td>
                <td></td>
                <td></td>
            </tr>
            <?php for($i=0;$i<2;$i++):?>
                <tr>
                    <td>○年○月</td>
                    <td></td>
                    <?php for($j=0;$j<24;$j++):?>
                        <td>*</td>
                    <?php endfor;?>
                    <td></td>
                    <td>☆</td>
                    <td>☆</td>
                    <td></td>
                    <td>*</td>
                </tr>
            <?php endfor; ?>
            <tr>
                <td></td>
                <td></td>
                <?php for($i=0;$i<25;$i++): ?>
                    <td></td>
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
                <td>☆</td>
                <td>☆</td>
                <td></td>
                <td>*</td>
            </tr>

        </tbody>
    </table>
<?php endif ;?>
