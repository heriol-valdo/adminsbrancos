<?php
use Projet\Database\Article;
use Projet\Model\DateParser;
?>
<html>

<head>

    <style>

        /*

        PDF library using PHP have some limitations and all CSS properties may not support. Before Editing this file, Please create a backup, so that You can restore this.

        The location of this file is here- application/lib/invoices/pdf-x2.php

        */

        * {
            margin: 0;
            padding: 0;
        }

        body {
            /*

            Important: Do not Edit Font Name, Unless you are sure. It's required for PDF Rendering Properly

            */

            font: 14px/1.4 dejavusanscondensed;

            /*

            Font Name End

            */
        }

        #page-wrap {
            width: 800px;
            margin: 0 auto;
        }

        table {
            border-collapse: collapse;
        }

        table td, table th {
            border: 1px solid black;
            padding: 5px;
        }

        #customer {
            overflow: hidden;
        }

        #logo {
            text-align: right;
            float: right;
            position: relative;
            border: 1px solid #fff;
            max-width: 540px;
            overflow: hidden;
        }

        #meta {
            margin-top: 1px;
            width: 50%;
        }

        #meta td {
            text-align: left;
        }

        #meta td.meta-head {
            text-align: right;
            background: #eee;
        }

        #meta td textarea {
            width: 100%;
            height: 20px;
            text-align: right;
        }

        #items {
            clear: both;
            width: 100%;
            margin: 30px 0 0 0;
            border: 1px solid black;
        }

        #items th {
            background: #eee;
        }

        #items textarea {
            width: 80px;
            height: 50px;
        }

        #items tr.item-row td {
            vertical-align: top;
        }

        #items td.description {
            width: 300px;
        }

        #items td.item-name {
            width: 175px;
        }

        #items td.description textarea, #items td.item-name textarea {
            width: 100%;
        }

        #items td.total-line {
            border-right: 0;
            text-align: right;
        }

        #items td.total-value {
            border-left: 0;
            padding: 10px;
        }

        #items td.total-value textarea {
            height: 20px;
            background: none;
        }

        #items td.balance {
            background: #eee;
        }

        #items td.blank {
            border: 0;
        }

        #terms {
            text-align: left;
            margin: 20px 0 0 0;
        }

        #terms h5 {
            text-transform: uppercase;
        //font: 13px;
            letter-spacing: 10px;
            border-bottom: 1px solid black;
            padding: 0 0 8px 0;
            margin: 0 0 8px 0;
        }

        #terms textarea {
            width: 100%;
            text-align: center;
        }
        .footer{
            text-align: center;
            position: absolute;
            font-size: 16px;
            bottom: 0;
            right: 0;
            height: 2rem;
            line-height: 2rem;
        }
        .text-small{
            font-size: 11px;
        }
        .footer-1{
            border-bottom: 1px dashed whitesmoke;
            padding: 10px;
            font-size: 14px;
            font-weight: bold;
        }
        .footer-2{
            border-bottom: 2px dotted darkgrey;
            padding: 10px;
            font-size: 12px;
        }
        @page {
            footer: footer;
        }

    </style>

</head>
<body style="font-family:dejavusanscondensed">
<htmlpagefooter name="footer">
    <div class="" style="text-align: center">
        <p class="footer-2"> <i>Merci d'être passé dans notre boutique en ligne, au plaisir de vous revoir</i></p>
        <p class="footer-1"> AFRIKFID - BP 11 Niamey, Niger</p>
        <p class="text-small">NIU : M 101311344219N - RC N° : RC/NIA/2013/B/4016 • Tél. : (+227) 99 80 00 00 • E-mail : info@afrikfid.boutique</p>
    </div>
</htmlpagefooter>
<sethtmlpagefooter name="footer" page="all" value="on" />

<div id="page-wrap">
    <!-- Entête logo et Numéro de la facture -->
    <table width="100%">
        <tr>
            <td style="border: 0;" width="40%">
            </td>
            <td style="border: 0;text-align: right" width="60%">
                <div id="logo">
                    <img id="image" src="<?= \Projet\Model\FileHelper::url('assets/img/logo.png') ?>" style="height: 100px;" alt="logo"/>
                    <br>
                </div>
            </td>
        </tr>

    </table>
    <div style="clear:both"></div>
    <table width="100%">
        <tr>
            <td style="border: 0;  text-align: left" width="62%">
                <span style="font-size: 18px; color: #2f4f4f"><strong><?= $commande->etat==2||$commande->etat==3?"FACTURE":"PROFORMA"; ?> #<?= $commande->reference; ?></strong></span>
            </td>
            <td style="border: 0;  text-align: right" width="38%">
            </td>
        </tr>
    </table>

    <hr>
    <div style="clear:both"></div>
    <!-- Zone d'adresse de facturation du Client -->

    <div id="customer">
        <table id="meta" align="right">
            <tr>
                <td>Client</td>
                <td class="meta-head"><?= ucfirst($commande->nom.' '.$commande->prenom) ?></td>
            </tr>
            <tr>
                <td>Contact</td>
                <td class="meta-head"><?= $commande->numero.' ('.$commande->email.')' ?></td>
            </tr>
            <tr>
                <td>Date achat</td>
                <td class="meta-head"><?= DateParser::DateShort($commande->created_at,1); ?></td>
            </tr>
            <tr>
                <td>Ref Commande</td>
                <td class="meta-head"><?= $commande->reference; ?></td>
            </tr>

        </table>

    </div>

    <!-- Zone de liste des elements de la facture -->

    <table id="items">
        <thead>
        <tr>
            <th width="15%">Ref Article</th>
            <th width="43%">Description</th>
            <th align="right">Prix <small>(XOF)</small></th>
            <th align="right">Quantité</th>
            <th align="right">Total <small>(XOF)</small></th>

        </tr>
        </thead>
        <tbody>
        <?php
        $total = 0;
        foreach ($lignes as $ligne) {
            $article = Article::find($ligne->idArticle);
            $total += $ligne->prixTotal;
            echo '<tr>
                    <td align="center" class="balance">'.$article->ref.'</td>
                    <td align="center" class="balance">'.$article->intitule.'</td>
                    <td align="right">'.thousand($ligne->prix).'</td>
                    <td align="right">'.thousand($ligne->nbre).'</td>
                    <td align="right" class="total-value">'.thousand($ligne->prixTotal).'</td>
                </tr>';
        }
        echo '<tr>
                    <td align="center" colspan="2" class="blank"><b>Total Facture</b></td>
                    <td align="center" colspan="3" class="total-value"><b>'.thousand($total).' XOF</b></td>
                </tr>';
        ?>
        </tbody>
    </table>
    <?php
    $number = new NumberFormatter('fr',NumberFormatter::SPELLOUT);
    ?>

    <p style="text-align: center; margin-top: 20px">Arrêté la présente <?= $commande->etat==2||$commande->etat==3?"facture":"proforma"; ?> à la somme de : <b><?= ucfirst($number->format($total)); ?> francs CFA </b></p>
    <p style="text-align: center; margin-top: 50px;font-size: 11px"><i>Les produits livrés demeurent la propriété exclusive de notre entreprise jusqu'au paiement complet de la présente facture.
        </i></p>

</div>

</body>

</html>