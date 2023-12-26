@extends('layouts.UserApp')

@section('ex-css')
    <style>
        body {
            font-family: roboto;

        }

        .purple-square-container {
            height: 80%;
            display: flex;
            align-items: center;

        }

        .phone {
            border: 3px solid orange;
            background-color: #fab861;
            color: white;
        }

        h3.title {
            color: #616AC6;
            text-transform: uppercase;
            font-weight: bolder;
            text-align: center;
        }

        a.banquyen {
            text-decoration: none;
            color: grey;
            font-size: 1.1rem;
        }

        a.banquyen:hover {
            text-decoration: none;
            color: #616AC6;

        }
    </style>
@endsection


@section('title', 'Tiêm chủng Covid-19')

@section('main-content')
<div class="container-lg ">
    <div class="row bg-info">
        <div class="col-12 col-md-6 p-0">
            <img src="{{asset('user/img/newseventsimage.webp')}}" alt="" class="img-fluid">
        </div>
        <div class="col-12 col-md-6">

            <div class="purple-square-container text-light">
                <div>
                    <h1 class="font-weight-border">Xin chào!</h1>
                    <p class="font-weight-border">Chào mừng quý khách đã đến với tiemchungcovid-19.vn, đây là trang quản
                        lý tiêm chủng cho cá nhân.</p>
                </div>
                {{-- <div>
                    @php
                        use Carbon\Carbon;
                    @endphp
                    <div>
                        {{Carbon::parse()->format('Y-m-d')}}
                        {{now()}}
                    </div>
                    <div>
                        dildo
                        {{date('Y-m-d H:i:s')}}
                    </div>
                </div> --}}
            </div>


            <div>
                @if (auth('patient')->user())
                
                <a class="btn text-primary font-weight-bolder bg-white mr-2 shadow-lg"
                href="{{url('trang-chu')}}">Đi đến trang chủ</a>
                @else
                <a class="btn text-primary font-weight-bolder bg-white mr-2 shadow-lg"
                href="{{route('patient.login')}}">Đăng nhập</a>
                <a class="btn text-primary font-weight-bolder bg-white  shadow-lg"
                href="{{route('patient.register')}}">Đăng ký</a>
                @endif

               

            </div>
        </div>
    </div>
    <hr>




    <h3 class="title">Bản đồ covid-19</h3>

    <div class="row">
        <div class="col-12 col-md-6">
            <div class="border m-2 shadow rounded">

                <iframe
                    src="https://api.ncovtrack.com/vaccine/vietnam/provinces?metric=cases&showTable=false&showMap=true"
                    title="ncovtrack - COVID & Vaccination Statistics" height='550' width='100%'
                    frameBorder="0"></iframe>


            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="border m-2 shadow rounded">

                <iframe
                    src="https://api.ncovtrack.com/vaccine/vietnam/provinces?metric=recovered&showTable=false&showMap=true"
                    title="ncovtrack - COVID & Vaccination Statistics" height='550' width='100%'
                    frameBorder="0"></iframe>


            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-12 col-md-6">
            <div class="border m-2 shadow rounded">

                <iframe
                    src="https://api.ncovtrack.com/vaccine/vietnam/provinces?metric=first_dose&showTable=true&showMap=true"
                    title="ncovtrack - COVID & Vaccination Statistics" height='550' width='100%'
                    frameBorder="0"></iframe>

            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="border m-2 shadow rounded">

                <iframe
                    src="https://api.ncovtrack.com/vaccine/vietnam/provinces?metric=second_dose&showTable=true&showMap=true"
                    title="ncovtrack - COVID & Vaccination Statistics" height='550' width='100%'
                    frameBorder="0"></iframe>

            </div>
        </div>
    </div>
    <div class="row justify-content-center pt-2">
        <a href="https://ncovtrack.com/vaccine/vietnam" class="banquyen">&copy;&nbsp; Bản quyền thuộc về
            ncovtrack.com</a>
    </div>
    <hr>
    <h3 class="title">Tổ chức tiêm chủng</h3>
    <div class="row">
        <table class="table table-bordered" id="lichhen">
            <thead>
                <tr class="bg-primary text-light">
                    <th>Mã lịch hẹn</th>
                    <th>Cơ sở</th>
                    <th>Địa chỉ</th>
                    <th>Phường/ Xã</th>
                    <th>Quận/ Huyện</th>
                    <th>Tỉnh/ Thành phố</th>
                    <th>Ngày tiêm</th>
                    <th>Giờ bắt đầu</th>
                    <th>Giờ kết thúc</th>
                    <th>Vắc xin</th>
                    {{-- <th>Thao tác</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($schedules as $schedule)
                    <tr>
                        @php
                            $addr[] = null;
                            $addr = explode(" ; ", $schedule->immunizationUnit->address);
                        @endphp
                        <td>{{$schedule->id}}</td>
                        <td>{{$schedule->immunizationUnit->name}}</td>
                        <td>{{$addr[0]}}</td>
                        <td>{{$addr[1]}}</td>
                        <td>{{$addr[2]}}</td>
                        <td>{{$addr[3]}}</th>
                        <td>{{$schedule->vaccination_date}}</td>
                        <td>{{$schedule->start_time}}</td>
                        <td>{{$schedule->end_time}}</td>
                        <td>{{$schedule->vaccine->name}}</td>
                        {{-- <td>
                            <a class="btn btn-light text-primary btn-link" href="{{route('vaccination.registration', $schedule->id)}}">Đăng ký</a>
                        </td> --}}
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection

@section('ex-script')
    <script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
        <script>
            $(document).ready(function () {
                $('#lichhen').DataTable({
                    "language": {
                        "url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Vietnamese.json",
                    },
                });
            });
        </script>
    
@endsection