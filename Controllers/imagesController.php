<?php 

require_once "Models/imagesModel.php";

class imagesController 
{
    private $imagesPerRequest;
    public function __construct($imagesPerRequest = 30)
    {
        $this->imagesPerRequest = $imagesPerRequest;
    }

    public function getTotNumOfImgsResults($searchTerm)
    {
        $imgModelObj = new imagesModel();
        return $imgModelObj->getTotNumOfImgsResults($searchTerm);
    }

    public function getImagesResult($searchTerm, $requestNumber)
    {
        /*
        input:
            * request number represent a counter 
            * for the number of times that the clent requested images 
            * either throw loading the page or ajax http request.

        * reutrn:
            search results:
            image url to requst the image and render it on the page 
            parent page that we found the image on it 
            alt and title text of the img 
        */
        
        $startOffset = ($requestNumber - 1) * $this->imagesPerRequest;
        $imgModelObj = new imagesModel();
        $imageResults = $imgModelObj->getImagesResults($searchTerm, $startOffset, $this->imagesPerRequest);
        return $imageResults;
    }
}
?>