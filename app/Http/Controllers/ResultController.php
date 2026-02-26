<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function showResult() {
        $url1 = "https://www.meddean.luc.edu/lumen/meded/medicine/pulmonar/cxr/atlas/images/71bl.jpg";
        $url2 = "https://litfl.com/wp-content/uploads/2018/05/CXR-CASE-150-CXR-LITFL.jpg";
        $url3 = "https://preview.redd.it/added-a-gradient-map-over-a-recent-chest-x-ray-with-v0-568p21pwugle1.jpg?width=1080&crop=smart&auto=webp&s=d406b81e673512baf4b4c4a2bb9831e595f9d31b";

        try {
            $imageData1 = file_get_contents($url1);
            $imageData2 = file_get_contents($url2);
            $imageData3 = file_get_contents($url3);
            $base64_1 = 'data:image/jpg;base64,' . base64_encode($imageData1);
            $base64_2 = 'data:image/jpg;base64,' . base64_encode($url2);
            $base64_3 = 'data:image/jpg;base64,' . base64_encode($url3);
        } catch (\Exception $e) {
            $base64_1 = "";
            $base64_2 = "";
            $base64_3 = "";
        }

        return view('result', [
            'image1_url' => $base64_1,
            'image2_url' => $base64_2,
            'image_change_map_url' => $base64_3,
            ]);
    }
}
