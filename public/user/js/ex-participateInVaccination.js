$(document).ready(function() {
    const btnNext1 = $('#btnNext1');
    const btnNext2 = $('#btnNext2');
    const btnPrev3 = $('#btnPrev3');
    const btnPrev2 = $('#btnPrev2');

    function findAActiveClassInForm() {
        var aActiveClass = $('#dangkytiem a.active');
        
        aActiveClass.removeClass('active');
        aActiveClass.addClass('disabled');
        const dvActiveClass = $('div.active');
        
        dvActiveClass.removeClass('active');

    }
    
    btnNext1.on('click', function() {
        findAActiveClassInForm();
        
        $('a[href="#tiensutiem"]').removeClass('disabled').addClass('active').trigger('click');
        $('div#tiensutiem').addClass('active');
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