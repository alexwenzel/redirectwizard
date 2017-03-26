<?php namespace Alexwenzel\RedirectWizard\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class RedirectWizard extends Controller
{
    public $implement = ['Backend\Behaviors\ListController','Backend\Behaviors\FormController','Backend\Behaviors\ReorderController'];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    public $reorderConfig = 'config_reorder.yaml';

    public $requiredPermissions = [
        'redirectwizard' 
    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Alexwenzel.RedirectWizard', 'redirectwizard');
    }
}