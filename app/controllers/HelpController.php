<?php


namespace C2;

class HelpController extends BaseAPI
{
    protected $User;
    protected $DBAccessLib;
    protected $UtilityLib;
    protected $ValidationLib;
    protected $MessageLib;
    protected $JWTLib;
    protected $EmailLib;

    public function __construct($settings) {
        parent::__construct($settings);
        $this->DBAccessLib = new Database\DBAccessLib($settings); // create a new object, class db()
        $this->UtilityLib = new Utility\UtilityLib($settings);
        $this->ValidationLib = new Validation\ValidationLib();
        $this->MessageLib = new Message\MessageLib($settings);
    }

    public function test()
    {
        echo uniqid();
        $responseData = $this->MessageLib->successMessageFormat($this->settings['successMessage']['SERVER_REACHABLE']);
        echo json_encode($responseData);
    }

    //searchUserDetailsBySearchText
    public function helpMenu()
    {
        $responseData = array();
        $responseData = $this->UtilityLib->getMenuAndSettings($this->DBAccessLib);
        echo json_encode($responseData);
    }

    //articleDetails
    public function articleDetails()
    {
        $responseData = array();
        
        //get post gata
        $postData = parent::getPostData();
        $article_id = parent::sanitizeInput($postData->articleId);
        
        //
        $passedData = array(
            "article_id"=>$article_id,
        );

        $validator = $this->UtilityLib->dataValidator($this->ValidationLib, $this->MessageLib, $passedData);

        //if input validated
        if($validator['success'])
        {
            //get user details
            $responseData = $this->UtilityLib->getArticleDetails($this->DBAccessLib, $passedData); 
            //$responseData["data"] = $data;
        }
        else
        {
            $responseData = $this->MessageLib->errorMessageFormat('INVALID_INPUT', $validator['error']);
        }
        echo json_encode($responseData);
    }

    public function searchArticle()
    {
        $responseData = array();
        
        //get post gata
        $postData = parent::getPostData();
        $search_key = parent::sanitizeInput($postData->searchKey);
        
        //
        $passedData = array(
            "search_key"=>$search_key,
        );

        $validator = $this->UtilityLib->dataValidator($this->ValidationLib, $this->MessageLib, $passedData);

        //if input validated
        if($validator['success'])
        {
            //get user details
            $responseData = $this->UtilityLib->getSearchArticle($this->DBAccessLib, $passedData); 
            //$responseData["data"] = $data;
        }
        else
        {
            $responseData = $this->MessageLib->errorMessageFormat('INVALID_INPUT', $validator['error']);
        }
        echo json_encode($responseData);
    }

    public function crudArticle(){
        $postData = parent::getPostData();
        $article_id = parent::sanitizeInput($postData->articleId);
        $article_title = parent::sanitizeInput($postData->articleTitle);
        $operation_type = parent::sanitizeInput($postData->operationType);
        
        $passedData = array(
            "article_id"=>$article_id,
            "article_title"=>$article_title,
            "operation_type"=>$operation_type
        );

        //create
        if($operation_type == 'create')
        {
            $this->DBAccessLib->insertArticle($passedData);
        }

        //edit
        else if($operation_type == 'edit')
        {
            $this->DBAccessLib->editArticle($passedData);
        }

        //delete
        else if($operation_type == 'delete')
        {
            $this->DBAccessLib->deleteArticle($passedData);
        }
    }

    public function crudMenu(){
        $postData = parent::getPostData();
        $article_parent_id = parent::sanitizeInput($postData->articleParentId);
        $parent_menu_order = parent::sanitizeInput($postData->parentMenuOrder);
        $operation_type = parent::sanitizeInput($postData->operationType);
        
        $article_child_id = '';
        if(property_exists($postData, 'articleChildId'))
        {
            $article_child_id = parent::sanitizeInput($postData->articleChildId);
        
        }

        $child_menu_order = 0;
        if(property_exists($postData, 'childMenuOrder'))
        {
            $child_menu_order = parent::sanitizeInput($postData->childMenuOrder);
        }

        $article_sub_child_id = '';
        if(property_exists($postData, 'articleSubChildId'))
        {
            $article_sub_child_id = parent::sanitizeInput($postData->articleSubChildId);
        
        }

        $sub_child_menu_order = 0;
        if(property_exists($postData, 'subChildMenuOrder'))
        {
            $sub_child_menu_order = parent::sanitizeInput($postData->subChildMenuOrder);
        }
        

        $passedData = array(
            "article_parent_id"=>$article_parent_id,
            "parent_menu_order"=>$parent_menu_order,
            "article_child_id"=>$article_child_id,
            "child_menu_order"=>$child_menu_order,
            "article_sub_child_id"=>$article_sub_child_id,
            "sub_child_menu_order"=>$sub_child_menu_order,
            "operation_type"=>$operation_type
        );

        //create
        if($operation_type == 'create')
        {
            $this->DBAccessLib->insertMenu($passedData);
        }

        //edit
        else if($operation_type == 'edit-parent')
        {
            $this->DBAccessLib->editParentMenu($passedData); 
        }

        else if($operation_type == 'edit-child')
        {
            $this->DBAccessLib->editChildMenu($passedData);
        }

        else if($operation_type == 'edit-sub-child')
        {
            $this->DBAccessLib->editSubChildMenu($passedData);
        }

        //delete
        else if($operation_type == 'delete-parent')
        {
            $this->DBAccessLib->deleteParentMenu($passedData);   
        }

        else if($operation_type == 'delete-child')
        {
            $this->DBAccessLib->deleteChildMenu($passedData);
        }

        else if($operation_type == 'delete-sub-child')
        {
            $this->DBAccessLib->deleteSubChildMenu($passedData);
        }
        //echo json_encode($passedData);
        
    }

    //crudContent
    public function crudContent(){
        $postData = parent::getPostData();
        $article_id = parent::sanitizeInput($postData->articleId);
        $article_component_order = parent::sanitizeInput($postData->articleComponentOrder);
        $article_component_type = parent::sanitizeInput($postData->articleComponentType);
        $article_component_content = parent::sanitizeInput($postData->articleComponentContent);
        $operation_type = parent::sanitizeInput($postData->operationType);
        
        $article_component_id = null;
        if(property_exists($postData, 'articleComponentId'))
        {
            $article_component_id = parent::sanitizeInput($postData->articleComponentId);
        }
        else
        {
            $article_component_id = $this->UtilityLib->generateId('');
        }

        $passedData = array(
            "article_id"=> $article_id,
            "article_component_order" => $article_component_order,
            "article_component_id" => $article_component_id,
            "article_component_type" => $article_component_type,
            "article_component_content" => $article_component_content,
            "operation_type" => $operation_type
        );

        //create
        if($operation_type == 'create')
        {
           $this->DBAccessLib->insertContent($passedData);
        }

        //edit
        else if($operation_type == 'edit')
        {
           $this->DBAccessLib->editContent($passedData);
        }

        //delete
        else if($operation_type == 'delete')
        {
            $this->DBAccessLib->deleteContent($passedData);
        }

        echo json_encode($passedData);
    }

    public function helpSettings(){
        $postData = parent::getPostData();
        $app_name = parent::sanitizeInput($postData->appName);
        $sign_up_url = parent::sanitizeInput($postData->signUpUrl);
        $support_email = parent::sanitizeInput($postData->supportEmail);
        
        $passedData = array(
            "app_name"=> $app_name,
            "sign_up_url" => $sign_up_url,
            "support_email" => $support_email
        );

        $validator = $this->UtilityLib->dataValidator($this->ValidationLib, $this->MessageLib, $passedData);

        //if input validated
        if($validator['success'])
        {
            //get user details
            $responseData = $this->DBAccessLib->insertSettings($passedData);
        }
        else
        {
            $responseData = $this->MessageLib->errorMessageFormat('INVALID_INPUT', $validator['error']);
        }

        echo json_encode($responseData);
    }

    public function articleFeedback(){
        $postData = parent::getPostData();
        $article_id = parent::sanitizeInput($postData->articleId);
        $feedback_type = parent::sanitizeInput($postData->feedbackType);
        
        $passedData = array(
            "article_id"=> $article_id,
            "feedback_type" => $feedback_type,
        );

        $validator = $this->UtilityLib->dataValidator($this->ValidationLib, $this->MessageLib, $passedData);

        //if input validated
        if($validator['success'])
        {
            //get user details
            $responseData = $this->DBAccessLib->updateArticleFeedback($passedData);
        }
        else
        {
            $responseData = $this->MessageLib->errorMessageFormat('INVALID_INPUT', $validator['error']);
        }

        echo json_encode($responseData);
    }

    function __destruct() {
        //echo 'The class "', __CLASS__, '" was destroyed.<br />';
        parent::__destruct();
        unset($this->DBAccessLib);
        unset($this->UtilityLib);
        unset($this->ValidationLib);
        unset($this->MessageLib);
    }   
}
