<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use File;
use App\Imports\ProdInfoImport;
use App\Models\ProdInfo;
use App\Models\BasicInfo;
use Illuminate\Support\Facades\Storage;

ini_set('memory_limit', '1256M');
set_time_limit(100000);

class ImportController extends Controller
{
    public function importFromProd ()
    {
        ProdInfo::truncate();
        Excel::import(new ProdInfoImport, 'grability.csv', 'public');
        return "Datos de producción importados";
    }

    public function importFromBasicInfo ()
{
    BasicInfo::truncate();

    $basicInfoPath = storage_path('app/public/basic-info/*/');

    $data = [];

    $files = glob($basicInfoPath . "*.txt");
    $files = array_reverse($files);

    foreach ($files as $file) {
        $file_handle = fopen($file, "r");
        while (!feof($file_handle)) {
            $line = fgets($file_handle);

            preg_match('/"product_id":"([^"]+)___/', $line, $productIdMatch);
            if(isset($productIdMatch[1])){
                if(substr($productIdMatch[1], 0, 5) != '01052'){
                    preg_match('/"management_type":"([^"]+)"/', $line, $managementTypeMatch);
                    preg_match('/"description":"([^"]+)"/', $line, $descriptionMatch);
                    preg_match('/"principal_image":"([^"]+)"/', $line, $principalImageMatch);
    
                    $pathInfo = pathinfo($file);
                    $folderPath = $pathInfo['dirname'];
                    $lastSlashPosition = strrpos($folderPath, '/');
                    $folderName = substr($folderPath, $lastSlashPosition + 1);
                    
                    if ($productIdMatch && $managementTypeMatch && $descriptionMatch && $principalImageMatch) {
                        $existingIndex = array_search($productIdMatch[1], array_column($data, 'reference'));
    
                        if ($existingIndex === false) {
                            $data[] = [
                                'reference' => $productIdMatch[1],
                                'management_type' => $managementTypeMatch[1],
                                'description' => $descriptionMatch[1],
                                'principal_image' => $principalImageMatch[1],
                                'folder' => $folderName
                            ];
                        }
                    }
                }
            }
        }
        fclose($file_handle);
    }
        
        foreach ($data as $item) {
            BasicInfo::create([
                'reference' => substr($item['reference'], 3),
                'management_type' => $item['management_type'],
                'description' => $item['description'],
                'principal_image' => $item['principal_image'],
                'folder' => $item['folder'],
            ]);
        }

        return "Datos de Basic-info importados";
    }
}
