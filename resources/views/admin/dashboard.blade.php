@extends('layouts.AdminApp')
@section('breadcrumb')
        <li class="breadcrumb-item"><a href="#">Thống kê</a></li>
        {{-- <li class="breadcrumb-item"><a href="#">Library</a></li> --}}
        <li class="breadcrumb-item active" aria-current="page">Data</li>
@endsection
@section('title', 'Thống kê')
@section('ex-css')
    <style>
        .bc-scroll {
    height: 10px;
    background-color: blue;
    width: 100%;
    border-radius: 4px 4px 0px 0px;
  }

  div.card {
    box-shadow: 2px 2px 5px grey;
  }
    </style>
@endsection
@section('main-content')
<div class="">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6 col-lg-3">
          <div class="card mb-2">
            <div class="bc-scroll" style="background-color: blue;"></div>
            <div class="card-body pb-0">

              <h6>Số bệnh nhân</h6>
              <div class="text-value" id="baocaoSLKhachHang_1mui">
                <h1>{{$countPatients}}</h1>
                
              </div>

            </div>
          </div>

        </div>
        <div class="col-sm-6 col-lg-3">
          <div class="card mb-2">
            <div class="bc-scroll" style="background-color: orange;"></div>
            <div class="card-body pb-0">

              <h6>Số lượt đăng ký tiêm</h6>
              <div class="text-value" id="baocaoSLKhachHang_1mui">
                <h1>{{$countRegistrtionForms}}</h1>
               
              </div>

            </div>
          </div>

        </div>
        <div class="col-sm-6 col-lg-3">
          <div class="card mb-2">
            <div class="bc-scroll" style="background-color: green;"></div>
            <div class="card-body pb-0">
              <h6>Số nhân viên</h6>
              <div class="text-value" id="baocaoSLKhachHang_t1mui">
                <h1>{{$countEmployees}}</h1>
                
              </div>

            </div>
          </div>
        </div>
        <div class="col-sm-6 col-lg-3">
          <div class="card mb-2">
            <div class="bc-scroll" style="background-color: grey;"></div>

            <div class="card-body pb-0 ">
              <div>Tổng số cơ sở</div>
              <div class="text-value bg-white" id="baocaoCoSo_SoLuong">
                <h1>{{$countImmunizationUnits}}</h1>
             
              </div>

            </div>
          </div>
        </div>
        <div id="ketqua"></div>
      </div>

      <div class="row">
        
        <div class="col-12 ">
          <canvas id="chartOfobjChartVaccine" class="shadow bg-white"></canvas>
        </div>

      </div>
      <div class="row">

       

      </div>
    </div>
  </div>
@endsection

@section('ex-script')
<script src="{{url('/public/admin/vendor/chart/Chart.min.js')}}"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js"></script> --}}

    <script>
$(document).ready(function () {

var $objChartVaccine;
var $chartOfobjChartVaccine = document.getElementById("chartOfobjChartVaccine").getContext(
    "2d");
var ojbVaccines = @json($dataOfVaccines);
console.log(ojbVaccines);
function renderChartVaccine() {
            var myLabels = [];
            var myData = [];
            ojbVaccines.forEach(element => {
              myLabels.push(element.name);
              myData.push(element.number);
            });
            myData.push(0);
            $objChartVaccine = new Chart($chartOfobjChartVaccine, {

                type: "bar",
                data: {
                    labels: myLabels,
                    datasets: [{
                        data: myData,

                        fill: true,
                        backgroundColor: [
                            '#64e386',
                            '#f5b67a',
                            '#de2cf2',
                            '#e67065',
                            '#ed815a',
                            '#de2cf2',
                            '#de2cf2',
                        ],
                        borderWidth: 3,
                    }],
                },
                options: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: "Biểu đồ so sánh vaccine theo số lượt tiêm!"
                    },
                    responsive: true,
                }
            });
}

renderChartVaccine();
});
    </script>
@endsection