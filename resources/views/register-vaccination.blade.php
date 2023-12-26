@extends('layouts.UserApp')
@section('title', 'Đăng ký tiêm chủng')
@section('main-content')
    @php
        use Carbon\Carbon;
    @endphp
<div class="container-lg">
    <div class="p-5">
        <form action="{{route('vaccination.registration.store')}}" id="dangkytiem" name="dangkytiem" method="post" id="frmDangKyTiem">
            @csrf
            <nav class="nav nav-pills flex-column flex-sm-row">
                <a class="flex-sm-fill text-sm-center nav-link active" data-toggle="list" href="#thongtincanhan" role="tab">1. Thông tin cá nhân</a>
                <a class="flex-sm-fill text-sm-center nav-link disabled" data-toggle="list" href="#tiensutiem" role="tab">2. Tiền sử bệnh</a>
                <a class="flex-sm-fill text-sm-center nav-link disabled" data-toggle="list" href="#phieudongy" role="tab">3. Phiếu đồng ý</a>
            </nav>
            <hr>

            <div class="tab-content">
                <div class="tab-pane active" id="thongtincanhan" role="tabpanel">
                <h6 class="text-danger">Vui lòng kiểm tra thông tin cá nhân! Nếu chưa chính xác, chọn "Chỉnh sửa thông tin cá nhân".</h6>

                    <input  type="text" name="patient" value="{{$patient->id}}" hidden>
                    <input  type="text" name="schedule" id="schedule_id" value="{{$schedule->id}}" hidden>
                    <div class="form-group">
                        <label for="txtHoTen">Họ và tên </label>
                        <input type="text" name="txtHoTen" id="txtHoTen" placeholder="" class="form-control" value="{{$patient->full_name}}" disabled>
                    </div>

                    <div class="form-group">
                        <label for="dtNgaySinh">Ngày sinh </label>
                        <input type="date" name="dtNgaySinh" id="dtNgaySinh" placeholder="" value="{{$patient->date_of_birth}}" class="form-control" disabled>
                    </div>

                    <legend class="col-form-label">Giới tính </legend>
                    <div class="form-check form-check-inline">
                        <input type="radio" name="rdGioiTinh" id="rdGioiTinh1" value="1" class="form-check-input" disabled {{$patient->gender == 1 ? "checked" : ""}}>
                        <label for="rdGioiTinh1" class="form-check-label">Nam</label>
                    </div>

                    <div class="form-check form-check-inline">
                        <input type="radio" name="rdGioiTinh" id="rdGioiTinh2" value="0" class="form-check-input" disabled {{$patient->gender == 0 ? "checked" : ""}}>
                        <label for="rdGioiTinh2" class="form-check-label">Nữ </label>
                    </div>
                    
                    <div class="form-group">
                        <label for="txtCCCD">Số hộ chiếu/CMND/CCCD </label>
                        <input type="text" name="txtCCCD" id="txtCCCD" placeholder="" class="form-control" value="{{$patient->identify_card}}" disabled>
                    </div>
                    {{-- <div class="form-group">
                        <label for="txtBHYT">Số thẻ BHYT </label>
                        <input type="text" name="txtBHYT" id="txtBHYT" placeholder="" class="form-control" value="" disabled>
                    </div> --}}
                    <div class="form-group">
                        <label for="txtDiaChi">Địa chỉ </label>
                        <input type="text" name="txtDiaChi" id="txtDiaChi" placeholder="" class="form-control" value="{{$patient->address}}" disabled>
                    </div>
                    <a href="{{route('profile')}}">Chỉnh sửa thông tin cá nhân</a>
                    <hr>
                    <div class="form-group">
                        <label for="dtLichHen">Lịch hẹn </label>
                        <input type="date" name="dtLichHen" id="dtLichHen" placeholder="" class="form-control" value="{{$schedule->vaccination_date}}" disabled>
                    </div>
                    <div class="form-group">
                        <label for="txtDiaChi">Cơ sở tiêm </label>
                        <input type="text" name="txtCoSo" id="txtCoSo" placeholder="" class="form-control" value="{{$schedule->immunizationUnit->name}}" disabled>
                    </div>
                    <div class="form-group">
                        <label for="txtDiaChi">Địa chỉ cơ sở </label>
                        <input type="text" name="txtCoSo" id="txtCoSo" placeholder="" class="form-control" value="{{$schedule->immunizationUnit->address}}" disabled>
                    </div>
                    <hr>

                    
                    @if ($suggestTimes)
                        <h6 class="text-danger">Vui lòng kiểm tra thông tin lịch sử tiêm, mọi thắc mắc vui lòng liên hệ đến tổng đài tư vấn: <a href="tel: 0932988029">0932988029</a> </h6>
                        <div class="form-group">

                            <label for="injection_times">Đăng ký mũi tiêm thứ: </label>
                            <select name="injection_times" id="injection_times" class="custom-select" >
                                <option value="{{$theNextDose}}" >{{$theNextDose == "AD" ? "Mũi tiêm bổ sung" : "Mũi tiêm thứ ".$theNextDose}}</option>
                                
                                {{-- 
                                <option value="2" {{count($patient->vaccinationHistories) != 0 && $suggestTimes->number_of_injection == "1" ? "selected":""}}>Mũi tiêm thứ 2</option>
                                <option value="AD">Mũi tiêm bổ sung</option> --}}
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="vaccine">Vắc xin đã tiêm gần nhất:</label>
                            <select name="vaccine" id="vaccine" class="custom-select" >
                                {{-- <option value="" >dsfsd</option> --}}
                                <option value="{{$theLastVaccineInjection->id}}">{{$theLastVaccineInjection->name}}</option>
                                
                                {{-- <option value="{{$vaccine->id}}" {{old('vaccine', $suggestTimes->vaccineLot->vaccine->id) == $vaccine->id ? "selected" : ""}}>{{$vaccine->name}}</option> --}}
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="recent_injection_date">Ngày tiêm gần nhất:</label>
                            <input type="date" name="recent_injection_date" id="recent_injection_date" class="form-control" value="{{Carbon::parse($suggestTimes->created_at)->format('Y-m-d')}}" readonly>

                            {{-- <input type="date" name="recent_injection_date" id="recent_injection_date" class="form-control" value="{{Carbon::parse($suggestTimes->created_at)->format('Y-m-d')}}" data-recent_injection_date="{{Carbon::parse($suggestTimes->created_at)->format('Y-m-d')}}"> --}}
                        </div>
                    @elseif($suggestTimes == 0)
                        {{-- <h6 class="text-danger">Không tìm thấy lịch sử tiêm của quý khách trên hệ thống, vui lòng nhập thông tin</h6> --}}
                        <div class="form-group">
                            <label for="injection_times">Đăng ký mũi tiêm thứ: </label>
                            <select name="injection_times" id="injection_times" class="custom-select" >
                                <option value="1" >Mũi tiêm đầu tiên</option>
                            </select>
                        </div>

                        <div class="form-group" hidden>
                            <label for="vaccine">Vắc xin đã tiêm gần nhất:</label>
                            <select name="vaccine" id="vaccine" class="custom-select">
                                <option value=""></option>
                                {{-- @foreach ($vaccines as $vaccine)
                                    <option value="{{$vaccine->id}}" {{old('vaccine') == $vaccine->id ? "selected" : ""}}>{{$vaccine->name}}</option>
                                @endforeach --}}
                            </select>
                        
                        </div>
                        
                        <div class="form-group" hidden>
                            <label for="recent_injection_date">Ngày tiêm gần nhất:</label>
                            <input type="date" name="recent_injection_date" id="recent_injection_date" class="form-control" value="" data-recent_injection_date="">
                        
                        </div>
                    @endif
                    <hr>
                    <a class="btn btn-light rounded-circle border border-primary text-primary " type="button" id="btnPrev1" href="{{route('schedule')}}"><i class="fa-solid fa-arrow-left"></i></a>
                    <button class="btn btn-primary rounded-pill float-right w-50" type="button" id="btnNext1">Tiếp tục</button>
                </div>
                <div class="tab-pane" id="tiensutiem" role="tabpanel">
                <h6 class="text-danger">Vui lòng chọn đầy đủ vào bảng tiền sử bệnh!</h6>
                    <table class="table table-bordered table-striped">
                        <tr class="bg-info text-center text-light">
                            <th>Tiền sử</th>
                            <th style="width: 100px">Không</th>
                            <th style="width: 100px">Có</th>
                            <th style="width: 100px">Không rõ</th>
                        </tr>
                        <tr>
                            <td>1. Tiền sử phản vệ từ độ 2 trở lên</td>
                            <td>
                                <div class="form-check">
                                    <input type="radio" name="rdTienSuBenh1" value="0" class="form-check-input mx-auto">
                                </div>
                            </td>
                            <td>
                                <div class="form-check">
                                    <input type="radio" name="rdTienSuBenh1" value="1" class="form-check-input mx-auto">
                                </div>
                            </td>
                            <td>
                                <div class="form-check">
                                    <input type="radio" name="rdTienSuBenh1" value="3" class="form-check-input mx-auto">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>2. Tiền sử bị COVID-19 trong vòng 6 tháng</td>
                            <td>
                                <div class="form-check">
                                    <input type="radio" name="rdTienSuBenh2" value="0" class="form-check-input mx-auto">
                                </div>
                            </td>
                            <td>
                                <div class="form-check">
                                    <input type="radio" name="rdTienSuBenh2" value="1" class="form-check-input mx-auto">
                                </div>
                            </td>
                            <td>
                                <div class="form-check">
                                    <input type="radio" name="rdTienSuBenh2" value="3" class="form-check-input mx-auto">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>3. Tiền sử tiêm vắc xin trong vòng 14 ngày qua</td>
                            <td>
                                <div class="form-check">
                                    <input type="radio" name="rdTienSuBenh3" value="0" class="form-check-input mx-auto">
                                </div>
                            </td>
                            <td>
                                <div class="form-check">
                                    <input type="radio" name="rdTienSuBenh3" value="1" class="form-check-input mx-auto">
                                </div>
                            </td>
                            <td>
                                <div class="form-check">
                                    <input type="radio" name="rdTienSuBenh3" value="3" class="form-check-input mx-auto">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>4. Tiền sử suy giảm miễn dịch, ung thư giai đoạn cuối, cắt lách, xơ gan,...</td>
                            <td>
                                <div class="form-check">
                                    <input type="radio" name="rdTienSuBenh4" value="0" class="form-check-input mx-auto">
                                </div>
                            </td>
                            <td>
                                <div class="form-check">
                                    <input type="radio" name="rdTienSuBenh4" value="1" class="form-check-input mx-auto">
                                </div>
                            </td>
                            <td>
                                <div class="form-check">
                                    <input type="radio" name="rdTienSuBenh4" value="3" class="form-check-input mx-auto">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>5. Đang dùng thuốc ức chế miễn dịch, corticoid liều cao</td>
                            <td>
                                <div class="form-check">
                                    <input type="radio" name="rdTienSuBenh5" value="0" class="form-check-input mx-auto">
                                </div>
                            </td>
                            <td>
                                <div class="form-check">
                                    <input type="radio" name="rdTienSuBenh5" value="1" class="form-check-input mx-auto">
                                </div>
                            </td>
                            <td>
                                <div class="form-check">
                                    <input type="radio" name="rdTienSuBenh5" value="3" class="form-check-input mx-auto">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>6. Bệnh cấp tính</td>
                            <td>
                                <div class="form-check">
                                    <input type="radio" name="rdTienSuBenh6" value="0" class="form-check-input mx-auto">
                                </div>
                            </td>
                            <td>
                                <div class="form-check">
                                    <input type="radio" name="rdTienSuBenh6" value="1" class="form-check-input mx-auto">
                                </div>
                            </td>
                            <td>
                                <div class="form-check">
                                    <input type="radio" name="rdTienSuBenh6" value="3" class="form-check-input mx-auto">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>7. Tiền sử bệnh mãn tính, đang tiến triễn</td>
                            <td>
                                <div class="form-check">
                                    <input type="radio" name="rdTienSuBenh7" value="0" class="form-check-input mx-auto">
                                </div>
                            </td>
                            <td>
                                <div class="form-check">
                                    <input type="radio" name="rdTienSuBenh7" value="1" class="form-check-input mx-auto">
                                </div>
                            </td>
                            <td>
                                <div class="form-check">
                                    <input type="radio" name="rdTienSuBenh7" value="3" class="form-check-input mx-auto">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>8. Tiền sử bệnh mạn tính đã điều trị ổn</td>
                            <td>
                                <div class="form-check">
                                    <input type="radio" name="rdTienSuBenh8" value="0" class="form-check-input mx-auto">
                                </div>
                            </td>
                            <td>
                                <div class="form-check">
                                    <input type="radio" name="rdTienSuBenh8" value="1" class="form-check-input mx-auto">
                                </div>
                            </td>
                            <td>
                                <div class="form-check">
                                    <input type="radio" name="rdTienSuBenh8" value="3" class="form-check-input mx-auto">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>9. Tiền sử rối loạn đông máu hoặc đang dùng thuốc chống đông máu</td>
                            <td>
                                <div class="form-check">
                                    <input type="radio" name="rdTienSuBenh9" value="0" class="form-check-input mx-auto">
                                </div>
                            </td>
                            <td>
                                <div class="form-check">
                                    <input type="radio" name="rdTienSuBenh9" value="1" class="form-check-input mx-auto">
                                </div>
                            </td>
                            <td>
                                <div class="form-check">
                                    <input type="radio" name="rdTienSuBenh9" value="3" class="form-check-input mx-auto">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>10. Tiền sử dị dứng với các dị nguyên khác</td>
                            <td>
                                <div class="form-check">
                                    <input type="radio" name="rdTienSuBenh10" value="0" class="form-check-input mx-auto">
                                </div>
                            </td>
                            <td>
                                <div class="form-check">
                                    <input type="radio" name="rdTienSuBenh10" value="1" class="form-check-input mx-auto">
                                </div>
                            </td>
                            <td>
                                <div class="form-check">
                                    <input type="radio" name="rdTienSuBenh10" value="3" class="form-check-input mx-auto">
                                </div>
                            </td>
                        </tr>
                    </table>
                    <button class="btn btn-light rounded-circle border border-primary text-primary" type="button" id="btnPrev2"><i class="fa-solid fa-arrow-left"></i></button>
                    <button class="btn btn-primary rounded-pill float-right w-50" type="button" id="btnNext2">Tiếp tục</button>
                </div>
                <div class="tab-pane" id="phieudongy" role="tabpanel">
                    <table class="table">
                        <tr>
                            <td>
                                <p class="display-2 text-success"><i class="fa-solid fa-shield-virus"></i></p>
                            </td>
                            <td>Tiêm chủng vắc xin là biện pháp phòng chống dịch hiệu quả, tuy nhiên vắc xin
                                phòng chống bệnh COVID-19 có thể không phòng được bệnh hoàn toàn. Người được
                                tiêm chủng vắc xin phòng COVID-19 có thể phòng được bệnh hoặc giảm mức độ nặng
                                nếu mắc bệnh. Tuy nhiên, sau khi tiêm chủng vẫn phải tiếp tục thực hiện nghiêm
                                các biện pháp phòng chóng dịch theo quy định</td>
                        </tr>
                        <tr>
                            <td>
                                <p class="display-2 text-warning"><i class="fa-solid fa-syringe"></i></p>
                            </td>
                            <td>Tiêm chủng vắc xin phòng COVID-19 có thể gây ra một số hiện tượng bất thường về
                                sức khỏe như các biểu hiện tại chỗ tiêm hoặc toàn thân, bao gồm phản ứng thông
                                thường sau tiêm chủng và tai biến nặng sau tiêm chủng.</td>
                        </tr>
                        <tr>
                            <td>
                                <p class="display-2 text-danger"><i class="fa-solid fa-truck-medical"></i></p>
                            </td>
                            <td>Khi có triệu chứng bất thường về sức khỏe, người được tiêm chủng cần đến ngay cơ
                                sở y tế gần nhất để được tư vấn, thăm khám và điều trị kịp thời.</td>
                        </tr>
                        <tr>
                            <td>Sau khi đọc các thông tin trên: </td>
                            <td>
                                <label class=""><input type="checkbox" name="chkDongYDKTiem" id="chkDongYDKTiem"> Đồng ý tiêm chủng và cam kết trong vòng 14 ngày qua
                                    chưa tiêm phòng, nếu sai tôi xin chịu trách nhiệm.</label>
                            </td>
                        </tr>
                    </table>
                    <button class="btn btn-light rounded-circle border border-primary text-primary" type="button" id="btnPrev3"><i class="fa-solid fa-arrow-left"></i></button>
                    <button class="btn btn-primary rounded-pill float-right w-50" type="submit" id="btnSubmit">Hoàn thành đăng ký</button>
                </div>

            </div>

        </form>
    </div>

</div>
@endsection

@section('ex-script')

<script>
$(document).ready(function() {
    const btnNext1 = $('#btnNext1');
    const btnNext2 = $('#btnNext2');
    const btnPrev3 = $('#btnPrev3');
    const btnPrev2 = $('#btnPrev2');
    const form = $('#dangkytiem');
    const schedule_id = $('#schedule_id');
    function findAActiveClassInForm() {
        var aActiveClass = $('#dangkytiem a.active');
        
        aActiveClass.removeClass('active');
        aActiveClass.addClass('disabled');
        const dvActiveClass = $('div.active');
        dvActiveClass.removeClass('active');

    }

    function displayErrors(errors) {
      
      form.find('.invalid-feedback').remove();

      // Loop through the errors and display them
      $.each(errors, function(key, value) {
          var input = form.find('[name=' + key + ']');
          var error = $('<div>').addClass('invalid-feedback').html(value);
          error.insertAfter(input);
          input.addClass('is-invalid');
      });
    }
    
    btnNext1.on('click', function() {
        // form.validate({
        //     rules: {
        //         injection_times: {
        //             required: true,
        //         },
        //         vaccine:  { 
        //             required: true,
        //         },
        //         recent_injection_date: {
        //             required: true,
        //         }
                
        //     },
        //     messages: {
        //         injection_times: {
        //             required: "Bạn chưa chọn mũi tiêm",

                  
        //         },
        //         vaccine: {
        //             required: "Bạn chưa chọn vaccine", 
        //         },
        //         recent_injection_date: {
        //             required: "Bạn chưa chọn ngày tiêms",
        //         }
        //     },
        //     errorElement: "div",
        //     errorPlacement: function(error, element) {
        //         error.addClass("invalid-feedback");
        //         if (element.prop("type") === "radio") {
        //             error.insertAfter(element.siblings("label"));
        //         } else {
        //             error.insertAfter(element);
        //         }
        //     },
        //     highlight: function(element, errorClass, validClass) {
        //         $(element).addClass("is-invalid").removeClass("is-valid");
        //     },
        //     unhighlight: function(element, errorClass, validClass) {
        //         $(element).addClass("is-valid").removeClass("is-invalid");
        //     }
        // });
        

        // if(form.valid()) {
        //     findAActiveClassInForm();
        //     btnNext1.removeClass("disabled");
        //     var date = $('#last_injection_date').val();
        //     // console.log( $('#last_injection_date').data('last_injection_date'));
        //     $('a[href="#tiensutiem"]').removeClass('disabled').addClass('active').trigger('click');
        //     $('div#tiensutiem').addClass('active');
            
        // } else {
        //     $(this).addClass("disabled");
        //     var errors = form.validate().errors();
        //     console.log(errors);
        // }
        ///////////////////////////////////////
        // var formData = form.serialize();
        /////////////////////////////////////
        // @json($schedule->id)
        // Send an AJAX request to the server
        ////////////////////////////////////
        // $.ajax({
        // type: 'POST',
        // url: "{{route('patient.validate.validateRegistrationForm')}}",
        // data: formData,
        // dataType: 'json',

        // success: function(response) {
        //     if (response.errors) {
        //         displayErrors(response.errors);
        //     } else {
            // If there are no errors, submit the form
            // form.unbind('submit').submit();
                findAActiveClassInForm();
                btnNext1.removeClass("disabled");
                var date = $('#last_injection_date').val();
                // console.log( $('#last_injection_date').data('last_injection_date'));
                $('a[href="#tiensutiem"]').removeClass('disabled').addClass('active').trigger('click');
                $('div#tiensutiem').addClass('active');
        //     }
        // }
        // });
    })
    btnNext2.on('click', function() {
        
        var error = 0;
        for(var i = 1; i<= 10; i++){
            var nameInput = "rdTienSuBenh" + i;
            var inp = `input[name=${nameInput}]`;
            var input = $(inp);
            var tr = $(inp).parents("tr");
            tr.css("color", "black");
            if(input.is(":checked")){
                error += 0;
            } else  {
                error += 1;
               
                tr.css("color", "red");
            }
            
        }
        if(error == 0){
            findAActiveClassInForm();
            $('a[href="#phieudongy"]').removeClass('disabled').addClass('active').trigger('click');
            $('div#phieudongy').addClass('active');
        }
        

    })
    btnPrev3.on('click', function() {
        findAActiveClassInForm();
        $('a[href="#tiensutiem"]').removeClass('disabled').addClass('active').trigger('click');
        $('div#tiensutiem').addClass('active');
    })
    btnPrev2.on('click', function() {
        findAActiveClassInForm();
        $('a[href="#thongtincanhan"]').removeClass('disabled').addClass('active').trigger('click');
        $('div#thongtincanhan').addClass('active');
    })

    $('#btnSubmit').on("click", function(e){
        
        if($('#chkDongYDKTiem').is(":checked")){
            confirm("Gửi phiếu đăng ký");
            
            
        } else{
            e.preventDefault();
            $('#chkDongYDKTiem').parent("label").css("color", "red");
        }
    })
})
</script>

@endsection