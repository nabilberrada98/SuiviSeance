<?php
$array = explode('/', $_SERVER['REQUEST_URI']);
$file = array_pop($array);
?>
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $user_img_path ?>" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p> <?= ucfirst($user_name) ?> </p>
                <a href="https://mail.google.com" target="_blank"><i class="fa fa-suitcase"></i><?= strlen($user_email) > 23 ? substr($user_email, 0, 23) . '...' : $user_email ?></a>
            </div>
        </div>
        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">Choix de Menu</li>
            <!-- Optionally, you can add icons to the links -->
            <!-- <li class="active"><a href="#"><i class="fa fa-link"></i> <span>Séances de cour</span></a></li>
             <li><a href="#"><i class="fa fa-link"></i> <span>Séances d'encadrement</span></a></li> -->
            <?php if ($user_priv->hasPrivilege("Dashboard Admin")||$user_priv->hasPrivilege("Graphique d'avancement") || $user_priv->hasPrivilege("Associer une matière a un professeur")) { ?>
                <li class="<?= $file == '' ? "active" : "" ?>">
                    <a href="./" class="animated-hover faa-parent">
                        <i class="fa fa-th faa-passing"></i> <span>Dashboard</span>
                    </a>
                </li>
            <?php } ?>
                <li class="<?= $file == 'AvancementCours' ? "active" : "" ?>">
                    <a href="AvancementCours" class="animated-hover faa-parent">
                        <i class="fa fa-battery-2 faa-passing"></i> <span>Avancement des Cours</span>
                    </a>
                </li>
            <?php if ($user_priv->hasPrivilege("Insérer état avancement")||$user_priv->hasPrivilege("Modifier état avancement")||$user_priv->hasPrivilege("Supprimer état avancement")) { ?>
            <li class="<?= $file == 'CalendrierDesCours' ? "active" : "" ?>">
                <a href="CalendrierDesCours" class="animated-hover faa-parent">
                    <i class="fa fa-calendar"></i> <span>Calendrier des Séances</span>
                </a>
            </li>
             <?php }
             if ($user_priv->hasPrivilege("Gestion Matières")||$user_priv->hasPrivilege("Gestion Filières")||$user_priv->hasPrivilege("Gestion Semestres")) {
             ?>
            <li class="treeview">
                <a ><i class="fa fa-circle"></i> <span>Administration</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <?php if($user_priv->hasPrivilege("Gestion Filières")){?>
                    <li><a href="GestionDesFilieres" ><i class="fa fa-graduation-cap <?= $file == 'GestionDesFilieres' ? "active" : "" ?>"></i>Gestion des Filières</a></li>
                    <?php }
                    if($user_priv->hasPrivilege("Gestion Semestres")){
                    ?>
                     <li><a href="GestionDesSemestres" ><i class="fa fa-leanpub <?= $file == 'GestionDesSemestres' ? "active" : "" ?>"></i>Gestion des Semestres</a></li>
                    <?php }
                    if($user_priv->hasPrivilege("Gestion Matières")){
                    ?>
                     <li><a href="GestionDesMatieres" ><i class="fa fa-leanpub <?= $file == 'GestionDesMatieres' ? "active" : "" ?>"></i>Gestion des Matiéres</a></li>
                   <?php }
                    if($user_priv->hasPrivilege("Gestion Etudiants")){
                    ?>
                     <li><a href="GestionDesEtudiants" ><i class="fa fa-child <?= $file == 'GestionDesEtudiants' ? "active" : "" ?>"></i>Gestion des Étudiants</a></li>
                   <?php }?>
                </ul>
            </li>
             <?php } ?>
            <!-- /IF TRUE -->
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>