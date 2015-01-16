<?php

class AffableListingsController extends RestController {

    public function actionGetListings($complete = false)
    {
        $listings = $complete ? Listing::model()->with('categories')->with('subcategories')->with('images')->findAll() : Listing::model()->findAll();
        $this->_sendResponse(Helper::convertModelRelationsToArray($listings));
    }

    public function actionGetListingDetail($listing_id)
    {
        $this->_sendResponse(Helper::convertModelRelationsToArray(Listing::model()->with('categories')->with('subcategories')->with('images')->findByPk($listing_id)));
    }

    public function actionGetActiveCategoriesComplete()
    {
        $categories = ListingCategory::model()->with('subcategories')->findAll(array("condition" => "t.status = 1 AND subcategories.status = 1"));
        $this->_sendResponse(Helper::convertModelRelationsToArray($categories));
    }

    public function actionGetListingsByCategory($category_id, $complete = false)
    {
        $criteria = new CDbCriteria(array(
            'condition' => "`category`.`id` = :category_id",
            'params' => array(':category_id' => $category_id)
        ));
        $criteria->with = $complete ?
            array(
                "categories" => array("alias" => "category"),
                "subcategories",
                "images"
            ) :
            array(
                "categories" => array("alias" => "category"),
            );
        $listings = Listing::model()->findAll($criteria);
        $this->_sendResponse(Helper::convertModelRelationsToArray($listings));
    }

}
