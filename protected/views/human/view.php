<table>
    <tr>
        <td>First Name:</td>
        <td><?php echo !is_null($human->firstName) ? $human->firstName : '-' ?></td>
    </tr>
    <tr>
        <td>Last Name:</td>
        <td><?php echo !is_null($human->surname) ? $human->surname : '-' ?></td>
    </tr>
    <tr>
        <td><?php echo CHtml::link('Back', ['main/index']); ?></td>
        <td></td>
    </tr>
</table>