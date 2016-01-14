<?php $form = $this->beginWidget(
    'CActiveForm',
    [
        'id'                   => 'people-form',
        'htmlOptions'            => [
            //Disable normal form submit
            'onsubmit'   => "return false;",
            //Do ajax call when user presses enter key
            'onkeypress' => " if(event.keyCode == 13){ save(); } "
        ],
    ]
); ?>
<table>
    <tr>
        <th>First name</th>
        <th>Last name</th>
    </tr>
    <?php $this->renderPartial(
        '_human_fields',
        [
            'new'   => true,
            'key'   => 0,
        ]
    ); ?>
    <tr id="menu-row">
        <td><?php echo CHtml::button('+', ['onClick' => 'addMore()']) ?></td>
        <td><?php echo CHtml::submitButton('Save', ['onClick' => 'save()']); ?></td>
    </tr>
</table>
<input type="hidden" id="key" value="0">
<?php $this->endWidget(); ?>

<script>
    function addMore() {
        var key = $('#key').val();
        key++;
        $.ajax({
            type: 'POST',
            dataType: 'html',
            url: '<?php echo Yii::app()->createAbsoluteUrl("main/addmore"); ?>',
            data: {
                key: key
            },
            success: function(data) {
                if (data != '') {
                    $('#menu-row').before(data);
                }
            }
        });
        $('#key').val(key);
    }

    function save() {
        var data = $('#people-form').serialize();
        $.ajax({
            type: 'POST',
            dataType: 'html',
            data: data,
            url: '<?php echo Yii::app()->createAbsoluteUrl("main/updateform"); ?>',
            success: function(data) {
                console.log(data);
            }
        });
    }
</script>
