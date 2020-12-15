<?php 

require_once "Models/pagesModel.php";

class udpatePageUrlClickController
{
    public function __construct()
    {
    }

    public function increasePageUrlClicks($pageId)
    {
        $pagesModelObj = new pagesModel();
        $success = $pagesModelObj->increasePageUrlClicks($pageId);
        
        return $success;
    }
}