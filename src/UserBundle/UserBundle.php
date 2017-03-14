<?php

/**
 * Created by PhpStorm.
 * User: martin
 * Date: 14/03/2017
 * Time: 12:35
 */

namespace UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class UserBundle extends Bundle
{
  public function getParent()
  {
    return 'FOSUserBundle';
  }

}