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
        $sheet = $client->file($googleSheetId)->sheet('Leaders Metadata');
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

        return Inertia::render(
            'Dashboard/DashboardIndex', 
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


        return Inertia::render(
            'VictoryGroup/VictoryGroupIndex', 
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
