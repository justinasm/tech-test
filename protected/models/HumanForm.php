<?php

/**
 * HumanForm class.
 * HumanForm is the data structure for keeping human form data.
 */
class ContactForm extends CFormModel
{
    public $name;
    public $surname;

    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        return [
            ['firstname', 'surname', 'required'],
        ];
    }

    /**
     * Declares customized attribute labels.
     */
    public function attributeLabels()
    {
        return [
            'firstname' => 'First name',
            'surname'   => 'Last name',
        ];
    }
}