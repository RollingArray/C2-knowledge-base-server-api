<?php

namespace C2\Utility;

class UtilityLib
{

    protected $settings = null;

    //__construct
    function __construct($settings)
    {
        //echo 'The class "', __CLASS__, '" was initiated!<br />';
        $this->settings = $settings;
    }

    //__destruct
    function __destruct()
    {
        //echo 'The class "', __CLASS__, '" was destroyed.<br />';

    }

    //dataValidator
    public function dataValidator($validationLib, $messageLib, $passedData)
    {
        $responseData = array();

        foreach ($passedData as $key => $value) {
            if ($value) {
                $validationKey = $key;

                $isValid = $validationLib->validateInputValueFormat($this->settings['validationRules'][$validationKey], $value);
                if ($isValid) {
                    $responseData['success'] = true;
                } else {
                    $responseData['success'] = false;
                    $responseData['error'] = $this->settings['errorValidationMessage'][$validationKey]; //$key
                    return $responseData;
                }
            } else {
                $responseData['success'] = true;
            }
        }


        return $responseData;
    }

    //generateUserId
    public function generateUserId($user_email)
    {
        return "USER_" . md5($user_email);
    }

    //generateDomainId
    public function generateDomainId()
    {
        return uniqid('DOMAIN_');
    }

    //generateUserId
    public function generateId($prependString)
    {
        return uniqid($prependString);
    }

    //generateVerificationCode
    public function generateVerificationCode()
    {
        return bin2hex(openssl_random_pseudo_bytes(4));
    }

    //generatePasswordResetCode
    public function generatePasswordResetCode()
    {
        return bin2hex(openssl_random_pseudo_bytes(2));
    }

    //generateKeyValueStructure
    private function generateKeyValueStructure($data)
    {
        $tempRows = array();
        foreach ($data as $key => $value) {
            //$keyName = $this->extractKeyName($key);
            $tempRows[$key] = $value;
        }

        return $tempRows;
    }

    //generateServiceReturnDataStructure
    private function generateServiceReturnDataStructure($passedData)
    {
        $responseData = array();

        //echo "$passedData".json_encode($passedData);

        if ($passedData) {
            $responseData['success'] = true;
            $responseData['data'] = $passedData;
        } else {
            $responseData['success'] = false;
        }


        return $responseData;
    }

    //generateServiceReturnDataStructure
    function getMenuAndSettings($DBAccessLib)
    {
        $responseData = array();

        $responseData['settings'] = $DBAccessLib->getSettings();
        $responseData['menu'] = $this->getParentMenu($DBAccessLib);

        return $responseData;
    }

    //getAllAssigneeCredibilityIndex
    public function getParentMenu($DBAccessLib)
    {
        $rows = $DBAccessLib->getParentMenu();
        $tempRows = array();
        foreach ($rows as $eachData) {
            $passedData = array(
                "article_parent_id"=>$eachData['articleParentId'],
            );
            $eachData['childMenu'] = $this->getChildMenu($DBAccessLib, $passedData);
            $tempRows[] = $this->generateKeyValueStructure($eachData);
        }

        return $this->generateServiceReturnDataStructure($tempRows);
    } 

    public function getChildMenu($DBAccessLib, $passedData)
    {
        $rows = $DBAccessLib->getChildMenu($passedData);
        $tempRows = array();
        foreach ($rows as $eachData) {
            $passedData = array(
                "article_child_id"=>$eachData['articleId'],
            );
            $eachData['subChildMenu'] = $this->getSubChildMenu($DBAccessLib, $passedData);
            $tempRows[] = $this->generateKeyValueStructure($eachData);
        }

        return $this->generateServiceReturnDataStructure($tempRows);
    } 

    public function getSubChildMenu($DBAccessLib, $passedData)
    {
        $rows = $DBAccessLib->getSubChildMenu($passedData);
        $tempRows = array();
        foreach ($rows as $eachData) {
            $tempRows[] = $this->generateKeyValueStructure($eachData);
        }

        return $this->generateServiceReturnDataStructure($tempRows);
    } 

    public function getArticleDetails($DBAccessLib, $passedData)
    {
        $rows = $DBAccessLib->getArticleDetails($passedData);
        $tempRows = array();
        foreach ($rows as $eachData) {
            $tempRows[] = $this->generateKeyValueStructure($eachData);
        }

        $articleDetails = $this->generateServiceReturnDataStructure($tempRows);

        $responseData = array();

        $responseData['settings'] = $DBAccessLib->getSettings();
        $responseData['article'] = $articleDetails;

        return $responseData;
    } 

    public function getSearchArticle($DBAccessLib, $passedData)
    {
        $rows = $DBAccessLib->getSearchArticle($passedData);
        $tempRows = array();
        foreach ($rows as $eachData) {
            $tempRows[] = $this->generateKeyValueStructure($eachData);
        }

        return $this->generateServiceReturnDataStructure($tempRows);
    }
    
}
