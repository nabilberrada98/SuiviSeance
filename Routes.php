<?php
session_start();

Route::set('login',  function (){
    LoginController::CreateView('Login');
});


Route::set('404Page',  function (){
    IndexController::CreateView('404Page');
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

Route::set('GestionDesFilieres',  function (){
    GestionDesFilieresController::CreateView('GestionDesFilieres');
});

Route::set('GestionDesSemestres',  function (){
    GestionDesSemestresController::CreateView('GestionDesSemestres');
});


Route::set('GestionDesEtudiants',  function (){
    GestionDesEtudiantsController::CreateView('GestionDesEtudiants');
});

Route::set('',  function (){
    if(isset($_SESSION['googleId']) && !empty($_SESSION['googleId'])){
        $privUser= PrivilegedUser::getByGoogleId($_SESSION['googleId']);
        if ($privUser->hasPrivilege("Dashboard Admin")||$privUser->hasPrivilege("Graphique d'avancement")||$privUser->hasPrivilege("Associer un enseignant a une matière")) {
            IndexController::CreateView("Dashboard");
        }else if ($privUser->hasPrivilege("Insérer état avancement")) {
            CalendrierDesCoursController::CreateView('CalendrierDesCours');
        }else{
            AvancementCoursController::CreateView('AvancementCours');
        }
    }else{
        AvancementCoursController::CreateView('AvancementCours');
    }
});


