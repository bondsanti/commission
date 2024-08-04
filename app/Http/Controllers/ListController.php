<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Auth;

class ListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index(Request $request)
    {


        $projects = $this->getProject();
        // dd($projects);


        return view('pages.lists.index', [
            'projects' =>  $projects
        ]);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function search(Request $request)
    // {
    //     $url_api = env('API_URL');
    //     $token = env('API_TOKEN_AUTH');

    //     $data = [];
    //     $formInputs = $request->all();

    //     // Convert dates in formInputs
    //     array_walk($formInputs, function (&$value, $key) {
    //         if (in_array($key, ['startdate', 'enddate'])) {
    //             $value = date('Y-m-d', strtotime(str_replace('/', '-', $value) . ' - 543 years'));
    //         }
    //     });

    //     $projects = $this->getProject();
    //    // dd($formInputs);

    //     if (Auth::user()->role()->name == 'Admin') {
    //         try {
    //             $url = $url_api . "/get-product";

    //             $headers = [
    //                 'Authorization: Bearer ' . $token,
    //                 'Content-Type: application/json',
    //             ];

    //             $ch = curl_init();
    //             curl_setopt($ch, CURLOPT_URL, $url);
    //             curl_setopt($ch, CURLOPT_POST, true);
    //             curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($formInputs));
    //             curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    //             curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    //             $response = curl_exec($ch);
    //             // dd($response);
    //             if ($response === false) {
    //                 $error = curl_error($ch);
    //                 throw new \Exception("cURL Error: " . $error);
    //             }

    //             curl_close($ch);

    //             $responseData = json_decode($response, true);
    //             $data = collect($responseData['data']);

    //             return view('pages.lists.search', [
    //                 'data' => $data,
    //                 'projects' =>  $projects,
    //                 'formInputs'=>$formInputs
    //             ]);
    //         } catch (\Exception $e) {
    //             return view('pages.lists.search', [
    //                 'data' => $data,
    //                 'projects' =>  $projects,
    //                 'formInputs'=>$formInputs
    //             ]);
    //         }
    //     } else {
    //         $formInputs['code'] = Auth::user()->code;
    //         $formInputs['old_code'] = Auth::user()->old_code;
    //         //dd($code);
    //         try {

    //             $url = $url_api . "/get-product";

    //             $headers = [
    //                 'Authorization: Bearer ' . $token,
    //                 'Content-Type: application/json',
    //             ];

    //             // $postData = [
    //             //     'code' => $code,
    //             //     'old_code' => $old_code,
    //             // ];

    //             $ch = curl_init();
    //             curl_setopt($ch, CURLOPT_URL, $url);
    //             curl_setopt($ch, CURLOPT_POST, true);
    //             curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($formInputs));
    //             curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    //             curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    //             $response = curl_exec($ch);
    //             //dd($response);
    //             if ($response === false) {
    //                 $error = curl_error($ch);
    //                 throw new \Exception("cURL Error: " . $error);
    //             }

    //             curl_close($ch);

    //             $responseData = json_decode($response, true);
    //             $data = collect($responseData['data']);




    //             return view('pages.lists.search', [
    //                 'data' => $data,
    //                 'projects' =>  $projects,
    //                 'formInputs'=>$formInputs
    //             ]);
    //         } catch (\Exception $e) {
    //             return view('pages.lists.search', [
    //                 'data' => $data,
    //                 'projects' =>  $projects,
    //                 'formInputs'=>$formInputs
    //             ]);
    //         }
    //     }
    // }
    public function search(Request $request)
    {
        $url_api = env('API_URL');
        $token = env('API_TOKEN_AUTH');

        $data = [];
        $formInputs = $request->all();

        // Convert dates in formInputs
        array_walk($formInputs, function (&$value, $key) {
            if (in_array($key, ['startdate', 'enddate'])) {
                $value = date('Y-m-d', strtotime(str_replace('/', '-', $value) . ' - 543 years'));
            }
        });

        $projects = $this->getProject();
        // dd($projects);
        //dd($formInputs);
        try {
            $url = $url_api . "/get-product";
            // dd($url);
            $headers = [
                'Authorization: Bearer ' . $token,
                'Content-Type: application/json',
            ];

            if (Auth::user()->role()->name == 'Admin') {

            } else {
                $formInputs['code'] = Auth::user()->code;
                $formInputs['old_code'] = Auth::user()->old_code;
            }



            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($formInputs));
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($ch);
           // dd($response);
            if ($response === false) {
                $error = curl_error($ch);
                throw new \Exception("cURL Error: " . $error);
            }

            curl_close($ch);

            $responseData = json_decode($response, true);
            $data = collect($responseData['data']);

            return view('pages.lists.search', [
                'data' => $data,
                'projects' => $projects,
                'formInputs'=> $formInputs 
            ]);
        } catch (\Exception $e) {
            return view('pages.lists.search', [
                'data' => $data,
                'projects' => $projects,
                'formInputs'=> $formInputs 
            ]);
        }
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getListAdmin()
    {
        try {
            //$url = "https://vbnext.vbeyond.co.th/api/get-admin/list"; // URL ของ API ที่ต้องการเรียกใช้
            $url = "http://127.0.0.1:8000/api/get-admin/list"; // URL ของ API ที่ต้องการเรียกใช้

            $headers = [
                'Authorization: Bearer ' . $this->token,
                'Content-Type: application/json',
            ];

            // สร้าง cURL resource
            $ch = curl_init();

            // กำหนด URL ของ API
            curl_setopt($ch, CURLOPT_URL, $url);

            // กำหนดว่าจะใช้ Method GET
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

            // กำหนด Header ที่จะส่งไปยัง API
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            // ตั้งค่าให้ cURL รองรับการรับค่าผลลัพธ์กลับมา
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            // ส่งคำขอไปยัง API และรับผลลัพธ์
            $response = curl_exec($ch);

            // ตรวจสอบว่ามีข้อผิดพลาดหรือไม่
            if ($response === false) {
                $error = curl_error($ch);
                throw new \Exception("cURL Error: " . $error);
            }

            // ปิดการเชื่อมต่อ cURL
            curl_close($ch);

            // แปลงผลลัพธ์เป็น JSON หรือข้อมูลที่ต้องการต่อไป
            $responseData = json_decode($response, true);

            // ตรวจสอบว่ามีข้อมูลหรือไม่
            if (empty($responseData)) {
                return response()->json(['message' => 'ไม่พบข้อมูล'], 404);
            }

            // ส่งข้อมูลกลับเป็น JSON หรือข้อมูลที่ต้องการ
            return response()->json(['data' => $responseData], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'เกิดข้อผิดพลาดในการดึงข้อมูล', 'error' => $e->getMessage()], 500);
        }
    }



    public function getList()
    {
        $data = [];

        try {
            $old_code = Auth::user()->old_code;
            $code = Auth::user()->code;
            $url_api = env('API_URL');
            $token = env('API_TOKEN_AUTH');
            // กำหนด URL ของ API
            $url = $url_api . "/get-users/list/{$code},{$old_code}";

            $headers = [
                'Authorization: Bearer ' . $token,
                'Content-Type: application/json',
            ];

            // สร้าง cURL resource
            $ch = curl_init();

            // กำหนด URL ของ API ให้กับ cURL
            curl_setopt($ch, CURLOPT_URL, $url);

            // กำหนดว่าจะใช้ Method GET
            curl_setopt($ch, CURLOPT_HTTPGET, true);

            // ตั้งค่าให้ cURL รองรับการรับค่าผลลัพธ์กลับมา
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            // ส่งคำขอไปยัง API และรับผลลัพธ์
            $response = curl_exec($ch);

            // ตรวจสอบว่ามีข้อผิดพลาดหรือไม่
            if ($response === false) {
                $error = curl_error($ch);
                throw new \Exception("cURL Error: " . $error);
            }

            // ปิดการเชื่อมต่อ cURL
            curl_close($ch);

            // แปลงผลลัพธ์เป็น JSON หรือข้อมูลที่ต้องการต่อไป
            $responseData = json_decode($response, true);

            // ตรวจสอบว่ามีข้อมูลหรือไม่
            if (empty($responseData)) {
                return response()->json(['message' => 'ไม่พบข้อมูล'], 404);
            }

            // ส่งข้อมูลกลับเป็น JSON หรือข้อมูลที่ต้องการ
            return response()->json(['data' => $responseData], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'เกิดข้อผิดพลาดในการดึงข้อมูล', 'error' => $e->getMessage()], 500);
        }
    }


    public function getProject()
    {

        $url_api = env('API_URL');
        $token = env('API_TOKEN_AUTH');

        try {
            $url = $url_api . "/get-project";

            $headers = [
                'Authorization: Bearer ' . $token,
                'Content-Type: application/json',
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPGET, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($ch);

            if ($response === false) {
                $error = curl_error($ch);
                throw new \Exception("cURL Error: " . $error);
            }

            curl_close($ch);

            $responseData = json_decode($response, true);

            //dd($responseData); // ใช้เพื่อดูข้อมูลที่ได้รับ

            if (empty($responseData) || !isset($responseData['data'])) {
                return [];
            }

            return $responseData['data'];
        } catch (\Exception $e) {
            return [];
        }
    }
}
