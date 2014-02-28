<?php
/**
 * Created by PhpStorm.
 * User: jmeuriss
 * Date: 27/02/14
 * Time: 8:56
 */

namespace JrmUnamur\CobraBundle\Lib;


class CobraRemoteException extends \Exception
{
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
