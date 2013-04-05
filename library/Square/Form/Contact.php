<?php

class Square_Form_Contact extends Zend_Form
{
    
    public $formDecoraters = array(
                    array('FormElements'),
                    array('Form'),
                    array('HtmlTag', array('tag' => 'div'))
            );
    
    public $elementDecorators = array(
                array('ViewHelper'),
                array('Label'),
                array('Errors'),
                array('HtmlTag', array('tag' =>'p'))
            );

    public $buttonDecorators = array(
                array('ViewHelper'),
                array('HtmlTag', array('tag' => 'p'))
            );

    
    
    public function init()
    {
        // initialize form
        $this->setAction('/contact/index')
        ->setMethod('post')
        ->setDecorators($this->formDecoraters);

        // create text input for name
        $name = new Zend_Form_Element_Text('name');
        $name->setLabel('Name:')
            ->setOptions(array('size' => '35'))
            ->setRequired(true)
            ->addValidator('NotEmpty', true, array('messages' => "Name Cannot be Empty"))
            ->addValidator('Alpha', true, array(
                                'messages' => array(
                                    Zend_Validate_Alpha::INVALID
                                    => "ERROR: Invalid name",
                                    Zend_Validate_Alpha::NOT_ALPHA
                                    => "ERROR: Name cannot contain non-alpha characters",
                                    Zend_Validate_Alpha::STRING_EMPTY
                                    => "ERROR: Name cannot be empty"
                                )
                        ))
            //->addFilter('HTMLEntities')
            ->addFilter('StringTrim')
            ->setDecorators($this->elementDecorators);


        // create text input for email address
        $email = new Zend_Form_Element_Text('email');
        $email->setLabel('Email address:');
        $email->setOptions(array('size' => '50'))
                ->setRequired(true)
                ->addValidator('NotEmpty', true)
                ->addValidator('EmailAddress', true, array(
                                    'messages' => array(
                                    Zend_Validate_EmailAddress::INVALID
                                    => "Error: Invalid Email Address",
                                    Zend_Validate_EmailAddress::INVALID_FORMAT
                                    => "Error: Invalid Format"

                                            )

                                    ))
              //  ->addFilter('HTMLEntities')
                ->addFilter('StringToLower')
                ->addFilter('StringTrim')
                ->setDecorators($this->elementDecorators);


        // create text input for message body
        $message = new Zend_Form_Element_Textarea('message');
        $message->setLabel('Message:')
                ->setOptions(array('rows' => '8','cols' => '40'))
                ->setRequired(true)
                ->addValidator('NotEmpty', true)
             //   ->addFilter('HTMLEntities')
                ->addFilter('StringTrim')
                ->setDecorators($this->elementDecorators);


        // create captcha
      /*  $captcha = new Zend_Form_Element_Captcha('captcha', array(
                                            'captcha' => array(
                                            'captcha' => 'Image',
                                            'wordLen' => 6,
                                            'timeout' => 300,
                                            'width'   => 300,
                                            'height'  => 100,
                                            'imgUrl'  => '/captcha',
                                            'imgDir'  => APPLICATION_PATH . '/../public/captcha',
                                            'font'    => APPLICATION_PATH . '/../public/fonts/AdobeGothicStd-Bold.otf',

                                            )
                                        ));
        $captcha->setLabel('Verification code:');
        */

        //create captcha
            $captcha = new Zend_Form_Element_Captcha('captcha', array(
                                            'captcha' => array(
                                            'captcha' => 'Figlet',
                                            'timeout' => 300,
                                            'width'   => 300,
                                            'height'  => 100,

                                            )
                                        ));


        // create submit button
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Send Message')
                ->setOptions(array('class' => 'submit'))
                ->setDecorators($this->buttonDecorators);


        // attach elements to form
        $this->addElement($name)
            ->addElement($email)
            ->addElement($message)
            ->addElement($captcha);

        // add display group
        $this->addDisplayGroup(array('name', 'email', 'message','captcha'), 'feedback');

        $this->getDisplayGroup('feedback')
            ->setLegend('Feedback Information');

        $this->addElement($submit);
    }
}
