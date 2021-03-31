<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

use Google_Spreadsheet;

class PageController extends Controller
{

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        $data = [
            'fname' => 'Evan',
            'lname' => 'Tolorio'
        ];

        // $googleSheetId = $request->googleSheetId;
        $googleSheetId = env('GOOGLE_SPREADSHEET_ID', false);

        if (!$googleSheetId) return response(404);

        $client = Google_Spreadsheet::getClient(storage_path().'/app/victory-lb-service-account-key.json');


        // Get the sheet instance by sheets_id and sheet name
        $sheet = $client->file($googleSheetId)->sheet('Leaders Metadata');;
        // Fetch data without cache
        $items = $sheet->fetch(true)->items;

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
        
        dd($items);

        return Inertia::render(
            'Dashboard/Index', 
            ['sheets' => $sheets]
        );
    }
}
