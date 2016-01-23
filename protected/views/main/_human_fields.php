<tr id="row-<?php echo (isset($id) ? $id : '') . (($new == 1) ? 'new-' : '') . $key; ?>">
    <td>
        <?php echo isset($id) ? CHtml::hiddenField('people[' . $key . '][id]', $id) : ''; ?>
        <?php echo CHtml::textField(
            (($new == 1) ? 'new-' : '') . 'people[' . $key . '][firstName]',
            isset($name) ? $name : '',
            ['class' => ($new) ? 'new-row' : '']
        ); ?>
    </td>
    <td>
        <?php echo CHtml::textField(
            (($new == 1) ? 'new-' : '') . 'people[' . $key . '][surname]',
            isset($surname) ? $surname : '',
            ['class' => ($new) ? 'new-row' : '']
        ); ?>
    </td>
    <td>
        <?php echo isset($id) ? CHtml::link(
            'View',
            ['human/view', 'id' => $id]
        ) : ''; ?>
    </td>
    <td>
        <?php echo CHtml::button(
            'Remove',
            ['onClick' => "removeRow(" . (isset($id) ? $id : 0) . ", '" . (isset($id) ? $id : '') . (($new == 1) ? 'new-' : '') . $key . "')"]
        ); ?>
    </td>
</tr>