<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Google_Spreadsheet;

class VictoryGroupController extends Controller
{
    /**
     * Update Victory Group data
     *
     * @param Request $request
     * @return void
     */
    public function update(string $gSheetId, string $leaderName, Request $request)
    {
        $googleSheetId     = $gSheetId;
        $client            = $this->getGoogleClient();
        $vgData            = $request->vgData;
        $counter           = 2;

        // Get the sheet instance by sheets_id and sheet name
        $sheet = $client->file($googleSheetId)->sheet($leaderName);

        foreach ($vgData as $data) {
            $flatData = collect($data)->flatten()->all();

            // Update cells starting from row 2
            $sheet->edit($counter, 1, $flatData);
            $counter++;
        }

        return back();
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
