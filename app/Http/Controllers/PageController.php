<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

use Google_Spreadsheet;

class PageController extends Controller
{

    /**
     * Show index page
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        $googleSheetId = $this->getGoogleSheetId();
        $client        = $this->getGoogleClient();

        // Get the sheet instance by sheets_id and sheet name
        $sheet = $client->file($googleSheetId)->sheet('Leaders Metadata');;
        // Fetch data without cache
        $leadersOptions = [];
        $leadersData    = $sheet->fetch(true)->items;
        
        foreach ($leadersData as $data) {
            $vgLeaders = $data["VG Leaders"];
            $vgLeaders = explode("\n", $vgLeaders);
            
            foreach($vgLeaders as $vgLeader) {
                $tempData = [
                    'vgLeader' => $vgLeader,
                    'lgLeader' => $data["LG Leader"],
                    'gSheetId' => $data["GSheet ID"]
                ];

                $leadersOptions[] = $tempData;
            }
        
        }

        // if (empty($items)) return json_encode([]);

        // $givingData = [];

        // // Build data
        // foreach ($items as $key => $item) {

        //     if ($item['Date Acknowledged'] != '') {
        //         continue;
        //     }

        //     $processedData = [
        //         'emailTo'       => $item['Email'],
        //         'fullName'      => $item['Name'],
        //         'firstName'     => $item['First Name'],
        //         'total'         => $item['Total'],
        //         'timestamp'     => Carbon::createFromFormat('m/d/Y G:i:s', $item['Timestamp'])->format('M j, Y'),
        //         'givingMethod'  => $item['Giving Method'],
        //         'givingDetails' => []
        //     ];

        //     $keys = array_keys($item);

        //     $beginTrackingDetails = false;
        //     // Ignore last column which is 'Total'
        //     for ($i = 0; $i < count($keys) - 1; $i++) {

        //         // Track if ready to track giving details
        //         if ($keys[$i] == 'Giving Method') {
        //             $beginTrackingDetails = true;
        //             continue;
        //         }

        //         // Ignore empty column headers
        //         if (trim($keys[$i]) == '') {
        //             continue;
        //         }

        //         if ($beginTrackingDetails) {
        //             if (empty($item[$keys[$i]])) continue;

        //             // Type of Giving, Amount
        //             $processedData['givingDetails'][] = [
        //                 $keys[$i],
        //                 number_format(
        //                     (float)preg_replace('/[^0-9.]/', '', $item[$keys[$i]]), 
        //                     2
        //                 )
        //             ];
        //         }
        //     }

        //     $givingData[] = $processedData;

        // }

        // return json_encode($givingData);

        return Inertia::render(
            'Dashboard/Index', 
            ['leadersOptions' => $leadersOptions]
        );
    }


    /**
     * Show page for accessing Victory Group data
     *
     * @param Request $request
     * @return void
     */
    public function showVictoryGroupData(string $gSheetId, string $leaderName)
    {
        $googleSheetId = $gSheetId;
        $client        = $this->getGoogleClient();

        // Get the sheet instance by sheets_id and sheet name
        $sheet = $client->file($googleSheetId)->sheet($leaderName);

        $vgData = $sheet->fetch(true)->items;;

        // dd($vgData);

        return Inertia::render(
            'Dashboard/VictoryGroupData', 
            ['data' => $vgData]
        );
    }

    /**
     * Get Google client
     *
     * @return Google_Spreadsheet_File
     */
    private function getGoogleClient()
    {
        return Google_Spreadsheet::getClient(storage_path().'/app/victory-lb-service-account-key.json');
    }

    /**
     * Get Google client
     *
     * @return string
     */
    private function getGoogleSheetId()
    {
        $googleSheetId = env('GOOGLE_SPREADSHEET_ID', false);

        return ($googleSheetId) ? ($googleSheetId) : abort(404);
    }

}
