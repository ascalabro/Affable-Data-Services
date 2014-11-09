<?php

class RestfulResponseController extends Controller 
{
    	protected function _sendResponse($content = false, $status = 200, $content_type = "application/json")
	{
		header("Content-type: " . $content_type, true, $status);
		header("Access-Control-Allow-Origin: *");
		echo json_encode($content ? $content : array(array("error" => "No data found")));
		Yii::app()->end();
	}
}

