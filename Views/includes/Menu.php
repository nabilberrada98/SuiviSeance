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
        <!-- search form (Optional) -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Rechercher...">
                <span class="input-group-btn">
                    <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                    </button>
                </span>
            </div>
        </form>
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">Choix de Menu</li>
            <!-- Optionally, you can add icons to the links -->
            <!-- <li class="active"><a href="#"><i class="fa fa-link"></i> <span>Séances de cour</span></a></li>
             <li><a href="#"><i class="fa fa-link"></i> <span>Séances d'encadrement</span></a></li> -->
            <?php if ($user_priv->hasPrivilege("Dashboard")) { ?>
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
            <li class="treeview <?= $file == 'CalendrierDesCours' ? "active" : "" ?>">
                <a><i class="fa fa-circle"></i> <span>Séances de cours</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="<?= $file == 'CalendrierDesCours' ? "active" : "" ?>"><a href="CalendrierDesCours"><i class="fa fa-calendar"></i>Affichage</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a><i class="fa fa-circle"></i> <span>Séances d'encadrement</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="CalendrierDesEncadrements"><i class="fa fa-calendar"></i>Affichage</a></li>
                </ul>
            </li>
            <!-- IF TRUE -->
            <li class="treeview">
                <a ><i class="fa fa-circle"></i> <span>Administration</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-money"></i>Calcul de rémunération</a></li>
                    <li><a href="#"><i class="fa fa-minus-circle"></i>Appliquer une restriction</a></li>
                </ul>
            </li>
            <!-- /IF TRUE -->
            <li class="treeview <?= $file == 'GestionDesProfesseurs' || $file == 'GestionDesMatieres' || $file == 'GestionDesRoles' ? "active" : "" ?>&">
                <a ><i class="fa fa-circle"></i> <span>Gérer l'application</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="#" ><i class="fa fa-suitcase <?= $file == 'GestionDesProfesseurs' ? "active" : "" ?>"></i>Gestion professeurs</a></li>
                    <li><a href="GestionDesMatieres" ><i class="fa fa-leanpub <?= $file == 'GestionDesMatieres' ? "active" : "" ?>"></i>Gestion Matiéres</a></li>
                    <li><a href="GestionDesRoles" ><i class="fa fa-user <?= $file == 'GestionDesRoles' ? "active" : "" ?>"></i>Gestion Utilisateurs & Roles</a></li>
                </ul>
            </li>
            <li class="<?= $file == 'GestionDesMails' ? "active" : "" ?>">
                    <a href="GestionDesMails">
                        <i class="fa fa-envelope"></i> <span>Messagerie</span>
                    </a>
                </li>
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>