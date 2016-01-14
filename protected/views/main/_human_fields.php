<tr>
    <td>
        <?php echo CHtml::textField(
            (($new == 1) ? 'new-' : '') . 'people[' . $key . '][firstName]',
            '',
            ['class' => ($new) ? 'new-row' : '']
        ); ?>
    </td>
    <td>
        <?php echo CHtml::textField(
            (($new == 1) ? 'new-' : '') . 'people[' . $key . '][surname]',
            '',
            ['class' => ($new) ? 'new-row' : '']
        ); ?>
    </td>
</tr>