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
<div id="errors">
    <?php foreach ($errors as $error) {
        echo '<p>' . $error . '</p>';
    }
    ?>
</div>
<table>
    <tr>
        <th>First name</th>
        <th>Last name</th>
    </tr>
    <?php if (isset($people) && $people) { ?>
        <?php foreach ($people as $human) {
            $this->renderPartial(
                '_human_fields',
                [
                    'new'     => false,
                    'key'     => $human->id,
                    'name'    => $human->firstName,
                    'surname' => $human->surname,
                    'id'      => $human->id,
                ]
            );
         } ?>
    <?php } ?>
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
        if (validatePeopleForm()) {
            var data = $('#people-form').serialize();
            $.ajax({
                type: 'POST',
                dataType: 'html',
                data: data,
                url: '<?php echo Yii::app()->createAbsoluteUrl("main/updateform"); ?>',
                success: function(data) {
                    $('body').html('');
                    $('body').append(data);
                }
            });
        }
    }

    function validatePeopleForm()
    {
        $('#errors').html('');
        var errors = 0;

        $('#people-form .human-row').each(function() {
            if (!$(this).hasClass('new-human')) {
                $('input[type=text]').each(function() {
                    if (!$(this).val().match(/^[a-zA-Z\s]+$/) && $(this).val() != '') {

                        errors++;
                    }
                });
            }
        });

        if (errors > 0) {
            $('#errors').append('<p>Names must contain only letters.</p>');

            return false;
        } else {

            return true;
        }
    }

    function removeRow(id, elementName) {
        if (id > 0) {
            $.ajax({
                type: 'POST',
                dataType: 'html',
                data: {
                    id: id
                },
                url: '<?php echo Yii::app()->createAbsoluteUrl("human/remove"); ?>',
                success: function(data) {

                }
            });
        }

        $('#row-'+elementName).remove();
    }
</script>
