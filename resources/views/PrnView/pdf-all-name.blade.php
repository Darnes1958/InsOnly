@extends('PrnView.PrnMaster')

@section('mainrep')
    <div>
        <div style="text-align: center">
            <label style="font-size: 10pt;">{{$RepDate}}</label>
            <label style="font-size: 14pt;margin-right: 12px;" >قائمة بأسماء المشنركين بعقود حتي تاريخ : </label>
        </div>

        <table style=" margin-left: 2%;margin-right: 5%; margin-bottom: 4%; margin-top: 2%;">
            <thead style="  margin-top: 8px;">
            <tr style="background: #9dc1d3;">
                <th>الإســــــــــــم</th>
                <th style="width: 12%">رقم العقد</th>
                <th style="width: 12%">تسلسل</th>

            </tr>
            </thead>
            <tbody id="addRow" class="addRow">

            @foreach($RepTable as $key=> $item)
                <tr >
                    <td> {{ $item->name }} </td>
                    <td style="text-align: center"> {{ $item->id }} </td>
                    <td style="text-align: center"> {{ $key+1 }} </td>

                </tr>

            @endforeach
            </tbody>
        </table>


    </div>



@endsection

