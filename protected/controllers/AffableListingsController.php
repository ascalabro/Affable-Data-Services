<?php

class AffableListingsController extends RestfulResponseController {
    
    public function actionGetAllComputerListings() 
    {
        $listings = LaptopListing::model()->with('laptopListingImages')->findAll();
        echo CJSON::encode($this->convertModelToArray($listings));
    }
    
}
