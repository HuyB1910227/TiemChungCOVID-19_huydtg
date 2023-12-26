@extends('layouts.ManagerApp')
@section('breadcrumb')
        <li class="breadcrumb-item"><a href="#">Dữ liệu thống kê</a></li>
  
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
        canvas {
          box-shadow: 2px 2px 5px grey;
        }
    </style>
@endsection
@section('main-content')
<div class="">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12 col-md-7">
          <div class="card">
            <div class="card-header text-center bg-white font-weight-bold"> THÔNG TIN CƠ SỞ</div>
            <div class="card-body">
              <table class="table table-borderless">
                  {{-- <tr>
                    <th>Mã sơ sở</th>
                    <td>{{$immunizationUnit->id}}</td>
                  </tr> --}}
                  <tr>
                    <th>Tên cơ sở</th>
                    <td>{{$immunizationUnit->name}}</td>
                  </tr>
                  <tr>
                    <th>Địa chỉ</th>
                    <td>{{$immunizationUnit->address}}</td>
                  </tr>
                  <tr>
                    <th>Giấy phép hoạt động</th>
                    <td>{{$immunizationUnit->operating_license}}</td>
                  </tr>
                  <tr>
                    <th>Đường dây nóng</th>
                    <td>{{$immunizationUnit->hotline}}</td>
                  </tr>
              </table>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-5">
          <div class="row">
            <div class="col-sm-6 ">
              <div class="card mb-2">
                <div class="bc-scroll" style="background-color: blue;"></div>
                <div class="card-body pb-0">
                  <h6>Số nhân viên tiêm chủng</h6>
                  <div class="text-value" id="baocaoSLKhachHang_1mui">
                    <h1>{{$countEmployees}}</h1>
                  </div>
                </div>
              </div>

            </div>
            <div class="col-sm-6 ">
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
            
          </div>
        </div>
      </div>
      

      <div class="row m-3">

      
       
          <canvas id="chartOfobjChartVaccine" class="bg-white w-100" style="height: 500px"></canvas>
       

      </div>
     
    </div>
  </div>
@endsection

@section('ex-script')
<script src="{{url('/public/admin/vendor/chart/Chart.min.js')}}"></script>

<script>
$(document).ready(function () {
var currentTime = new Date()
var $objChartVaccine;
var $chartOfobjChartVaccine = document.getElementById("chartOfobjChartVaccine").getContext(
    "2d");
var ojbVaccines = @json($dataOfVaccinationHistory);
console.log(ojbVaccines);
function renderChartVaccine() {
            var myLabels = [];
            var myData = [];
            ojbVaccines.forEach(element => {
              myLabels.push(element.date);
              myData.push(element.number);
            });
            myData.push(0);
            $objChartVaccine = new Chart($chartOfobjChartVaccine, {

                type: "line",
                data: {
                    labels: myLabels,
                    datasets: [{
                        data: myData,
                        // tension: 0,
                        fill: false,
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
                        borderColor: 'rgb(75, 192, 192)',
                    }],
                },

                options: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: "Biểu đồ so sánh số lượt tiêm tại cơ sở theo các tháng trong năm " + currentTime.getFullYear(),
                    },
                      responsive: false,
                      scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                stepSize: 200
                            }
                        }]
                  // maintainAspectRatio: false,
                  },
                }
            });
        }

        renderChartVaccine();
        });
</script>
@endsection