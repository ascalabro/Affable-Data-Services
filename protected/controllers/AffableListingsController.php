<?php

class AffableListingsController extends RestController {
    
    public function actionGetAllComputerListings() 
    {
        $listings = LaptopListing::model()->with('laptopListingImages')->findAll();
        $this->_sendResponse($this->convertModelToArray($listings));
    }
    
}
