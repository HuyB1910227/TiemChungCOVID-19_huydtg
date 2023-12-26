<?php

use App\Http\Controllers\RoleController;
use App\Http\Controllers\VaccineController;
use App\Role;
use App\Vaccine;
use FontLib\Table\Type\post;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');
//user
Route::get('/', 'UserController@index')->name('index');
//admin



Route::get('ban-quan-ly/ngung-hoat-dong', function(){
    return view('manager.not-work');
});



Route::group(['prefix' => 'quan-tri/', 'middleware' => ['auth', 'CheckRole:administrator']], function(){
    Route::get('dashboard', 'AdminController@dashboard')->name('admin.dashboard');
    Route::get('logout', 'LogoutController@perform')->name('logout.perform');
    Route::get('co-so-tiem-chung', 'AdminController@imuzlationUnit');
    Route::get('thanh-vien', 'AdminController@member');
    Route::get('lich-su-tiem', 'AdminController@vacHistory');
    Route::get('phieu-dang-ky', 'AdminController@vacRegistration');
    Route::get('lich-tiem', 'AdminController@vacSchedule');
    Route::get('loai-vac-xin', 'TypeController@index')->name('admin.type');
    Route::get('loai-vac-xin/them-loai-vac-xin', 'TypeController@create')->name('admin.type.create');
    Route::post('loai-vac-xin/them-loai-vac-xin', 'TypeController@store')->name('admin.type.store');
    Route::post('loai-vac-xin/xoa-loai-vac-xin/{id}', 'TypeController@destroy')->name('admin.type.destroy');
    Route::get('loai-vac-xin/sua-loai-vac-xin/{id}', 'TypeController@edit')->name('admin.type.edit');
    Route::post('loai-vac-xin/sua-loai-vac-xin/{id}', 'TypeController@update')->name('admin.type.update');
    //Vắc xin
    Route::get('vac-xin', 'VaccineController@index')->name('admin.vaccine');
    Route::get('vac-xin/them-vac-xin', 'VaccineController@create')->name('admin.vaccine.create');
    Route::post('vac-xin/them-vac-xin', 'VaccineController@store')->name('admin.vaccine.store');
    Route::post('vac-xin/xoa-vac-xin/{id}', 'VaccineController@destroy')->name('admin.vaccine.destroy');
    Route::get('vac-xin/chinh-sua-vac-xin/{id}', 'VaccineController@edit')->name('admin.vaccine.edit');
    Route::post('vac-xin/chinh-sua-vac-xin/{id}', 'VaccineController@update')->name('admin.vaccine.update');
    //Thanh vien
    Route::get('thanh-vien', 'MemberController@index')->name('admin.member');
    Route::get('thanh-vien/them-thanh-vien', 'MemberController@create')->name('admin.member.create');
    Route::post('thanh-vien/them-thanh-vien', 'MemberController@store')->name('admin.member.store');
    Route::get('thanh-vien/xoa-thanh-vien/{id}', 'MemberController@destroy')->name('admin.member.destroy');
    Route::get('thanh-vien/sua-thanh-vien/{id}', 'MemberController@edit')->name('admin.member.edit');
    Route::post('thanh-vien/sua-thanh-vien/{id}', 'MemberController@update')->name('admin.member.update');
    //co so tiem chung

    Route::get('co-so-tiem-chung', 'ImmunizationUnitController@index')->name('admin.immunizationUnit');
    Route::get('co-so-tiem-chung/them-co-so', 'ImmunizationUnitController@create')->name('admin.immunizationUnit.create');
    Route::post('co-so-tiem-chung/them-co-so', 'ImmunizationUnitController@store')->name('admin.immunizationUnit.store');
    Route::get('co-so-tiem-chung/xoa-co-so/{id}', 'ImmunizationUnitController@destroy')->name('admin.immunizationUnit.destroy');
    Route::get('co-so-tiem-chung/sua-co-so/{id}', 'ImmunizationUnitController@edit')->name('admin.immunizationUnit.edit');
    Route::post('co-so-tiem-chung/sua-co-so/{id}', 'ImmunizationUnitController@update')->name('admin.immunizationUnit.update');
    //lich
    Route::get('lich-tiem', 'AdminScheduleController@index')->name('admin.schedule');
    Route::post('lich-tiem/xac-nhan/{id}', 'AdminScheduleController@confirm')->name('admin.schedule.confirm');
    Route::post('lich-tiem/tu-choi/{id}', 'AdminScheduleController@cancel')->name('admin.schedule.cancel');
    Route::get('lich-tiem/{id}', 'AdminScheduleController@show')->name('admin.schedule.show');

    //lich su
    Route::get('lich-su-tiem-chung', 'AdminVaccinationHistoryController@index')->name('admin.vaccination.history');
    Route::get('lich-su-tiem-chung/{id}', 'AdminVaccinationHistoryController@index')->name('admin.vaccination.history.show');
    
    //danh sach dang ky
    Route::get('phieu-dang-ky', 'AdminVaccinationRegistrationController@index')->name('admin.vaccination.registration');
    Route::post('phieu-dang-ky/{id}', 'AdminVaccinationRegistrationController@show')->name('admin.vaccination.registration.show');

    //thong ke
    Route::get('thong-ke', 'StatisticsController@index')->name('statistics');
    Route::get('benh-nhan', 'AdminController@patient');

    //
    Route::get("nguoi-dung", 'AdminPatientController@index')->name('admin.patient');
    Route::post('lich-su-tiem/{id}', 'ManagerEmployeeVaccinationHistoryController@show')->name('admin.vaccination.history.show');

    //prof
    Route::get("ho-so-ca-nhan/{id}", 'ProfileUserController@index')->name('admin.profile');
    Route::post("ho-so-ca-nhan/cap-nhat-thong-tin/{id}", 'ProfileUserController@update')->name('admin.profile.update');
    Route::post("ho-so-ca-nhan/cap-nhat-avatar/{id}", 'ProfileUserController@updateAvatar')->name('admin.profile.update.avatar');
    //
    Route::get("cap-nhat-tai-khoan", 'AccountController@changePassword')->name('admin.password');
    Route::post("doi-mat-khau", 'AccountController@updatePassword')->name('admin.password.update');

});
Route::group(['prefix' => '/', 'middleware' => ['auth:patient']], function(){
    Route::get('trang-chu', 'UserController@home')->name('userHomePage');
    Route::get('lich-tiem', 'UserController@schedule')->name('patient.schedule');
    Route::get('tai-khoan', 'UserController@account')->name('patient.account');
    Route::get('lich-su-dang-ky', 'UserController@regHistory')->name('vaccination.registration.history');
    Route::get('lich-su-tiem-chung', 'UserController@vacHistory')->name('patient.vaccination.history');
    Route::get('chung-nhan-tiem', 'UserController@vacCertificate')->name('patient.vaccination.certificate');
    Route::get('chung-nhan-tiem/pdf', 'PDFController@generatePDF')->name('generatePDF');

    //Lich tiem
    Route::get('tra-cuu-lich-tiem', 'ScheduleController@index')->name('schedule');
    //Dang ky tiem
    Route::get('dang-ky-tiem-chung/{id}', 'VaccinationRegistrationController@index')->name('vaccination.registration');
    Route::post('dang-ky-tiem-chung', 'VaccinationRegistrationController@store')->name('vaccination.registration.store');
    Route::post('huy-dang-ky-tiem-chung/{id}', 'VaccinationRegistrationController@destroy')->name('vaccination.registration.destroy');

    //ho so suc khoe
    Route::get('thong-tin-ca-nhan', 'ProfileController@index')->name('profile');
    Route::post('thong-tin-ca-nhan/{id}', 'ProfileController@update')->name('profile.update');
    Route::post('thong-tin-ca-nhan/sua-hinh-anh/{id}', 'ProfileController@updateAvatar')->name('profile.update.avatar');
   
    //account
    Route::post('cap-nhat-tai-khoan', 'UserController@accountUpdate')->name('patient.account.update');

    //Ajax
    Route::post('kiem-tra-dang-ky', 'VaccinationRegistrationController@validateRegistrationForm')->name('patient.validate.validateRegistrationForm');

});


   
Route::group(['prefix' => 'ban-quan-ly/', 'middleware' => ['auth', 'CheckRole:manager', 'CheckStatusOfImUnit', 'verified']], function(){
    Route::get('dashboard', 'ManagerController@dashboard')->name('manager.dashboard');
    Route::get('logout', 'LogoutController@perform')->name('logout.perform');
    //Thanh vien
    Route::get('thanh-vien', 'ManagerMemberController@index')->name('manager.member');
    Route::get('thanh-vien/them-thanh-vien', 'ManagerMemberController@create')->name('manager.member.create');
    Route::post('thanh-vien/them-thanh-vien', 'ManagerMemberController@store')->name('manager.member.store');
    Route::get('thanh-vien/sua-thanh-vien/{id}', 'ManagerMemberController@edit')->name('manager.member.edit');
    Route::post('thanh-vien/sua-thanh-vien/{id}', 'ManagerMemberController@update')->name('manager.member.update');
    //Schedule
    Route::get('ke-hoach-tiem', 'ManagerScheduleController@index')->name('manager.schedule');
    Route::get('ke-hoach-tiem/them-ke-hoach-tiem', 'ManagerScheduleController@create')->name('manager.schedule.create');
    Route::post('ke-hoach-tiem/them-ke-nguon-luc', 'ManagerScheduleController@prepare')->name('manager.schedule.prepare');
    Route::post('ke-hoach-tiem/them-ke-hoach-tiem', 'ManagerScheduleController@store')->name('manager.schedule.store');
    Route::get('ke-hoach-tiem/sua-ke-hoach-tiem/{id}', 'ManagerScheduleController@edit')->name('manager.schedule.edit');
    Route::post('ke-hoach-tiem/sua-nguon-luc/{id}', 'ManagerScheduleController@prepareUpdate')->name('manager.schedule.prepareUpdate');
    Route::post('ke-hoach-tiem/sua-ke-hoach-tiem/{id}', 'ManagerScheduleController@update')->name('manager.schedule.update');
    Route::post('ke-hoach-tiem/xoa-ke-hoach-tiem/{id}', 'ManagerScheduleController@destroy')->name('manager.schedule.destroy');
    //Phieu dang ky
    Route::get('ke-hoach-tiem/{id}', 'ManagerScheduleController@show')->name('manager.schedule.show');
    //Lo vac xin
    Route::get('lo-vac-xin', 'ManagerVaccineLotController@index')->name('manager.lot');
    Route::get('lo-vac-xin/them-lo-vac-xin', 'ManagerVaccineLotController@create')->name('manager.lot.create');
    Route::post('lo-vac-xin/them-lo-vac-xin', 'ManagerVaccineLotController@store')->name('manager.lot.store');
    Route::get('lo-vac-xin/sua-lo-vac-xin/{id}', 'ManagerVaccineLotController@edit')->name('manager.lot.edit');
    Route::post('lo-vac-xin/sua-lo-vac-xin/{id}', 'ManagerVaccineLotController@update')->name('manager.lot.update');
    Route::delete('lo-vac-xin/xoa-lo-vac-xin/{id}', 'ManagerVaccineLotController@destroy')->name('manager.lot.destroy');
    //Dang ky tiem
    Route::get('phieu-dang-ky', 'ManagerVaccinationRegistrationController@index')->name('manager.vaccination.registration');
    Route::post('phieu-dang-ky/{id}', 'ManagerVaccinationRegistrationController@show')->name('manager.vaccination.registration.show'); 
    Route::post('phieu-dang-ky/xac-nhan/{id}', 'ManagerVaccinationRegistrationController@confirm')->name('manager.vaccination.registration.confirm');
    Route::post('phieu-dang-ky/tu-choi/{id}', 'ManagerVaccinationRegistrationController@refuse')->name('manager.vaccination.registration.refuse');
    Route::post('phieu-dang-ky/xac-nhan-danh-sach/{str}', 'ManagerVaccinationRegistrationController@confirmMany')->name('manager.vaccination.registration.confirmMany');
    
    //Lich su tiem
    Route::get('lich-su-tiem', 'ManagerVaccinationHistoryController@index')->name('manager.vaccination.history');
    Route::post('cap-nhat-trang-thai/{id}', 'ManagerVaccinationHistoryController@update')->name('manager.vaccination.history.update');



    

    Route::post('lich-su-tiem/{id}', 'ManagerEmployeeVaccinationHistoryController@show')->name('manager.vaccination.history.show');


    Route::get("ho-so-ca-nhan/{id}", 'ProfileUserController@index')->name('manager.profile');
    Route::post("ho-so-ca-nhan/cap-nhat-thong-tin/{id}", 'ProfileUserController@update')->name('manager.profile.update');
    Route::post("ho-so-ca-nhan/cap-nhat-avatar/{id}", 'ProfileUserController@updateAvatar')->name('manager.profile.update.avatar');

    Route::get("cap-nhat-tai-khoan", 'AccountController@changePassword')->name('manager.password');
    Route::post("doi-mat-khau", 'AccountController@updatePassword')->name('manager.password.update');
    Route::post("ke-hoach-tiem/tim-nhan-vien", 'ManagerScheduleController@findApropriateEmployee')->name('findApropriateEmployee');
});
Route::group(['prefix' => 'nhan-vien/', 'middleware' => ['auth', 'CheckRole:employee', 'CheckStatusOfImUnit', 'verified']], function(){
    Route::get('dashboard', 'EmployeeController@dashboard')->name('employeeDashboard');
    Route::get('logout', 'LogoutController@perform')->name('logout.perform');

    Route::get('lich-su-tiem', 'EmployeeVaccinationHistoryController@index')->name('employee.vaccination.history');
    Route::post('lich-su-tiem/{id}', 'ManagerEmployeeVaccinationHistoryController@show')->name('employee.vaccination.history.show');

    Route::post('cap-nhat-trang-thai/{id}', 'EmployeeVaccinationHistoryController@update')->name('employee.vaccination.history.update');
    //
    Route::get('phieu-dang-ky', 'EmployeeVaccinationRegistrationController@index')->name('employee.vaccination.registration');
    Route::post('phieu-dang-ky/{id}', 'EmployeeVaccinationRegistrationController@show')->name('employee.vaccination.registration.show'); 
    Route::post('phieu-dang-ky/xac-nhan/{id}', 'EmployeeVaccinationRegistrationController@confirm')->name('employee.vaccination.registration.confirm');
    Route::post('phieu-dang-ky/tu-choi/{id}', 'EmployeeVaccinationRegistrationController@refuse')->name('employee.vaccination.registration.refuse');
    Route::post('phieu-dang-ky/xac-nhan-danh-sach/{str}', 'EmployeeVaccinationRegistrationController@confirmMany')->name('employee.vaccination.registration.confirmMany');
    //
    Route::get('xu-ly-tiem-chung', 'EmployeeVaccinationExecutionController@index')->name('employee.vaccination.execution');
    Route::post('xu-ly-tiem-chung/{id}', 'EmployeeVaccinationExecutionController@store')->name('employee.vaccination.execution.store'); 
    Route::post('xu-ly-tiem-chung/chi-tiet/{id}',  'EmployeeVaccinationExecutionController@show')->name('employee.vaccination.execution.show');
    Route::post('xu-ly-tiem-chung/huy-phieu-dang-ky/{id}', 'EmployeeVaccinationExecutionController@cancel')->name('employee.vaccination.execution.cancel');
    //
    Route::get('lich-cong-tac', 'EmployeeTimetableController@index')->name('employee.timetable');
    Route::get('lich-cong-tac/{id}', 'EmployeeTimetableController@show')->name('employee.timetable.show');
    Route::get('lich-lam-viec', 'EmployeeCalendarController@index')->name('employee.calendar');
    Route::get('chi-tiet-lich-lam-viec', 'EmployeeCalendarController@getEvents')->name('employee.calendar.events');

    Route::get("ho-so-ca-nhan/{id}", 'ProfileUserController@index')->name('employee.profile');
    Route::post("ho-so-ca-nhan/cap-nhat-thong-tin/{id}", 'ProfileUserController@update')->name('employee.profile.update');
    Route::post("ho-so-ca-nhan/cap-nhat-avatar/{id}", 'ProfileUserController@updateAvatar')->name('employee.profile.update.avatar');
    //
    Route::get("cap-nhat-tai-khoan", 'AccountController@changePassword')->name('employee.password');
    Route::post("doi-mat-khau", 'AccountController@updatePassword')->name('employee.password.update');

});



Route::get('admin/dang-nhap', 'AdminController@login');


Route::get('/not-permission', function() {
    return view('auth.not-permission');
})->name('not-permission');

