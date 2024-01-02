@extends('PrnView.PrnMaster')

@section('mainrep')
    <div>

        <div style="text-align: center">
            <label style="font-size: 10pt;">{{$RepDate}}</label>

            <label style="font-size: 14pt;margin-right: 12px;" >تقرير بالعقود المتاخرة السداد حتي تاريخ : </label>
        </div>
        <div >
            <label style="font-size: 10pt;">{{$BankName}}</label>

            @if($By==1)
                <label style="font-size: 14pt;margin-right: 12px;" >لفرع المصرف : </label>
            @else
                <label style="font-size: 14pt;margin-right: 12px;" >للمصرف التجميعي : </label>
            @endif
        </div>
        <table style=" margin-left: 2%;margin-right: 5%; margin-bottom: 4%; margin-top: 2%;">
            <thead style="  margin-top: 8px;">
            <tr style="background: #9dc1d3;">
                <th style="width: 14%">ت.اخر قسط</th>
                <th style="width: 8%">المتاخرة</th>

                <th style="width: 12%">القسط</th>
                <th style="width: 16%">رقم الحساب</th>
                <th style="width: 10%">رقم العقد</th>
                <th>اسم الزبون</th>

            </tr>
            </thead>
            <tbody id="addRow" class="addRow">

            @php $sumkst=0; @endphp

            @foreach($RepTable as $key=> $item)
                <tr >
                    <td style="text-align: center"> {{ $item->LastKsm }} </td>
                    <td style="text-align: center"> {{ $item->Late }} </td>

                    <td> {{ number_format($item->kst,2, '.', ',') }} </td>
                    <td> {{ $item->acc }} </td>
                    <td style="text-align: center"> {{ $item->id }} </td>
                    <td> {{ $item->name }} </td>
                </tr>
                @php $sumkst+=$item->kst; @endphp
            @endforeach
            <tr class="font-size-12 " style="font-weight: bold">
                <td></td>
                <td>   </td>

                <td> {{number_format($sumkst, 2, '.', ',')}}  </td>
                <td> </td>
                <td> </td>
                <td style="font-weight:normal;">الإجمــــــــالي  </td>
            </tr>
            </tbody>
        </table>


    </div>



@endsection

