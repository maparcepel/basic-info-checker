<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProdInfo;
use App\Models\BasicInfo;

ini_set('memory_limit', '1256M');

set_time_limit(100000);

class CheckController extends Controller
{
    public function check () {
        $basicInfos = BasicInfo::select('reference', 'management_type', 'description', 'principal_image', 'folder')->get();

        $prodInfos = ProdInfo::select('reference', 'management_type', 'description', 'principal_image')->get();
        
        $counter = 0;

        $checked = 0;

        foreach ($basicInfos as $basicInfo) {
            $checked++;
            $prodInfo = $prodInfos->firstWhere('reference', $basicInfo->reference);

            if (!$prodInfo) {
                if(substr($basicInfo->reference, 0, 5) != '01495'){
                    $counter++;
                    echo $counter . "\n";
                    echo "Discrepancias en " . $basicInfo->reference . "\n";
                    echo "No existe en producción: " . "\n" . json_encode($basicInfo, JSON_PRETTY_PRINT) . "\n" . "\n";
                }
            } else {
                if ($prodInfo != null) {
                    $managementTypeDiscrepancy = false;
                    $descriptionDiscrepancy = false;
    
                    if ($basicInfo->management_type != $prodInfo->management_type) {
                        $managementTypeDiscrepancy = true;
                    }
    
                    if ($basicInfo->description != $prodInfo->description) {
                        $descriptionDiscrepancy = true;
                    }
    
                    if($managementTypeDiscrepancy || $descriptionDiscrepancy) {
                        $counter++;
                        echo $counter . "\n";
                        echo $basicInfo->reference . "\n";
                        if($managementTypeDiscrepancy){
                            echo "  TG Basic-info: " . $basicInfo->management_type . "\n";
                            echo $prodInfo->reference . "\n";
                            echo "  TG  Producción: " . $prodInfo->management_type . "\n";
                        }
                        if($descriptionDiscrepancy){
                            echo "  Descripción Basic-info: " . $basicInfo->description . "\n";
                            echo $prodInfo->reference . "\n";
                            echo "  Descripción Producción: " . $prodInfo->description . "\n";
                        }
                        echo "Folder: " . $basicInfo->folder . "\n";
                        echo "\n";
                    }
                }
            }
        }    
        echo 'Referencias de Basic-info comprobadas: ' . $checked . "\n";
    }

    public function checkManagementType () {
        $basicInfos = BasicInfo::select('reference', 'management_type', 'folder')->get();

        $prodInfos = ProdInfo::select('reference', 'management_type')->get();
        
        $counter = 0;

        foreach ($basicInfos as $basicInfo) {
            if(substr($basicInfo->reference, 0, 2) != '52'){
                $prodInfo = $prodInfos->firstWhere('reference', $basicInfo->reference);

                if (!$prodInfo && substr($basicInfo->reference, 0, 5) != '01495') {
                    $counter++;
                    echo $counter . "\n";
                    echo "Discrepancias en " . $basicInfo->reference . "\n";
                    echo "No existe en producción: " . "\n" . json_encode($basicInfo, JSON_PRETTY_PRINT) . "\n" . "\n";
                } else{
                    if ($prodInfo != null) {
                        if($basicInfo->management_type != $prodInfo->management_type) {
                            $counter++;
                            echo $counter . "\n";
                            echo "Discrepancias en TG " . $basicInfo->reference . "\n";
                            echo "  Basic-info: " . $basicInfo->management_type . "\n";
                            echo $prodInfo->reference . "\n";
                            echo "  Producción: " . $prodInfo->management_type . "\n";
                            echo "Folder: " . $basicInfo->folder . "\n";
                            echo "\n";
                        }
                    }
                }
            }
        }  
    }
}
