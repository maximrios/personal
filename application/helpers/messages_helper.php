<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('do_message')) {
    function do_message($options=array()){
        $this->initialize($options);
        $this->_set_client_controller();
        $message = <<<ClientTemplate
          <div id="{$this->id}" class="notif-container-{$this->type} clearfix">
            <div class="notif-lft">
{$this->message}
            </div>
            <a class="icon-notif">&nbsp;</a><div class="clearfloat">&nbsp;</div>
          </div>
ClientTemplate;
        return $message.$this->_client_controller;

    }
}
