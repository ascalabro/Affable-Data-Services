<?php

class AffableListingsController extends RestfulResponseController {
    
    public function actionGetAllComputerListings() 
    {
        $listings = LaptopListing::model()->with('laptopListingImages')->findAll();
        $this->_sendResponse($this->convertModelToArray($listings));
    }
    
}
