<?php

use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Regex;
use Phalcon\Validation\Validator\InclusionIn;

class Patients extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $name;

    /**
     *
     * @var string
     */
    public $sex;

    /**
     *
     * @var string
     */
    public $religion;

    /**
     *
     * @var string
     */
    public $phone;

    /**
     *
     * @var string
     */
    public $address;

    /**
     *
     * @var string
     */
    public $nik;

    /**
     * Initialize method for model.
     */

    
    public function validation()
    {
        $validator = new Validation();

        // Validasi keberadaan nama
        $validator->add(
            'name',
            new PresenceOf(
                [
                    'message' => 'The name is required',
                ]
            )
        );

        $validator->add(
            "sex",
            new InclusionIn(
                [
                    'message' => 'Sex must be "male" or "female"',
                    'domain' => [
                        'male',
                        'female',
                    ],
                ]
            )
        );

        $validator->add(
            'religion',
            new PresenceOf(
                [
                    'message' => 'The religion is required',
                ]
            )
        );
        
        $validator->add(
            'nik',
            new PresenceOf(
                [
                    'message' => 'The nik is required',
                ]
            )
        );

        $validator->add(
            'address',
            new PresenceOf(
                [
                    'message' => 'The address is required',
                ]
            )
        );

        // Validasi format nomor telepon
        $validator->add(
            'phone',
            new Regex(
                [
                    'pattern' => '/^[0-9]{10,}$/',
                    'message' => 'Invalid phone number format (minimum 10 digits)',
                ]
            )
        );

        return $this->validate($validator);
    }

    public function initialize()
    {
        $this->setSchema("hospital");
        $this->setSource("patients");
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Patients[]|Patients|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Patients|\Phalcon\Mvc\Model\ResultInterface|\Phalcon\Mvc\ModelInterface|null
     */
    public static function findFirst($parameters = null): ?\Phalcon\Mvc\ModelInterface
    {
        return parent::findFirst($parameters);
    }

}
