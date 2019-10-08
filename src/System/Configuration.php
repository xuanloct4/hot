<?php

namespace Src\System;

class Configuration
{
    private $db;
    private $baseAPIUrl;
    private $pubkeyRSA="-----BEGIN PUBLIC KEY-----
MIICIjANBgkqhkiG9w0BAQEFAAOCAg8AMIICCgKCAgEA9YR326YAP0Q3kTTKSb5X
3yV2hdz4tQc/L/Kr2fRt5OMuZyOIz3YqtbTBTuZcAlxl/sBQjBknj1UbWhRqbspz
utESn7SqLkJx9ItiNSy2PUIhCMPr4M/Z9h86NnZNzjlf+ef5vDGEUzRpy0NFpRFo
a82vBiXVX1Rd3KMtq9rr5Pw8jyySj8Ac703umd4GlW3rZ8XKLj5jKthDf9p5riks
tUqT0Y7qRtVR5AExTIMGEiYhi1JOoE4GF4BRZq/Mu5b3x7DNu+aFDfX2Ihj9zL5G
Z08IfRGjjMXhLuWafbhTcvpLD9SDmEYwKnnnUiL1Dt4TtulCEFyHipr/OPcCmLKK
Wv2JfcQ1q9XjcYk7oC+rk3qPoVXRDJeJkzNrFWMw+03nvvg5KZPbWyKd1NquphZx
68IdtTthhrz1cpTr54/QLxI3UW6JtUVzSTGjEzgJuiY48ymkBundi2t+KoFGAS1I
kHpIMTk8yr4Y2VtJUOu1RLP9Xf1vGmfYvsVuV7tAu6aFWoVbc10nfYrQ0VzAvlGp
6czRgrfYRjL+75HndRY26DHRGPKz7ITnos2lldv7uXS7P16qxAlTdEEXppWwwFzr
xcVtHBR+ztNSqpoR2vx68/tPodWktzA+EIaCJ44RMpF3kd80ePXQY/HoadTq+ud6
CAcc2BuE+J7g/FcSHtRkX9kCAwEAAQ==
-----END PUBLIC KEY-----";
    private $privkeyRSA="-----BEGIN PRIVATE KEY-----
MIIJRAIBADANBgkqhkiG9w0BAQEFAASCCS4wggkqAgEAAoICAQD1hHfbpgA/RDeR
NMpJvlffJXaF3Pi1Bz8v8qvZ9G3k4y5nI4jPdiq1tMFO5lwCXGX+wFCMGSePVRta
FGpuynO60RKftKouQnH0i2I1LLY9QiEIw+vgz9n2Hzo2dk3OOV/55/m8MYRTNGnL
Q0WlEWhrza8GJdVfVF3coy2r2uvk/DyPLJKPwBzvTe6Z3gaVbetnxcouPmMq2EN/
2nmuKSy1SpPRjupG1VHkATFMgwYSJiGLUk6gTgYXgFFmr8y7lvfHsM275oUN9fYi
GP3MvkZnTwh9EaOMxeEu5Zp9uFNy+ksP1IOYRjAqeedSIvUO3hO26UIQXIeKmv84
9wKYsopa/Yl9xDWr1eNxiTugL6uTeo+hVdEMl4mTM2sVYzD7Tee++Dkpk9tbIp3U
2q6mFnHrwh21O2GGvPVylOvnj9AvEjdRbom1RXNJMaMTOAm6JjjzKaQG6d2La34q
gUYBLUiQekgxOTzKvhjZW0lQ67VEs/1d/W8aZ9i+xW5Xu0C7poVahVtzXSd9itDR
XMC+UanpzNGCt9hGMv7vked1FjboMdEY8rPshOeizaWV2/u5dLs/XqrECVN0QRem
lbDAXOvFxW0cFH7O01KqmhHa/Hrz+0+h1aS3MD4QhoInjhEykXeR3zR49dBj8ehp
1Or653oIBxzYG4T4nuD8VxIe1GRf2QIDAQABAoICAQDKRVWd73hapzAEgHJ8KMYq
QKoSBQgd1JeZQBuXGEqFfSlYrazkBt2PEBkGkMCS7V7Wb8isc3jlHF/JafJ5zm9k
JSVr0CM4s2NA7qh9WJXXiCjBGPC3KWbP39BM2FCnqxtIP3a/NihniFH0tTqmkN3v
mugsb3UH8fDWetWAtX8NC0Y1SqqApezwtsrxlzrjV0jPGOPGD34R6VRK/EqtUpzT
y1pXFqAqtUqfRuA/wd55i1KtfqTqav2X1Q67Q/CvR+Rhb2c/+934r4AVfXNzf/tu
120N5T9SFiC8S0tpcjfGDTFUHGhCRukdxYrvX393vTyOwEO+SQ0eAy5r1w0bklRq
n0Y3/6MfcCPWM7pfbAEwfhbSJjpK9TSlNb5PyFcS2v05XR7kVRF6T3ywX4QxIITC
KTvpi9bde/ayGv5ouj5Bj4usL1FNDTvrKsq6frJyshUNDtU8ZApffl+gf8Ap28ik
SeMwrUNyE9mCAV7GqjV9PX1za1MUwCoiXUMSsuTo4RxmQ5o+ymHsW6w9JRIh4WGS
4k/nqosLBdR+VmaPZK8fE9rg9wbdf2AnhUzh9AAS4ONNecDvfZhzjXppUDpVGV1C
uARL9wCy8DhxpiCeI2o26H2suq1mHwfJ/4i5TroVLxQdT7h71ZIRUQJ+mk9vqpsB
FvkXuJ4EX1i/IiQjtxD6RQKCAQEA/H9VR9yf7N1YttInk6zIDc+ZProM3SpusW/z
D+G03NM1dPxx0YnvA7YG0ebeSSQMJDqpx53uJnguynvXXYW1Ia1w1MTGru3+scyu
z7El4436c2jiqbCApEKoGvJ6Id2JIgpp9Hy8cmoATWhBD8a4aOMHr7PhU/MeOIxy
sdUy1h3BqgE0ZsvfUNh1sDukr6emIay4Pox4nMwawP5/LrqHI361aom6u7gyFM8o
ExxWVsRcShoi/nKpImHtcKr8ziA0xaYLlZdI6qAvuMXYA1qnhwBid+/UbC1LYXuH
bP+36shNgMjIXPOhH4STvMGNFZSUV45v8Wsj+NiYGa5bk/vcqwKCAQEA+OxZE2ld
rHYP/HD+tRL8Vw1cqpAXn0DDRSp4ItlVQN/eVq5zh/jKV1KoG3L83lwBFztn2liX
c2NhpNFAvXbJBFGDbadEsD4fEeZwunY5l/1gKMaqFp58aSidnQFUGCCVlmwDbygE
lrPjfFvHDQmNepMltK//8+S0bwYlsxYppAij49UXtKdOOQTgSvq89etQniJqZJKx
cVAn4pYVKHkh5rVAbC/X+8SKzoqn8oodTjYp1w2r8yhJokXtg7zNaDLnYqO3vHLi
0ioZq4r8K01gv6zl0bLQleKYCeDRlYh39Q7Ns/Xeh/bxfZnpzhx07U/3x7BcdtOm
L7FWh0EEy4ytiwKCAQEAtNkO3/WppiGz1N4Y8rCiaSH0BPWFGTO3LOeeFBX5UOEG
PNBDRW2h/+p0YAsX0xM6jwhlalA3rt4NxYGF87o8ze5IDl0SYWCdOAP+gUvEc4PR
iq/pCNkeiogjl4ls6Kyf9/21fiOJZfl+VfMCBqaylo1lh/cywMo1LxOJYs3tJ2cQ
uw851RbY0DL5uEw/3IAbgasQG9zI1qVp1Cl0Nqfq+wVaMwCK+sEnPbhSX73AKU1j
PMATqGO/uJyjUDtn7ssqgRY43eAJneM1ywYJff2EWDFyVa01XHXks+GiUfOma0ck
G8WznL/y+3wdxOhsgLR2u2+NxkCS9z1LU7mKZifTGQKCAQEA8/tU473m3t9pk9l9
DiZpxzmFlnhdbu6fdu/FiQLUmR3UY8nh22hzi1utAhqW16v+NbM4e79R0vuZ/V5M
wmfnZ6At3hCRNt3svjLMUzcGBH+I/O6cUEdPUhNJSVbAAlYNyL5eL1leBgiT9JRQ
aervDTGlR5EqoveMEzZHRV13uxvs56c58Qv7k8+/uD5DcBcRka3R8noGCjayoVjR
rDXukJ8fYesTG+bs1rz5GLVfPAXCxNLVsyPN6Iv53aH1AyjBuuEVelRxFeXF+2ni
+N6C8dyZ9gv6fq72rtf5FUQJr9yuqrFXSJU25hEyJZ+my+QRzVyDhMS2oxCC61dD
R++/OQKCAQBdJboqhdO5TxI+qv0SbSEYfaD2J3JPotPGrBGldav87+VDe8HqtzvI
fjD9BJxjVk2O4Bf5MP8/jY2hAu5nOXyNet6J1ENnhOEv0mxrhrpL9h1RxNM8wEow
b+QkcdDZw1+zet7Pd0S5DaXCKv08SV9yZ6WrLqCcBmoHrKuEQ2wFG1VZEUjBcutU
OjPbjHT3toszo6E5nrxnj5PaPtJl0UeJd2YSLXW+K6yXCx+CkvxNonqyTBtCsN0L
bC6Mg7L6rlcTHvLs0NDnYJ4h9dPYZf9GtaP+Omn9ZGP96R4J59Ea5OC8JP39AOVb
QHEmbi4XQZQdiwTArHcQe16wkDJUoLvw
-----END PRIVATE KEY-----";

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
