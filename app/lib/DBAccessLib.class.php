<?php

namespace C2\Database;

class DBAccessLib extends BaseDatabaseAPI
{
    function __construct($settings)
    {
        parent::__construct($settings);
    }

    function __destruct()
    {
        parent::__destruct();
    }

    //getParentMenu
    public function getParentMenu()
    {
        $query = "CALL sp_get_parent_menu()";

        $data = array(
            //
        );

        return parent::getAllRecords($query, $data);
    }

    //getChildMenu
    public function getChildMenu($passedData)
    {
        $query = "CALL sp_get_child_menu(?)";

        $data = array(
            $passedData['article_parent_id'],
        );

        return parent::getAllRecords($query, $data);
    }

    //getChildMenu
    public function getSubChildMenu($passedData)
    {
        $query = "CALL sp_get_sub_child_menu(?)";

        $data = array(
            $passedData['article_child_id'],
        );

        return parent::getAllRecords($query, $data);
    }

    //getArticleDetails
    public function getArticleDetails($passedData)
    {
        $query = "CALL sp_get_article_details(?)";

        $data = array(
            $passedData['article_id'],
        );
        
        return parent::getAllRecords($query, $data);
    }

    public function getSearchArticle($passedData)
    {
        $query = "CALL sp_get_article_search(?)";

        $data = array(
            $passedData['search_key'],
        );

        return parent::getAllRecords($query, $data);
    }

    //insertArticle
    function insertArticle($passedData)
    {
        $query = "CALL sp_insert_article(?,?)";

        $data = array(
            $passedData['article_id'],
            $passedData['article_title'],
        );

        return parent::executeStatement($query, $data);
    }

    function editArticle($passedData)
    {
        $query = "CALL sp_update_article(?,?)";

        $data = array(
            $passedData['article_id'],
            $passedData['article_title'],
        );

        return parent::executeStatement($query, $data);
    }

    function deleteArticle($passedData)
    {
        $query = "CALL sp_delete_article(?,?)";

        $data = array(
            $passedData['article_id'],
            $passedData['article_title'],
        );

        return parent::executeStatement($query, $data);
    }

    function updateArticleFeedback($passedData)
    {
        $query = "CALL sp_update_article_feedback(?,?)";

        $data = array(
            $passedData['article_id'],
            $passedData['feedback_type']
        );

        return parent::executeStatement($query, $data);
    }

    function insertMenu($passedData)
    {
        $query = "CALL sp_insert_menu(?,?,?,?,?,?)";

        $data = array(
            $passedData['article_parent_id'],
            $passedData['article_child_id'],
            $passedData['article_sub_child_id'],
            $passedData['parent_menu_order'],
            $passedData['child_menu_order'],
            $passedData['sub_child_menu_order'],
        );

        echo json_encode($data);

        return parent::executeStatement($query, $data);
    }

    function editParentMenu($passedData)
    {
        $query = "CALL sp_update_parent_menu(?,?)";

        $data = array(
            $passedData['article_parent_id'],
            $passedData['parent_menu_order']
        );

        return parent::executeStatement($query, $data);
    }

    function editChildMenu($passedData)
    {
        $query = "CALL sp_update_child_menu(?,?,?,?)";

        $data = array(
            $passedData['article_parent_id'],
            $passedData['article_child_id'],
            $passedData['parent_menu_order'],
            $passedData['child_menu_order']
        );

        return parent::executeStatement($query, $data);
    }

    function editSubChildMenu($passedData)
    {
        $query = "CALL sp_update_sub_child_menu(?,?,?,?,?,?)";

        $data = array(
            $passedData['article_parent_id'],
            $passedData['article_child_id'],
            $passedData['article_sub_child_id'],
            $passedData['parent_menu_order'],
            $passedData['child_menu_order'],
            $passedData['sub_child_menu_order'],
        );

        echo json_encode($data);

        return parent::executeStatement($query, $data);
    }

    

    function deleteParentMenu($passedData)
    {
        $query = "CALL sp_delete_parent_menu(?)";

        $data = array(
            $passedData['article_parent_id']
        );

        return parent::executeStatement($query, $data);
    }

    function deleteChildMenu($passedData)
    {
        $query = "CALL sp_delete_child_menu(?)";

        $data = array(
            $passedData['article_child_id']
        );

        return parent::executeStatement($query, $data);
    }

    function deleteSubChildMenu($passedData)
    {
        $query = "CALL sp_delete_sub_child_menu(?)";

        $data = array(
            $passedData['article_sub_child_id']
        );

        echo json_encode($data);
        return parent::executeStatement($query, $data);
    }

    

    function insertContent($passedData)
    {
        $query = "CALL sp_insert_content(?,?,?,?,?)";

        $data = array(
            $passedData['article_id'],
            $passedData['article_component_order'],
            $passedData['article_component_id'],
            $passedData['article_component_type'],
            $passedData['article_component_content'],
        );

        return parent::executeStatement($query, $data);
    }

    function editContent($passedData)
    {
        $query = "CALL sp_update_content(?,?,?,?,?)";

        $data = array(
            $passedData['article_id'],
            $passedData['article_component_order'],
            $passedData['article_component_id'],
            $passedData['article_component_type'],
            $passedData['article_component_content'],
        );

        return parent::executeStatement($query, $data);
    }

    function deleteContent($passedData)
    {
        $query = "CALL sp_delete_content(?)";

        $data = array(
            $passedData['article_component_id']
        );

        return parent::executeStatement($query, $data);
    }

    function insertSettings($passedData)
    {
        $query = "CALL sp_insert_settings(?,?,?)";

        $data = array(
            $passedData['app_name'],
            $passedData['sign_up_url'],
            $passedData['support_email']
        );

        return parent::executeStatement($query, $data);
    }

    public function getSettings()
    {
        $query = "CALL sp_get_settings()";

        $data = array(
            //
        );

        return parent::getOneRecord($query, $data);
    }

    
    
    
    
}
