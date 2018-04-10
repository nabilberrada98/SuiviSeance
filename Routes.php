<?php
session_start();

Route::set('login',  function (){
    LoginController::CreateView('Login');
});

Route::set('CalendrierDesCours',  function (){
      CalendrierDesCoursController::CreateView('CalendrierDesCours');
});

Route::set('AvancementCours',  function (){
      AvancementCoursController::CreateView('AvancementCours');
});



Route::set('CalendrierDesEncadrements',  function (){
      CalendrierDesEncadrementsController::CreateView('CalendrierDesEncadrements');
});     

Route::set('GestionDesMatieres',  function (){
      GestionDesMatieresController::CreateView('GestionDesMatieres');
});

Route::set('GestionDesMails',  function (){
    GestionDesMailsController::CreateView('GestionDesMails');
});
Route::set('GestionDesRoles',  function (){
    GestionDesRolesController::CreateView('GestionDesRoles');
});

Route::set('GestionDesProfesseurs',  function (){
    GestionDesProfesseursController::CreateView('GestionDesProfesseurs');
});

Route::set('',  function (){
    if(isset($_SESSION['googleId']) && !empty($_SESSION['googleId'])){
        $privUser= PrivilegedUser::getByGoogleId($_SESSION['googleId']);
        if ($privUser->hasPrivilege("Dashboard")) {
            IndexController::CreateView("Dashboard");
        }
    }else{
        CalendrierDesCoursController::CreateView('CalendrierDesCours');
    }
});


