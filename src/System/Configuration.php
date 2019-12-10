<?php

namespace Src\System;

class Configuration
{
    private $db;
    private $baseAPIUrl;
    private $pubkeyRSA="-----BEGIN PUBLIC KEY-----
MIICIjANBgkqhkiG9w0BAQEFAAOCAg8AMIICCgKCAgEAvHE9m7S/jhcVCkThiCo0
bW2JloaH+4CeNu1hIvcf2f97IQIwgutowDlH+1EgnPhHlCr0M/Kme2l1ZY9A6qZn
Ziui/M3JoE1xHOxGWA0DH4lfn2PTZvO4H15EAsDSMeytW2eegcRLS2LDFxoDWZ0V
geEYeT5yodVpvtgT1couBMxYMGWdUTZsddXNauSjISu4dhRtFcr5JRFY4c1XwKxk
JgLVK/4gH03k7lxPenHyNDnsqYSex8OYiYeGQFiQ2Mg48lON1aBWj2zlY9PrMkMF
wHKxSPpGwom/H3KxXMXDT70beuP+/Yg1mFyv3+zetTdlChw6osCPVyqzkt8HZbC5
o7Pb7KRXgSjzXYGz82Fvcy3Q0xihIyivJvQ09omXXm54k4Sv/KM9fytPh+bWYhF9
oV0ClLP20F6e24mn9jlz6k1UGtfR9GArnXRX9xmJq90pzG6VxLVRaIY8aTlFWyLE
KS3eXHvbU8/UTNy3BIcyjJ7PgqMmkHe0OFfMoNxjtQ1zW5Dx/mKNnrl5rEfv8gi9
IrZJAthKdxjJde0u2x5MRj4Ch3aKKQsQmEPdcuGROukUuLRwG/3Xqgba0WFxxgX/
4cbKSk/yQrNo/UejUeV0kwe5nead4kOCmny3XaL6URWDXu7874Y8MpLF6JUE5RsF
/Drwvi4lkoQTqH80/tFzo6kCAwEAAQ==
-----END PUBLIC KEY-----";

    private $privkeyRSA="-----BEGIN PRIVATE KEY-----
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
WI+zRCXlxS4ad8jXbL1HfXzP+pQKq+Kw
-----END PRIVATE KEY-----";

//    private $pubkeyRSA="MIICCgKCAgEAx765AUcFCIfgD/rYXL/W5ip144cEFXgdnRsSysOOSQVp9vRBsY7il65ygkTxh+gVoc1GEDrI6IPQ/bUR4aFX3LqdmSD8qYR7wZXDh30cCtnHzMLUOZrdScZaXa0S6vAx+XUpZQ3W5uUfvbuSML0lM/Z9Eb1+hDqzKUeSXc9LWru7xpOuaau94BebAA5bUxwJWpJh3in6EI4qboZ6ReQWZgcilQWce99Sxe7QauRXcGJbr1QX0Qx9qiPHfmyXbCIPNe+yYjVw3jieWWXZdZaWaPxM3U+PyefOdtt0Mr9t8vF8QUNB8LUxFKtELo3pU4bj/jczURIvMsdriJkq7aTxVvtEf5+0pukIj+gby0l6mMnlpMDSzCIDUWNbYh+9xph23ZMwBl0GL9H6OBwQDzaclaHisl2fiLG9KFuh4ab90bnakPUCp1BrJ1WuuE0YyLE13DD1PVuqqDQfo4e4fXEjbSM0TYRCa+JncGZOEGKZLepay6VfcAVMMsIoz3YSm9gj6t2NHloRbYW3FcPHsw+CccU7koSCrRG6ox6MWUBMJ1GBURQZ7fVVyFlew+FHVtZ829oVUTxoVlxpN1CGw60QFnZZ/tDJtPW7gAfurdTNpfOj124UOj/h8rbVDIMFW2gsA8La+scHLu1doHe/Mn2MjOF6EGtHXsbY275JBgpOuPMCAwEAAQ==";
//    private $privkeyRSA="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";

    private $privkeyRSA512="-----BEGIN PRIVATE KEY-----
MIIBVQIBADANBgkqhkiG9w0BAQEFAASCAT8wggE7AgEAAkEA5rubf82rFMhEZrJn
1BfzE46a4eHFBAGqFtYh+Fg2AFJeXSEbA9tugB3djW5l48B6gN4f51ux6h32LZD5
vjM/mQIDAQABAkB9q2sbZfqrfBR9VuhkRZMYcNB8/Qngj8ODYqfn6qum6i06n/3M
C9gmP0iNo7xXMTYIKrUTxGDxCVFM3lYxIoGBAiEA+ED0BUfNyrVeyOuF4ck4dq15
ABPdq5xDncoM65w2jVECIQDt7rKbmOnmpcPfckcc+P3eZJ7BeDZsOHqXV5PIXlrb
yQIhALLnNDO9/DsyG32V5aTCOxOjjgiVSHFMqpnCqy78I4ARAiAFenqIVKQGGIkD
CxmSFDWcOkrhf4gZQ8+mznBrq6iB6QIhALkZwywJtc3DtObNnyI5IWuOB5qPz92N
XOGHZOT12HSW
-----END PRIVATE KEY-----";
private $pubkeyRSA512="-----BEGIN PUBLIC KEY-----
MFwwDQYJKoZIhvcNAQEBBQADSwAwSAJBAOa7m3/NqxTIRGayZ9QX8xOOmuHhxQQB
qhbWIfhYNgBSXl0hGwPbboAd3Y1uZePAeoDeH+dbseod9i2Q+b4zP5kCAwEAAQ==
-----END PUBLIC KEY-----";

    // Hold the class instance.
    private static $instance = null;

    // The constructor is private
    // to prevent initiation with outer code.
    private function __construct()
    {
        // The expensive process (e.g.,db connection) goes here. = $dbConnection;
        $this->db = DatabaseConnector::getInstance()->getConnection();
        $this->baseAPIUrl = getenv('BASE_API_URL');
    }

    // The object is created from within the class itself
    // only if the class has no instance.
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Configuration();
        }

        return self::$instance;
    }

    public function getConnection()
    {
        return $this->db;
    }

    public function getBaseAPIURL()
    {
        return $this->baseAPIUrl;
    }

    /**
     * @return mixed
     */
    public function getPubkeyRSA()
    {
        return $this->pubkeyRSA;
    }

    /**
     * @return mixed
     */
    public function getPrivkeyRSA()
    {
        return $this->privkeyRSA;
    }



    public function defaultHeader()
    {
        $headers = array("Access-Control-Allow-Origin: *",
            "Content-Type: application/json; charset=UTF-8",
            "Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE",
            "Access-Control-Max-Age: 3600",
            "Access-Control-Allow-Headers: Content-Type",
            "Access-Control-Allow-Headers, Authorization, X-Requested-With");
        return $headers;
    }
}
