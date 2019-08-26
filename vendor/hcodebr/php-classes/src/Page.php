<?php

namespace Hcode;

use Rain\Tpl;

class Page {

    protected static $DEFAULTS = [
        'header' => true,
        'footer' => true,
        'data' => [
            'rootAddress' => '',
        ],
    ];

    private $tpl;
    private $options = []; 
    

    public function __construct(array $options=[], string $tpl_dir='views') {
        $this->options = array_merge(STATIC::$DEFAULTS, $options);

        // config
        $config = array(
            "tpl_dir"       => $_SERVER["DOCUMENT_ROOT"] . "/e-commerce/$tpl_dir/",
            "cache_dir"     => $_SERVER["DOCUMENT_ROOT"] . "/e-commerce/views-cache/",
            "debug"         => false // set to false to improve the speed
        );

        Tpl::configure( $config );

        // create the Tpl object
        $this->tpl = new Tpl;

        $this->setData($this->options['data']);

        if ($this->options['header'] === true) $this->tpl->draw('header');
    }

    private function setData(array $data=[]) {
        foreach ($data as $key => $value) $this->tpl->assign($key, $value);
    }

    public function setTpl(string $name, array $data=[], bool $returnHTML=false) {
        $this->setData($data);

        return $this->tpl->draw($name, $returnHTML);
    }

    public function __destruct() {
        if ($this->options['footer'] === true) $this->tpl->draw('footer');
    }

}