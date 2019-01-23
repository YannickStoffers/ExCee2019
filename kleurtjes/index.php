<?php
set_include_path('../');
require_once 'include/init.php';

class LogoColourView extends TemplateView
{
    /** 
     * Run the page, but only for logged in committee members. 
     * Non-admins are only allowed to see a list of their redirects
     */
    public function run_page() {
        if (!cover_session_logged_in() && !DEBUG)
            throw new HttpException(401, 'Unauthorized', sprintf('<a href="%s" class="btn btn-primary">Login and get started!</a>', cover_login_url()));
        else if (!cover_session_in_committee(ADMIN_COMMITTEE) && !DEBUG)
            throw new HttpException(403, 'You need to be a member of the ExCee to see this page!');
        else
            return parent::run_page();
    }
}

// Create and run home view
$view = new LogoColourView('kleurtjes/index');

$view->run();
