<?php

class Mundipagg_Model_CreditCardOperationType
{

    public function toOptionArray() 
    {
        return
            [
                'AuthAndCapture' => 'Auth and capture',
                'AuthOnly' => 'Auth only',
            ];
    }

}
