<?php 

/* Copyright (C) Pay10 2023  - All Rights Reserved
 * Created by Rohit Kumar Singh
 *
 */

class PTPGModule
{
    /**
     * [$pay_id description]
     * @var [type]
     */
    private $pay_id;

    /**
     * [$salt description]
     * @var [type]
     */
    private $salt;
    
    /**
     * [$order_id description]
     * @var [type]
     */
    private $order_id;
    
    /**
     * [$return_url description]
     * @var [type]
     */
    private $return_url;
    
    /**
     * [$cust_email description]
     * @var [type]
     */
    private $cust_email;
    
    /**
     * [$cust_name description]
     * @var [type]
     */
    private $cust_name;
    
    /**
     * [$cust_street_address1 description]
     * @var [type]
     */
    private $cust_street_address1;
    
    /**
     * [$cust_city description]
     * @var [type]
     */
    private $cust_city;
    
    /**
     * [$cust_state description]
     * @var [type]
     */
    private $cust_state;
    
    /**
     * [$cust_country description]
     * @var [type]
     */
    private $cust_country;
    
    /**
     * [$cust_zip description]
     * @var [type]
     */
    private $cust_zip;
    
    /**
     * [$cust_phone description]
     * @var [type]
     */
    private $cust_phone;
    
    /**
     * [$currency_code description]
     * @var [type]
     */
    private $currency_code;
    
    /**
     * [$amount description]
     * @var [type]
     */
    private $amount;
    
    /**
     * [$product_desc description]
     * @var [type]
     */
    private $product_desc;
    
    /**
     * [$cust_ship_street_address1 description]
     * @var [type]
     */
    private $cust_ship_street_address1;
    
    /**
     * [$cust_ship_city description]
     * @var [type]
     */
    private $cust_ship_city;
    
    /**
     * [$cust_ship_state description]
     * @var [type]
     */
    private $cust_ship_state;
    
    /**
     * [$cust_ship_country description]
     * @var [type]
     */
    private $cust_ship_country;
    
    /**
     * [$cust_ship_zip description]
     * @var [type]
     */
    private $cust_ship_zip;
    
    /**
     * [$cust_ship_phone description]
     * @var [type]
     */
    private $cust_ship_phone;
    
    /**
     * [$cust_ship_name description]
     * @var [type]
     */
    private $cust_ship_name;
    
    /**
     * [$txn_type description]
     * @var [type]
     */
    private $txn_type;

    /**
     * [$pg_request_url description]
     * @var [type]
     */
    private $pg_request_url;
    private $pg_merchant_hosted_key;
    

    /**
     * @param string $pay_id
     *
     * @return self
     */
    public function setPayId($pay_id)
    {
        $this->pay_id = $pay_id;

        return $this;
    }

    /**
     * @param string $salt
     *
     * @return self
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * @param string $order_id
     *
     * @return self
     */
    public function setOrderId($order_id)
    {
        $this->order_id = $order_id;

        return $this;
    }

    /**
     * @param string $return_url
     *
     * @return self
     */
    public function setReturnUrl($return_url)
    {
        $this->return_url = $return_url;

        return $this;
    }

    /**
     * @param string $cust_email
     *
     * @return self
     */
    public function setCustEmail($cust_email)
    {
        $this->cust_email = $cust_email;

        return $this;
    }

    /**
     * @param string $cust_name
     *
     * @return self
     */
    public function setCustName($cust_name)
    {
        $this->cust_name = $cust_name;

        return $this;
    }

    /**
     * @param string $cust_street_address1
     *
     * @return self
     */
    public function setCustStreetAddress1($cust_street_address1)
    {
        $this->cust_street_address1 = $cust_street_address1;

        return $this;
    }

    /**
     * @param string $cust_city
     *
     * @return self
     */
    public function setCustCity($cust_city)
    {
        $this->cust_city = $cust_city;

        return $this;
    }

    /**
     * @param string $cust_state
     *
     * @return self
     */
    public function setCustState($cust_state)
    {
        $this->cust_state = $cust_state;

        return $this;
    }

    /**
     * @param string $cust_country
     *
     * @return self
     */
    public function setCustCountry($cust_country)
    {
        $this->cust_country = $cust_country;

        return $this;
    }

    /**
     * @param string $cust_zip
     *
     * @return self
     */
    public function setCustZip($cust_zip)
    {
        $this->cust_zip = $cust_zip;

        return $this;
    }

    /**
     * @param string $cust_phone
     *
     * @return self
     */
    public function setCustPhone($cust_phone)
    {
        $this->cust_phone = $cust_phone;

        return $this;
    }

    /**
     * @param string $currency_code
     *
     * @return self
     */
    public function setCurrencyCode($currency_code)
    {
        $this->currency_code = $currency_code;

        return $this;
    }

    /**
     * @param string $amount
     *
     * @return self
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @param string $product_desc
     *
     * @return self
     */
    public function setProductDesc($product_desc)
    {
        $this->product_desc = $product_desc;

        return $this;
    }

    /**
     * @param string $cust_ship_street_address1
     *
     * @return self
     */
    public function setCustShipStreetAddress1($cust_ship_street_address1)
    {
        $this->cust_ship_street_address1 = $cust_ship_street_address1;

        return $this;
    }

    /**
     * @param string $cust_ship_city
     *
     * @return self
     */
    public function setCustShipCity($cust_ship_city)
    {
        $this->cust_ship_city = $cust_ship_city;

        return $this;
    }

    /**
     * @param string $cust_ship_state
     *
     * @return self
     */
    public function setCustShipState($cust_ship_state)
    {
        $this->cust_ship_state = $cust_ship_state;

        return $this;
    }

    /**
     * @param string $cust_ship_country
     *
     * @return self
     */
    public function setCustShipCountry($cust_ship_country)
    {
        $this->cust_ship_country = $cust_ship_country;

        return $this;
    }

    /**
     * @param string $cust_ship_zip
     *
     * @return self
     */
    public function setCustShipZip($cust_ship_zip)
    {
        $this->cust_ship_zip = $cust_ship_zip;

        return $this;
    }

    /**
     * @param string $cust_ship_phone
     *
     * @return self
     */
    public function setCustShipPhone($cust_ship_phone)
    {
        $this->cust_ship_phone = $cust_ship_phone;

        return $this;
    }

    /**
     * @param string $cust_ship_name
     *
     * @return self
     */
    public function setCustShipName($cust_ship_name)
    {
        $this->cust_ship_name = $cust_ship_name;

        return $this;
    }

    /**
     * @param string $txn_type
     *
     * @return self
     */
    public function setTxnType($txn_type)
    {
        $this->txn_type = $txn_type;
        return $this;
    }

    /**
     * @param string $pg_request_url
     *
     * @return self
     */
    public function setPgRequestUrl($pg_request_url)
    {
        $this->pg_request_url = $pg_request_url;

        return $this;
    }

    public function setMerchantHostedKey($pg_merchant_hosted_key)
    {
        $this->pg_merchant_hosted_key = $pg_merchant_hosted_key;

        return $this;
    }

    

    /**
     * [_empty to remove null values]
     * @param  string $value input string
     * @return string        same as value or empty string
     */
    public function _empty($value)
    {
        return isset($value) ? $value : '';
    }

    /**
     * [generateHash description]
     * @param  array $postdata Post data
     * @return string           hash of string
     */
    public function generateHash($postdata)
    {
        ksort($postdata);
        $all = '';
        foreach ($postdata as $name => $value) {
            $all .= $name."=".$value."~";
        }
        $all = substr($all, 0, -1);
        $all .= $this->salt;
        return strtoupper(hash('sha256', $all));
    }

    /**
     * [createTransactionRequest description]
     * @return string [description]
     */
    public function createTransactionRequest()
    {
        $this->performChecks();
        $post_variables = array(
            "PAY_ID" => $this->_empty($this->pay_id),
            "ORDER_ID" => $this->_empty($this->order_id),
            "RETURN_URL" => $this->_empty($this->return_url),
            "CUST_EMAIL" => $this->_empty($this->cust_email),
            "CUST_NAME" => $this->_empty($this->cust_name),
            "CUST_STREET_ADDRESS1" => $this->_empty($this->cust_street_address1),
            "CUST_CITY" => $this->_empty($this->cust_city),
            "CUST_STATE" => $this->_empty($this->cust_state),
            "CUST_COUNTRY" => $this->_empty($this->cust_country),
            "CUST_ZIP" => $this->_empty($this->cust_zip),
            "CUST_PHONE" => $this->_empty($this->cust_phone),
            "CURRENCY_CODE" => $this->_empty($this->currency_code),
            "AMOUNT" => $this->_empty($this->amount),
            "PRODUCT_DESC" => $this->_empty($this->product_desc),
            "CUST_SHIP_STREET_ADDRESS1" => $this->_empty($this->cust_ship_street_address1),
            "CUST_SHIP_CITY" => $this->_empty($this->cust_ship_city),
            "CUST_SHIP_STATE" => $this->_empty($this->cust_ship_state),
            "CUST_SHIP_COUNTRY" => $this->_empty($this->cust_ship_country),
            "CUST_SHIP_ZIP" => $this->_empty($this->cust_ship_zip),
            "CUST_SHIP_PHONE" => $this->_empty($this->cust_ship_phone),
            "CUST_SHIP_NAME" => $this->_empty($this->cust_ship_name),
            "TXNTYPE" => $this->_empty($this->txn_type),
        );
        $post_variables['HASH'] = $this->generateHash($post_variables);

        return $post_variables;
    }

    /**
     * [performChecks description]
     * @return [type] [description]
     */
    public function performChecks()
    {
        // required values
        $check_values = array(
            'PAY_ID' => $this->pay_id,
            'ORDER_ID' => $this->order_id,
            'RETURN_URL' => $this->return_url,
            'CUST_EMAIL' => $this->cust_email,
            'CUST_PHONE' => $this->cust_phone,
            'AMOUNT' => $this->amount,
            'TXNTYPE' => $this->txn_type,
            'CURRENCY_CODE' => $this->currency_code
        );

        foreach ($check_values as $key => $value) {
            if (!isset($value)) {
                die('<h4>'.$key.' value is missing</h4>');
            }
        }
    }

    /**
     * [validateResponse description]
     * @param  [type] $response [description]
     * @return [type]           [description]
     */
    public function validateResponse($response)
    {
        $postdata = $response;
        $salt=$this->salt;
        ksort($postdata);
        unset($postdata["HASH"]);
        unset($postdata["CARD_ISSUER_BANK"]);
        
        $all = '';
        foreach ($postdata as $name => $value) {
            $all .= $name."=".$value."~";
        }
        $all = substr($all, 0, -1);
        $all .= $salt;
        
      

        $generated_hash = strtoupper(hash('sha256', $all));
    
        if ($response['HASH'] == $generated_hash) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * [redirectForm description]
     * @param  [type] $postdata [description]
     * @return [type]           [description]
     */
    public function redirectForm($postdata)
    {
        $output = '<form id="payForm" action="'.$this->pg_request_url.'" method="post">';
        foreach ($postdata as $key => $value) {
            $output .= '<input type="hidden" name="' . $key . '" value="' . $value . '">' . "\n";
        }
        $output .= '</form><script> document.getElementById("payForm").submit(); </script><h2>Redirecting...</h2>';
        echo $output;
        exit();
    }


    //for aes encrytion

    public function aes_encyption($hash_string){
     $CryptoKey= $this->pg_merchant_hosted_key; //Prod Key
     $iv = substr($CryptoKey, 0, 16); //or provide iv
     $method = "AES-256-CBC";
     $ciphertext = openssl_encrypt($hash_string, $method, $CryptoKey, OPENSSL_RAW_DATA, $iv);
     $ENCDATA= base64_encode($ciphertext);
     return $ENCDATA;
    }       

    public function aes_decryption($ENCDATA){
    $CryptoKey= $this->pg_merchant_hosted_key; //Prod Key
    $iv = substr($CryptoKey, 0, 16); //or provide iv
    $method = "AES-256-CBC";
    $encrptedString  = openssl_decrypt($ENCDATA, $method, $CryptoKey, 0, $iv);
    return $encrptedString;
    }  

    public function split_decrypt_string($value)
    {
        $plain_string=explode('~',$value);
        $final_data = array();
        foreach ($plain_string as $key => $value) {
            $simple_string=explode('=',$value);
           $final_data[$simple_string[0]]=$simple_string[1];
        } 
        return $final_data;
    }

}

?>
