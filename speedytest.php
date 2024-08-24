<?php
include_once("session.php");
include_once("storage/CacheFile.php");

abstract class CourierConnector
{
    protected $username = "";
    protected $password = "";
    protected $countryID = -1; // Bulgaria

    protected $language = "BG";

    protected $baseURL = "";

    public function __construct()
    {

    }

    abstract public function getCityAll() : string;
    abstract public function getOffices(int $cityID) : array;
    abstract public function updateCityData(string& $data) : void;

    protected function doRequest(string $apiURL, array $requestData) : string
    {
        #-> Initiate cURL.
        $curl = curl_init($apiURL);

        #-> Encode the array into JSON.
        $jsonData = json_encode($requestData);

        #-> Tell cURL that we want to send a POST request.
        curl_setopt($curl, CURLOPT_POST, 1); // POST
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // Stop showing reusults on the screen
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5); // The number of seconds to wait while trying to connect. Use 0 to wait indefinitely.

        #-> Attach our encoded JSON string to the POST fields.
        curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonData);

        #-> Set the content type to application/json
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        $response = curl_exec($curl);

        if ($response === FALSE) {
            throw new RuntimeException(curl_error($curl));
        }

        return $response;
    }

    protected function getJSON(string $data) : array
    {
        return json_decode($data, true);
    }
}
class EkontConnector extends CourierConnector
{
    public function __construct()
    {
        parent::__construct();
        //$this->username = "iasp-dev";
        //$this->password = "1Asp-dev";
        $this->baseURL = "https://demo.econt.com/ee/services/Nomenclatures/NomenclaturesService.";
        $this->countryID = "BGR";

        //production
        //http://ee.econt.com/services/Nomenclatures/NomenclaturesService.getCities.json
    }

    public function getCityAll() : string
    {
        $url = $this->baseURL."getCities.json";
        $data = array(
            //'userName' => $this->username,
            //'password' => $this->password,
            'countryCode' => $this->countryID,

        );
        return $this->doRequest($url, $data);

    }

    public function getOffices(int $cityID) : array
    {
        $url = $this->baseURL."getOffices.json";
        $data = array(
            //'userName' => $this->username,
            //'password' => $this->password,
            'countryCode' => $this->countryID,
            'cityID' => $cityID,

        );
        return $this->getJSON($this->doRequest($url, $data));
    }
    public function updateCityData(string& $data) : void
    {
        $dataJson = json_decode($data);
        print_r($dataJson);
    }
}
class SpeedyConnector extends CourierConnector
{

    public function __construct()
    {
        parent::__construct();
        $this->username = "1995548";
        $this->password = "7258274656";
        $this->baseURL = "https://api.speedy.bg/v1/"; // Path to Speedy REST API
        $this->countryID = 100;
    }


    public function getCityAll() : string
    {
        $url = $this->baseURL."location/site/csv/".$this->countryID;
        $data = array(
            'userName' => $this->username,
            'password' => $this->password,
        //    'countryId' => $defaultCountryId,
            'language' => $this->language,
            //'name' => "София"
        );
        return  $this->doRequest($url, $data);
    }

    public function updateCityData(string& $csvdata) : void
    {
        $stream = fopen('data://text/plain;base64,' . base64_encode($csvdata),'r');

        //echo stream_get_contents($stream);
        $row = 1;
        $keyNames = array();
        $result = array();
        while (($data = fgetcsv($stream)) !== FALSE) {
            $num = count($data);
            if ($row == 1) {
                $keyNames = $data;
            }
            else {

                $resultRow = array();
                for ($c=0; $c < $num; $c++) {
                    $resultRow[$keyNames[$c]] = $data[$c];
                }
                $result[] = $resultRow;
            }
            $row++;

        }

    }
    public function getOffices(int $cityID) : array
    {
        $url = $this->baseURL."location/office/";
        $data = array(
            'userName' => $this->username,
            'password' => $this->password,
            'countryId' => $this->countryID,
            'language' => $this->language,
            'siteId' => $cityID,

//            'name' => $search,

        );
        $data = $this->doRequest($url, $data);

        $jsonData = $this->getJSON($data);

        //var_dump($jsonData);
        return $jsonData["offices"];
    }
    protected function getJSON(string $data) : array
    {
        $jsonData = parent::getJSON($data);

        if ( isset($jsonData['error']) )
        {
            throw new RuntimeException($jsonData['error']['message']);
        }

        return $jsonData;
    }
}


//$conn = new SpeedyConnector();
////$conn->getCityAll();
//$result = $conn->getOffices(77195);
//print_r($result);

$conn = new EkontConnector();
$result = $conn->getCityAll();
$conn->updateCityData($result);

//print_r($conn->getOffices(45));

//$result = $conn->getCityAll();
//$cacheFile = new CacheFile("getCities", "EkontData", 1);
//$cacheFile->store($result);
?>
