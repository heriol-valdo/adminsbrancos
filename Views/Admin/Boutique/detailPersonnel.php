<?php


use Projet\Database\Classe_Eleve;
use Projet\Database\Cours;
use Projet\Database\Enseignant;
use Projet\Database\Journal;
use Projet\Database\Note;
use Projet\Model\App;
use Projet\Model\DateParser;
use Projet\Model\Encrypt;
use Projet\Model\FileHelper;
use Projet\Model\Paginator;
use Projet\Model\Privilege;
use Projet\Model\StringHelper;

App::setTitle("Détail de $personnel->nom $personnel->prenom ");
App::setNavigation("Détail de $personnel->nom $personnel->prenom");
App::setBreadcumb('<li><a href="'.App::url('admin').'">Personnel</a></li><li class="active">Détail</li>');
App::addScript('assets/js/detail.js',true);
?>
<div class="profile-cover" style="height: 90px;background: white">
    <div class="row">
        <div class="col-md-3 profile-image" style="margin-top: 30px">
            <div class="profile-image-container">
                <a href="javascript:void(0);" data-src="<?= FileHelper::url($personnel->photo) ?>" class="detailImg">
                    <img src="<?= FileHelper::url($personnel->photo) ?>" style="width: 120px;height: 120px;" alt="">
                </a>
            </div>
        </div>
        <div class="col-md-12 profile-info">
            <div class=" profile-info-value">
                <h3><?= DateParser::DateConviviale($personnel->last_login); ?></h3>
                <p>Dernière connexion</p>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4 user-profile">
        <h3 class="text-center"><?= "$personnel->nom $personnel->prenom"; ?></h3>
        <p class="text-center"><?= 'Né le '.DateParser::DateConviviale($personnel->naissance) ?></p>
        <hr>
        <div class="table-responsive project-stats">
            <table class="table table-striped table-bordered table-hover">
                <tr>
                    <td>Matricule</td>
                    <td><b><?= $personnel->matricule; ?></b></td>
                </tr>
                <tr>
                    <td>Sexe</td>
                    <td><b><?= $personnel->sexe; ?></b></td>
                </tr>
                <tr>
                    <td>Téléphone</td>
                    <td><b><?= StringHelper::isEmpty($personnel->numero); ?></b></td>
                </tr>
                <tr>
                    <td>Adresse mail</td>
                    <td><b><?= StringHelper::isEmpty($personnel->email,1); ?></b></td>
                </tr>
                <tr>
                    <td>Localisation</td>
                    <td><b><?= "$personnel->ville, $personnel->quartier, $personnel->adresse"; ?></b></td>
                </tr>
                <tr>
                    <td>N° CNI</td>
                    <td><b><?= StringHelper::isEmpty($personnel->cni); ?></b></td>
                </tr>
                <tr>
                    <td>Dernier diplôme</td>
                    <td><b><?= StringHelper::isEmpty($personnel->diplome); ?></b></td>
                </tr>
                <tr>
                    <td>Etat</td>
                    <td><b><?= StringHelper::$tabState[$personnel->etat]; ?></b></td>
                </tr>
                <tr>
                    <td>Fonction</td>
                    <td><b><?= StringHelper::isEmpty($personnel->fonction); ?></b></td>
                </tr>
                <tr>
                    <td>Mini biographie</td>
                    <td><b><?= StringHelper::isEmpty($personnel->minibio); ?></b></td>
                </tr>
            </table>
        </div>
        <hr>
        <button class="btn btn-primary btn-block detailImg" data-src="<?= !empty($personnel->imageCni)?$personnel->imageCni:''; ?>"><i class="fa fa-plus m-r-xs"></i>Voir ma CNI</button>
        <hr>
        <button class="btn btn-info btn-block detailImg" data-src="<?= !empty($personnel->imageDiplome)?$personnel->imageDiplome:''; ?>"><i class="fa fa-plus m-r-xs"></i>Voir mon diplôme</button>
    </div>
    <div class="col-md-8 m-t-lg">
        <div class="panel divBox panel-dark">
            <div class="panel-heading">
                <h5 class="panel-title"><?= $personnel->libProfile; ?> <small>(Privilèges)</small></h5>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <?= StringHelper::showPrivileges($personnel->privilege); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel divBox panel-dark">
            <div class="panel-heading">
                <h5 class="panel-title">Classes à la charge</h5>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <?= StringHelper::showClasses($personnel->libClasses); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade messageModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content divBox">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">VISUEL IMAGE</h3>
            </div>
            <div class="modal-body">
                <div class="loader">
                    <p class="text-center"><img class="img-xs" src="<?= FileHelper::url('assets/images/load.gif') ?>" alt=""></p>
                </div>
                <div class="contenus hide">

                </div>
            </div>
        </div>
    </div>
</div>
