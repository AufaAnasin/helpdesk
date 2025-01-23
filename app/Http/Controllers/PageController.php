<?php

namespace App\Http\Controllers;

class PageController extends Controller
{
    /**
     * Display icons page
     *
     * @return \Illuminate\View\View
     */
    public function icons()
    {
        return view('pages.icons');
    }

        /**
     * Display tickets page
     *
     * @return \Illuminate\View\View
     */
    public function tickets()
    {   
        return view('tickets');
    }

    public function inputticket() { 
        return view('inputticket');
    }

    /**
     * Display maps page
     *
     * @return \Illuminate\View\View
     */
    public function maps()
    {
        return view('pages.maps');
    }

    public function test() {
        return view('test');
    }

    public function mytickets()
    {
        return view('mytickets');
    }

    /**
     * Display tables page
     *
     * @return \Illuminate\View\View
     */
    public function tables()
    {
        return view('pages.tables');
    }

    /**
     * Display notifications page
     *
     * @return \Illuminate\View\View
     */
    public function notifications()
    {
        return view('pages.notifications');
    }

    /**
     * Display rtl page
     *
     * @return \Illuminate\View\View
     */
    public function rtl()
    {
        return view('pages.rtl');
    }

    /**
     * Display typography page
     *
     * @return \Illuminate\View\View
     */
    public function typography()
    {
        return view('pages.typography');
    }

    // assets page

    public function registerassets()
    {   
        $pageSlug = 'register-assets';
        return view('assetsmanagement.assetsregister', compact('pageSlug'));
    }

    public function assetslist()
    {   
        $pageSlug = 'assets-list';
        return view('assetsmanagement.assetslist', compact('pageSlug'));
    }

    public function assetDetail() {
        $pageSlug = 'assets-list';
        return view('assetsmanagement.assetsdetail', compact('pageSlug'));
    }

    /**
     * Display upgrade page
     *
     * @return \Illuminate\View\View
     */
    public function upgrade()
    {
        return view('pages.upgrade');
    }
}
