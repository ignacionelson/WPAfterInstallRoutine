<?php
/**
 * Detect if being run from CLI or browser. Used on other
 * functions/methods to avoid inserting HTML tags if true.
 *
 * @return boolean
 * @todo Extend with more checks
 */ 
function is_cli()
{
    if (http_response_code())
    {
        return false;
    }
    
    return true;
}

/**
 * On a browser, prints the array inside a <pre> tag for
 * better legibility
 *
 * @return void
 */
function getDump($data)
{
    ob_start();

    if (is_cli()) {
        var_dump($data);
    }
    else {
        echo "<pre>"; print_r($data); echo "</pre>";
    }

    $contents = ob_get_contents();
    ob_get_clean();

    return $contents;
}
