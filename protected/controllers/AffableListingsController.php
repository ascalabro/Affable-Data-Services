<?php

class AffableListingsController extends RestController {

    public function actionListing($listing_id = false, $complete = true, $category_id = false)
    {
        if (!$listing_id) {
            // fetch all listings
            if ($category_id) {
                $criteria = new CDbCriteria();
                $criteria->condition = "`category`.`id` = :category_id";
                $criteria->addCondition("`t`.`status` = :status");
                $criteria->params = array(
                    ":category_id" => (int)$category_id,
                    ":status" => 1
                );
                $criteria->with = $complete ?
                        array(
                    "categories" => array("alias" => "category"),
                    "subcategories",
                    "images"
                        ) :
                        array(
                    "categories" => array("alias" => "category"),
                );
            } else {
                $criteria = new CDbCriteria(array(
                    'condition' => "`t`.`status` = :status",
                    'params' => array(':status' => 1)
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
            }
            $listings = Listing::model()->findAll($criteria);
        } else {
            // fetch single listing
            $listings = $complete ? Listing::model()->with('categories')->with('subcategories')->with('images')->findByPk($listing_id) : Listing::model()->findByPk($listing_id);
        }
        $this->_sendResponse(Helper::convertModelRelationsToArray($listings));
    }

    public function actionGetListingDetail($listing_id)
    {
        $this->_sendResponse(Helper::convertModelRelationsToArray(Listing::model()->with('categories')->with('subcategories')->with('images')->findByPk($listing_id)));
    }

    public function actionCategory($status_code = false, $complete = false)
    {
        $criteria = new CDbCriteria();
        if ($status_code != "") {
            $criteria->addCondition("t.status = :pstatus_code");
            $criteria->params[":pstatus_code"] = (int) $status_code;
            if ($complete) {
                $criteria->addCondition("subcategories.status = :status_code");
                $criteria->params[":status_code"] = (int) $status_code;
                $criteria->with["subcategories"] = array("alias" => "subcategories");
            }
        }
        $categories = ListingCategory::model()->findAll($criteria);
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
