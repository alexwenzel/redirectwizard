<?php namespace Alexwenzel\RedirectWizard\Models;

use Model;

/**
 * Class Redirect
 * @package Alexwenzel\RedirectWizard\Models
 */
class Redirect extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\SoftDelete;

    /**
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * @var array
     */
    protected $fillable = [
        'redirect_from_method',
        'redirect_from',
        'redirect_to',
        'redirect_to_httpstatus',
    ];

    /**
     * @var array
     */
    public $rules = [];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'alexwenzel_redirectwizard_redirects';

    /**
     * @return array
     */
    public function getRedirectFromMethodOptions()
    {
        return [
            'GET' => 'GET',
            'POST' => 'POST',
        ];
    }

    /**
     * @return array
     */
    public function getRedirectToHttpstatusOptions()
    {
        return [
            301 => '301 - Moved Permanently',
            302 => '302 - Found ( Moved Temporarily )',
            304 => '304 - Not Modified',
            305 => '305 - Use Proxy',
            307 => '307 - Temporary Redirect',
            308 => '308 - Permanent Redirect',
        ];
    }
}
