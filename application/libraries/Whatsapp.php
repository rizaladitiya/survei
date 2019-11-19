<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');  
 
require_once APPPATH."/third_party/Twiliomaster/Twilio/autoload.php";
 
class Whatsapp extends SplClassLoader {
    public function __construct() {
        parent::__construct();
    }
}