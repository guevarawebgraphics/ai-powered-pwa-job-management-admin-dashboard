<?php


/**
 * @param null $title
 * @param null $message
 * @return \Illuminate\Foundation\Application|mixed
 * For the flash messages.
 */
function custom_flash($title = null, $message = null) {
    // Set variable $flash to fetch the Flash Class
    // in Flash.php
    $flash = app('App\Http\Flash');

    // If 0 parameters are passed in ($title, $message)
    // then just return the flash instance.
    if (func_num_args() == 0) {
        return $flash;
    }

    // Just return a regular flash->info message
    return $flash->info($title, $message);
}

/**
 * For highlighting of words that matched the keywords.
 *
 * @param null $text
 * @param null $words
 *
 * @return \Illuminate\Foundation\Application|mixed
 */
function highlight_word($text = null, $words = null)
{
    return preg_replace("/\w*?" . preg_quote($text) . "\w*/i", "<b><i>$0</i></b>", $words);
}

/**
 * For highlighting of keywords only.
 *
 * @param null $text
 * @param null $words
 *
 * @return \Illuminate\Foundation\Application|mixed
 */
function highlight_keyword($text = null, $words = null)
{
    $replace = '<b><i>' . $text . '</i></b>';
    $words = str_ireplace($text, $replace, $words);
    return $words;
}

/**
 * @param null string $url
 *
 * @return \Illuminate\Foundation\Application|mixed
 * Add http to url
 */
function add_http($url = null)
{
    if ($url) {
        if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
            $url = "http://" . $url;
        }
    }
    return $url;
}

//Global Functions
function CleanUrl($string) {
    $string = strtolower($string);
    $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
    $string = preg_replace("/[\s-]+/", " ", $string);
    $string = preg_replace("/[\s_]/", "-", $string);
    return $string;
}

function section($parameters) : \App\Repositories\Renderable {
    $repository = new \App\Repositories\SectionRepository();

    return $repository->render($parameters);
}

function getAttachment($id){
    $image = \App\Models\Attachment::find($id);
    return $image;
}

function addSection($name, $type, $pages, $value = '') {
    if (empty($value) && $type === \App\Models\Section::FORM)
        $value = '{"options": {}, "fields": [], "data": []}';

    $section = \App\Models\Section::create(compact('name', 'type', 'value'));
    $section->pages()->sync($pages);

    return $section;
}

function getPayee()
{
    $query = \App\Models\Payee::whereNull('deleted_at')->orderBy('created_at','DESC')->get();
    return $query;
}

function getClient()
{
    $query = \App\Models\Client::whereNull('deleted_at')->orderBy('created_at','DESC')->get();
    return $query;
}

function getCustomers()
{
    $query = \App\Models\User::where('role_id', 1)->orderBy('created_at','DESC')->get();
    return $query;
}

function getMachine()
{
    $query = \App\Models\Machine::whereNull('deleted_at')->orderBy('created_at','DESC')->get();
    return $query;
}

function getPrices()
{            
    $priceMap = [
        ['name' => 'Diagnostic', 'amount' => 125.00],
        ['name' => 'Return for Repair', 'amount' => 125.00],
        ['name' => 'Stacked Diagnostic', 'amount' => 150.00],
        ['name' => 'Stacked Return for Repair', 'amount' => 150.00],
        ['name' => 'Full Repair', 'amount' => 250.00],
        ['name' => 'Stacked Full Repair', 'amount' => 300.00],
        ['name' => 'Other', 'amount' => 0.00], 
    ];

    return $priceMap;

}


function getSystemSettings($code){
    $query = \App\Models\SystemSetting::where('code', $code)->first();
    return $query;
}

function getOpenAIFiles() {
    $query = \App\Models\OpenAIFiles::whereNull('deleted_at')->orderBy('created_at','DESC')->get();
    return $query;
}