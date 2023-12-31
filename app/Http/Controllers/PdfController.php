<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Customer;
use App\Models\Main;
use App\Models\OurCompany;
use App\Models\Taj;
use App\Models\Tran;
use Barryvdh\DomPDF\Facade\Pdf;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PdfController extends Controller
{

    function PdfStopALl(Request $request)
  {
    $RepDate = date('Y-m-d');
    $cus = OurCompany::where('Company', Auth::user()->company)->first();

    if ($request->By==1)
      $res=Main::with('Stop')->where('bank_id',$request->bank_id)
        ->has('Stop')
        ->whereHas('stop',function ($q) use($request){
         $q->whereBetween('stop_date',[$request->Date1,$request->Date2]);
        })

        ->get();
    if ($request->By==2)
      $res=Main::with('Stop')->whereIn('bank_id',function ($q) use($request){
        $q->select('id')->from('banks')->where('taj_id',$request->bank_id); })
        ->has('Stop')
        ->whereHas('stop',function ($q) use($request){
          $q->whereBetween('stop_date',[$request->Date1,$request->Date2]);
        })
        ->get();



    if ($request->By==1) {

      $BankName=Bank::find($request->bank_id)->BankName;
      $taj=Bank::find($request->bank_id)->taj_id;
    }
    else {$BankName=Taj::find($request->bank_id)->TajName;$taj=$request->bank_id;}
    $TajAcc=Taj::find($taj)->TajAcc;
    $html = view('PrnView.pdf-stop',
      ['RepTable' => $res, 'cus' => $cus, 'TajAcc' => $TajAcc,'BankName'=>$BankName,'By'=>$request->By])->toArabicHTML();
    $pdf = PDF::loadHTML($html)->output();
    $headers = array( "Content-type" => "application/pdf", );
    return response()->streamDownload(fn () => print($pdf), "invoice.pdf", $headers );
  }
  function PdfStopOne($id)
  {
    $RepDate = date('Y-m-d');
    $cus = OurCompany::where('Company', Auth::user()->company)->first();
   $record=Main::find($id);
   $taj=Taj::find(Bank::find($record->bank_id)->taj_id);

   $BankName=$taj->TajName;
   $TajAcc=$taj->TajAcc;
    $html = view('PrnView.pdf-stop-one',
      ['record' => $record, 'cus' => $cus, 'TajAcc' => $TajAcc,'BankName'=>$BankName,])->toArabicHTML();
    $pdf = PDF::loadHTML($html)->output();
    $headers = array( "Content-type" => "application/pdf", );
    return response()->streamDownload(fn () => print($pdf), "invoice.pdf", $headers );
  }

  function PdfMainCont($id){

    $RepDate = date('Y-m-d');
    $cus = OurCompany::where('Company', Auth::user()->company)->first();

    $res=Main::find($id);

    $item_name='';



    $taj=Taj::find(Bank::find($res->bank_id)->taj_id);

    $BankName=$taj->TajName;
    $TajAcc=$taj->TajAcc;
    $html = view('PrnView.pdf-main-cont',
      ['res' => $res, 'cus' => $cus, 'TajAcc' => $TajAcc,'BankName'=>$BankName,])->toArabicHTML();
    $pdf = PDF::loadHTML($html)->output();
    $headers = array( "Content-type" => "application/pdf", );
    return response()->streamDownload(fn () => print($pdf), "invoice.pdf", $headers );

  }
  function PdfMain($id){

    $RepDate = date('Y-m-d');
    $cus = OurCompany::where('Company', Auth::user()->company)->first();

    $res=Main::find($id);
    $res2=Tran::where('main_id',$id)->get();

    $html = view('PrnView.pdf-main',
      ['res' => $res, 'cus' => $cus, 'res2' => $res2,])->toArabicHTML();
    $pdf = PDF::loadHTML($html)->output();
    $headers = array( "Content-type" => "application/pdf", );
    return response()->streamDownload(fn () => print($pdf), "invoice.pdf", $headers );

  }

}
