<?php

require_once __DIR__.'/vendor/autoload.php';

use Dotenv\Dotenv;

/**
 * Class GoogleSheetsAPISample
 */
class GoogleSheetsAPISample {

    /**
     * @var Google_Service_Sheets
     */
    protected $service;

    /**
     * @var array|false|string
     */
    protected $spreadsheetId;

    /**
     * GoogleSheetsAPISample constructor.
     */
    public function __construct()
    {
        $dotenv = new Dotenv(__dir__);
        $dotenv->load();
        $credentialsPath = getenv('SERVICE_KEY_JSON');
        putenv('GOOGLE_APPLICATION_CREDENTIALS=' . dirname(__FILE__) . '/' . $credentialsPath);

        $this->spreadsheetId = getenv('SPREADSHEET_ID');

        $client = new Google_Client();
        $client->useApplicationDefaultCredentials();
        $client->addScope(Google_Service_Sheets::SPREADSHEETS);
        $client->setApplicationName('test');

        $this->service = new Google_Service_Sheets($client);
    }

    /**
     * @param string $date
     * @param string $name
     * @param string $comment
     */
    public function append(string $date, string $name, string $comment)
    {
        $value = new Google_Service_Sheets_ValueRange();
        $value->setValues([ 'values' => [ $date, $name, $comment ] ]);
        $response = $this->service->spreadsheets_values->append($this->spreadsheetId, 'シート1!A1', $value, [ 'valueInputOption' => 'USER_ENTERED' ] );

        var_dump($response);
    }
}

$sample = new GoogleSheetsAPISample;

$date    = date('Y/m/d');
$name    = '山川のりを';
$comment = 'ギターうまい';
$sample->append($date, $name, $comment);









