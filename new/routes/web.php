<?php

use App\Http\Controllers\TrgOppController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CivController;
use App\Http\Controllers\CreController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\NsDateController;
use App\Http\Controllers\CompagnyController;
use App\Http\Controllers\OppdashController;
use App\Http\Controllers\TrgdashController;
use App\Http\Controllers\CtcdashController;
use App\Http\Controllers\CstdashController;
use App\Http\Controllers\McpdashController;
use App\Http\Controllers\RtdashController;
use App\Http\Controllers\CtcController;
use App\Http\Controllers\CstController;
use App\Http\Controllers\CtclistController;
use App\Http\Controllers\CstlistController;
use App\Http\Controllers\McplistController;

use App\Http\Controllers\CdtMcpController;
use App\Http\Controllers\TrgCtcController;
use App\Http\Controllers\TrgMcpController;
use App\Http\Controllers\OppCstController;
use App\Http\Controllers\OppCdtController;
use App\Http\Controllers\OppEvtController;
use App\Http\Controllers\OppMcpController;
use App\Http\Controllers\CtcEvtController;
use App\Http\Controllers\CtcMcpController;
use App\Http\Controllers\CstEvtController;
use App\Http\Controllers\CstOppController;
use App\Http\Controllers\McpEvtController;
use App\Http\Controllers\McpDstController;





use App\Http\Controllers\OpplistController;
use App\Http\Controllers\TRGOpplistController;
use App\Http\Controllers\CdtEvtController;
use App\Http\Controllers\TrgEvtController;
use App\Http\Controllers\OpportunityController;
use App\Http\Controllers\DasboardController;
use App\Http\Controllers\NextStepController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\KpisController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\SpecialityController;
use App\Http\Controllers\DisponibilityController;
use App\Http\Controllers\CandidateStateController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\CandidateStatutController;
use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\HomeController;
use App\Livewire\Chat\CreateChat;
use App\Livewire\Chat\Main;
use App\Livewire\Back\Cres\ShowPdf;

use App\Http\Controllers\MailAuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});
Route::post('/connexion', [AuthenticatedSessionController::class, 'store'])->name('connexion');
Route::post('/deconnexion', [AuthenticatedSessionController::class, 'logOut'])->name('deconnexion');


Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/dashboard', [DasboardController::class, 'index'])->name('dashboard');
    Route::get('/oppdashboard', [OppdashController::class, 'index'])->name('oppdashboard');
    Route::get('/trgdashboard', [TrgdashController::class, 'index'])->name('trgdashboard');
    Route::get('/ctcdashboard', [CtcdashController::class, 'index'])->name('ctcdashboard');
    Route::get('/cstdashboard', [CstdashController::class, 'index'])->name('cstdashboard');
    Route::get('/mcpdashboard', [McpdashController::class, 'index'])->name('mcpdashboard');
    Route::get('/rtdashboard', [RtdashController::class, 'index'])->name('rtdashboard');



    Route::get('/ctclist', [CtclistController::class, 'index'])->name('ctclist');
    Route::get('/cstlist', [CstlistController::class, 'index'])->name('cstlist');
    Route::get('/mcplist', [McplistController::class, 'index'])->name('mcplist');
    Route::get('/opplist', [OpplistController::class, 'index'])->name('opplist');
    Route::get('/cdtevtlist', [CdtEvtController::class, 'index'])->name('cdtevtlist');
    Route::get('/cdtmcplist', [CdtMcpController::class, 'index'])->name('cdtmcplist');
    Route::get('/trgevtlist', [TrgEvtController::class, 'index'])->name('trgevtlist');
    Route::get('/trgctclist', [TrgCtcController::class, 'index'])->name('trgctclist');
    Route::get('/trgmcplist', [TrgMcpController::class, 'index'])->name('trgmcplist');
    Route::get('/trgopplist', [TrgOppController::class, 'index'])->name('trgopplist');
    Route::get('/oppevtlist', [OppEvtController::class, 'index'])->name('oppevtlist');
    Route::get('/oppcstlist', [OppCstController::class, 'index'])->name('oppcstlist');
    Route::get('/oppcdtlist', [OppCdtController::class, 'index'])->name('oppcdtlist');
    Route::get('/oppmcplist', [OppMcpController::class, 'index'])->name('oppmcplist');
    Route::get('/ctcevtlist', [CtcEvtController::class, 'index'])->name('ctcevtlist');
    Route::get('/ctcmcplist', [CtcMcpController::class, 'index'])->name('ctcmcplist');
    Route::get('/cstevtlist', [CstEvtController::class, 'index'])->name('cstevtlist');
    Route::get('/cstopplist', [CstOppController::class, 'index'])->name('cstopplist');
    Route::get('/mcpevtlist', [McpEvtController::class, 'index'])->name('mcpevtlist');
    Route::get('/mcpdstlist', [McpDstController::class, 'index'])->name('mcpdstlist');


   
    // Route::get('trgform', [LandingController::class, 'trgform'])->name('trgform');
    // Route::get('ctcform', [LandingController::class, 'ctcform'])->name('ctcform');

    Route::get('/ctcform', [App\Http\Controllers\CtcController::class, 'index'])->name('ctcform.index');
    Route::get('/ctcform/{id}', [App\Http\Controllers\CtcController::class, 'show'])->name('ctcform.show');

    Route::get('/cstform', [App\Http\Controllers\CstController::class, 'index'])->name('cstform.index');
    Route::get('/cstform/{id}', [App\Http\Controllers\CstController::class, 'show'])->name('cstform.show');

    Route::get('/mcpform', [App\Http\Controllers\McpController::class, 'index'])->name('mcpform.index');
    Route::get('/mcpform/{id}', [App\Http\Controllers\McpController::class, 'show'])->name('mcpform.show');

    Route::get('/rtform', [App\Http\Controllers\RtController::class, 'index'])->name('rtform.index');
    Route::get('/rtform/{id}', [App\Http\Controllers\RtController::class, 'show'])->name('rtform.show');

    
    Route::get('/trgform', [App\Http\Controllers\TrgController::class, 'index'])->name('trgform.index');
    Route::get('/trgform/{id}', [App\Http\Controllers\TrgController::class, 'show'])->name('trgform.show');

    Route::get('/opportunity', [App\Http\Controllers\OpportunityController::class, 'index'])->name('oppform.index');
    Route::get('/opportunity/{id}', [App\Http\Controllers\OpportunityController::class, 'show'])->name('oppform.show');


    Route::get('/kpis', [App\Http\Controllers\KpisController::class, 'index'])->name('kpis.index');
    Route::get('/kpis/{id}', [App\Http\Controllers\KpisController::class, 'show'])->name('kpis.show');







    
    Route::resource('users', UserController::class);
    Route::get('roles-permissions', [RolePermissionController::class, 'index'])->name('roles.permissions');
    Route::resource('roles', RoleController::class);
    Route::resource('candidates', CandidateController::class);
    // Route::resource('opportunity', OpportunityController::class);
    Route::get('import-candidat', [CandidateController::class, 'import'])->name('import.candidat');
    Route::resource('positions', PositionController::class);
    Route::resource('specialities', SpecialityController::class);
    Route::resource('fields', FieldController::class);
    Route::resource('compagnies', CompagnyController::class);
    Route::resource('disponibilities', DisponibilityController::class);
    Route::resource('civs', CivController::class);
    Route::get('user-profile', [UserController::class, 'profile'])->name('user.profile');
    Route::get('add-cre/{candidate}/{action}', [CreController::class, 'form'])->name('add.cre');
    Route::get('connexions', [DasboardController::class, 'summary'])->name('connexions');
    Route::get('detail', [DasboardController::class, 'detail'])->name('detail');
    Route::get('landings', [DasboardController::class, 'landings'])->name('landings');
    // Route::get('kpis', [LandingController::class, 'kpis'])->name('kpis');
    Route::get('management', [OpportunityController::class, 'management'])->name('management');
    Route::get('evts', [OpportunityController::class, 'evts'])->name('evts');
    Route::get('/landing', [LandingController::class, 'index'])->name('landing');

    //mail-aith-passcode
    Route::get('/mail-auth', [MailAuthController::class, 'index'])->name('mailauth');
    Route::post('/mail-auth', [MailAuthController::class, 'store'])->name('mailauth.store');

    

    
    Route::get('tables', [DasboardController::class, 'tables'])->name('tables');
    Route::get('filtrages', [DasboardController::class, 'filtrages'])->name('filtrages');
    Route::get('vue', [DasboardController::class, 'vue'])->name('vue');
    Route::get('upload', [DasboardController::class, 'upload'])->name('upload');

    Route::get('cdtvue', [DasboardController::class, 'cdtvue'])->name('cdtvue');
    Route::get('oppvue', [DasboardController::class, 'oppvue'])->name('oppvue');
    Route::get('trgvue', [DasboardController::class, 'trgvue'])->name('trgvue');
    Route::get('facvue', [DasboardController::class, 'facvue'])->name('facvue');

    Route::get('formcdt', [DasboardController::class, 'formcdt'])->name('formcdt');
    Route::get('formopp', [DasboardController::class, 'formopp'])->name('formopp');


    Route::get('canevascdt', [DasboardController::class, 'canevascdt'])->name('canevascdt');
    Route::get('canevasann', [DasboardController::class, 'canevasann'])->name('canevasann');


    Route::get('state/{state}', [CandidateController::class, 'state'])->name('state');
    Route::resource('nextsteps', NextStepController::class);
    Route::get('candidate-cre/{candidate}', [CreController::class, 'candidateCre'])->name('candidate.cre');
    Route::get('candidate-cv/{candidate}', [CandidateController::class, 'candidateCv'])->name('candidate.cv');
    Route::get('metiers', [DasboardController::class, 'metier'])->name('metiers');
    Route::resource('candidate_statuts', CandidateStatutController::class);
    Route::resource('candidate_states', CandidateStateController::class);
    Route::resource('nsdates', NsDateController::class);
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    // Route::get('/user', CreateChat::class)->name('user');
    Route::get('/chat{key?}', Main::class)->name('chat');
    Route::get('/cre/{candidate}/pdf', ShowPdf::class)->name('showPdf');
    Route::get('/autocomplete/positions', [PositionController::class, 'autocomplete'])->name('autocomplete.positions');
});
Route::get('commandes/{param}', [DasboardController::class, 'commande']);




