<?php

namespace app;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CustomPagination
 *
 * @author LENOVO
 */
class CustomPagination extends Illuminate\Pagination\Presenter {

    public function getActivePageWrapper($text) {
        return '<li class="current btn-primay"><a href="">' . $text . '</a></li>';
    }

    public function getDisabledTextWrapper($text) {
        return '<li class="unavailable"><a href="">' . $text . '</a></li>';
    }

    public function getPageLinkWrapper($url, $page, $rel = null) {
        return '<li><a href="' . $url . '">' . $page . '</a></li>';
    }

}
