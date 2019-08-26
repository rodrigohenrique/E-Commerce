<?php

namespace Hcode;

use Rain\Tpl;

class PageAdmin extends Page {

    public function __contruct(array $options=[], string $tpl_dir='views/admin') {
        parent::__contruct($options, $tpl_dir);
    }

}