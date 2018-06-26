<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');  
 
require_once "application/libraries/fpdf/fpdf.php";
 
class Fpdfs extends FPDF {
    public function __construct() {
        parent::__construct();
    }
}