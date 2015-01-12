<?php

class AffableListingsController extends RestController {

    public function actionGetListingsComplete($category = false)
    {
        $listings = Listing::model()->with('listingImages')->findAll();
        $this->_sendResponse(Helper::convertModelRelationsToArray($listings));
    }

    public function actionGetListing($listing_id)
    {
        $this->_sendResponse(Listing::model()->findByPk($listing_id));
    }

    public function actionGetActiveCategoriesComplete()
    {
        $categories = ListingCategory::model()->with('subcategories')->findAll(array("condition" => "t.status = 1 AND subcategories.status = 1"));
        $this->_sendResponse(Helper::convertModelRelationsToArray($categories));
    }

}
