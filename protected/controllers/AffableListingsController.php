<?php

class AffableListingsController extends RestController {

    public function actionGetListings($category = false)
    {
        $listings = Listing::model()->with('listingImages')->findAll();
        $this->_sendResponse($this->convertModelToArray($listings));
    }

    public function actionListing($listing_id)
    {
        $this->_sendResponse(Listing::model()->findByPk($listing_id));
    }

}
