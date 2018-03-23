<?php

function get_extdirect_api($caller) {
    $MEMBERS_API = array(
        'Members'=>array(
            'methods'=>array(
                'create'=>array(
                    'len'=>1
                    ,'metadata' => array(
                        'params' => array('_table')
                    )
                ),
                'update'=>array(
                    'len'=>1
                    ,'metadata' => array(
                        'params' => array('_table','_key')
                    )
                ),
                'delete'=>array(
                    'len'=>1
                    ,'metadata' => array(
                        'params' => array('_table','_key')
                    )
                ),
                'getGrid'=>array(
                    'len'=>1
                    ,'metadata' => array(
                        'params' => array('_table','_sort')
                    )
                )
            )
        )
        , 'Users'=>array(
            'methods'=>array(
                'create'=>array(
                    'len'=>1
                    ,'metadata' => array(
                        'params' => array('_table')
                    )
                ),
                'update'=>array(
                    'len'=>1
                    ,'metadata' => array(
                        'params' => array('_table','_key')
                    )
                ),
                'delete'=>array(
                    'len'=>1
                    ,'metadata' => array(
                        'params' => array('_table','_key')
                    )
                ),
                'getGrid'=>array(
                    'len'=>1
                    ,'metadata' => array(
                        'params' => array('_table','_sort')
                    )
                )
            )
        )
        , 'Fees'=>array(
            'methods'=>array(
                'create'=>array(
                    'len'=>1
                    ,'metadata' => array(
                        'params' => array('_table')
                    )
                ),
                'update'=>array(
                    'len'=>1
                    ,'metadata' => array(
                        'params' => array('_table','_key')
                    )
                ),
                'delete'=>array(
                    'len'=>1
                    ,'metadata' => array(
                        'params' => array('_table','_key')
                    )
                ),
                'getGrid'=>array(
                    'len'=>1
                    ,'metadata' => array(
                        'params' => array('_table','_sort')
                    )
                )
            )
        )
        , 'MemberFee'=>array(
            'methods'=>array(
                'create'=>array(
                    'len'=>1
                    ,'metadata' => array(
                        'params' => array('_table')
                    )
                ),
                'update'=>array(
                    'len'=>1
                    ,'metadata' => array(
                        'params' => array('_table','_key')
                    )
                ),
                'delete'=>array(
                    'len'=>1
                    ,'metadata' => array(
                        'params' => array('_table', '_key')
                    )
                ),
                'getGrid'=>array(
                    'len'=>1
                    ,'metadata' => array(
                        'params' => array('_table','_sort','_fields')
                    )
                )
            )
        )
        ,'Club'=>array(
            'methods'=>array(
                'create'=>array(
                    'len'=>1
                    ,'metadata' => array(
                        'params' => array('_table')
                    )
                ),
                'update'=>array(
                    'len'=>1
                    ,'metadata' => array(
                        'params' => array('_table','_key')
                    )
                    ),
                'getGrid'=>array(
                    'len'=>1
                    ,'metadata' => array(
                        'params' => array('_table','_sort')
                    )
                )
            )
        )
  
    );

    $FORM_API = array(
        'Profile' => array(
            'methods'=>array(
                'getBasicInfo'=>array(
                    'len'=>2
                ),
                'getPhoneInfo'=>array(
                    'len'=>1
                ),
                'getLocationInfo'=>array(
                    'len'=>1
                ),
                'updateBasicInfo'=>array(
                    'len'=>0,
                    'formHandler'=>true
                )
            )
        )
    );

    $api = null;
    
    # This demonstrates dynamic API generation based on what the client side
    # has requested from the server. In the client, we will use separate
    # Providers that handle Profile form requests and TestAction class methods.
    # Note that we only do that when called from aph.php; Router will need
    # the full API array to handle all requests.
    if ($caller == 'api') {
        if (isset($_GET['form'])) {
            $api = $FORM_API;
        }
        else {
            $api = $MEMBERS_API;
        }
    }
    else {
        $api = array_merge($MEMBERS_API, $FORM_API);
    }
    
    return $api;
}

?>
