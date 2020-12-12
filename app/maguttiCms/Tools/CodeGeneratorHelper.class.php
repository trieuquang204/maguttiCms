<?php namespace App\maguttiCms\Tools;



/**
 * Class Setting
 * @package App\maguttiCms\Tools
 */
class CodeGeneratorHelper
{


    protected $use_lowercase = false;
    protected $use_uppercase = false;
    protected $use_numbers = false;
    protected $use_specials = false;
    protected $options = [];

    /**
     * CodeGeneratorHelper constructor.
     */
    public function __construct()
    {

    }


    function defineType($type = '')
    {

        switch ($type) {
            case 'number':
                return $this->setUseNumbers(true);
                break;
            case 'alpha_num':
                $this->setUseNumbers(true)->setUseUppercase(true)->setUseLowercase(true);
                break;
            case 'alpha_num_uppercase':
                $this->setUseNumbers(true)->setUseUppercase(true);;
                break;
            case 'string':
                $this->setUseUppercase(true)->setUseLowercase(true);;
                break;
            case 'string_uppercase':
                $this->setUseUppercase(true);;
                break;
            case 'password':
                $this->setUseNumbers(true)
                    ->setUseUppercase(true)
                    ->setUseLowercase(true)
                    ->setUseSpecials(true);
            default :
                $this->setUseNumbers(true)->setUseUppercase(true);
        }

        return $this;
    }

    public function generateToken($length = 10)
    {


        $letters = 'abcdefghijklmnopqrstuvwxyz';
        $numbers = '0123456789';
        $specials = '!?$*#^-_~()[]{}.,:;<>&%@';

        $dictionary = '';

        $pass = '';
        // required characters and compile full dictionary
        if ($this->use_lowercase) {
            $pass .= $letters[random_int(0, strlen($letters) - 1)];
            $dictionary .= $letters;
        }
        if ($this->use_uppercase) {
            $pass .= strtoupper($letters[random_int(0, strlen($letters) - 1)]);
            $dictionary .= strtoupper($letters);
        }
        if ($this->use_numbers) {
            $pass .= $numbers[random_int(0, strlen($numbers) - 1)];
            $dictionary .= $numbers;
        }
        if ($this->use_specials) {
            $pass .= $specials[random_int(0, strlen($specials) - 1)];
            $dictionary .= $specials;
        }

        // complete the password
        for ($i = strlen($pass); $i < $length; $i++){
            $pass .= $dictionary[random_int(0, strlen($dictionary) - 1)];
        }
        // shuffle the result
        $pass = str_shuffle($pass);
        return $pass;
    }

    /**
     * @return mixed
     */
    function useModelGenerator()
    {
        $model = getModelFromString($this->options['model']);
        return (new $model)->{$this->options['generator']}();
    }

    /**
     * @param $token
     * @return mixed
     */
    function ckIfExist($token)
    {
        $model = getModelFromString($this->options['model']);
        return (new $model)->find($token, $this->options['field']);
    }

    /**
     * @param $options
     * @param string $prefix
     * @return string
     */
    function handleGenerator($options, $prefix = '')
    {
        $this->options = $options;
        if (data_get($this->options, 'generator')) {
            $token = $this->useModelGenerator();
        } else {
            $token = $this->defineType(data_get($this->options, 'type'))->generateToken($this->options['length']);
        }
        return $this->validateToken($token, $prefix);

    }

    /**
     * @param $token
     * @param $prefix
     * @return string
     */
    function validateToken($token, $prefix)
    {
        $token = (data_get($this->options, 'usePrefix')) ? $prefix . $token : $token;
        if (data_get($this->options, 'unique') && $this->ckIfExist($token)) {
            $this->handleGenerator($this->options, $prefix);
        };
        return $token;
    }


    /**
     * @return bool
     */
    public function isUseLowercase(): bool
    {
        return $this->use_lowercase;
    }

    /**
     * @param bool $use_lowercase
     * @return CodeGeneratorHelper
     */
    public function setUseLowercase(bool $use_lowercase): CodeGeneratorHelper
    {
        $this->use_lowercase = $use_lowercase;
        return $this;
    }

    /**
     * @return bool
     */
    public function isUseUppercase(): bool
    {
        return $this->use_uppercase;
    }

    /**
     * @param bool $use_uppercase
     * @return CodeGeneratorHelper
     */
    public function setUseUppercase(bool $use_uppercase): CodeGeneratorHelper
    {
        $this->use_uppercase = $use_uppercase;
        return $this;
    }

    /**
     * @return bool
     */
    public function isUseNumbers(): bool
    {
        return $this->use_numbers;
    }

    /**
     * @param bool $use_numbers
     * @return CodeGeneratorHelper
     */
    public function setUseNumbers(bool $use_numbers): CodeGeneratorHelper
    {
        $this->use_numbers = $use_numbers;
        return $this;
    }

    /**
     * @return bool
     */
    public function isUseSpecials(): bool
    {
        return $this->use_specials;
    }

    /**
     * @param bool $use_specials
     * @return CodeGeneratorHelper
     */
    public function setUseSpecials(bool $use_specials): CodeGeneratorHelper
    {
        $this->use_specials = $use_specials;
        return $this;
    }


}
