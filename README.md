# WPAfterInstallRoutine

## Simple, extendable script designed to run after doing a new WP installation.

Based on a custom routine that I like.
The default routine follows my own personal preferences but it can be easily modified to add/remove functions via tasks.

**Note: this is an experiment.**
There are tons of scripts that have this same functionality (and even some well written WP plugins). This is just my take on the subject, which I'm doing *just for fun*.

## Configuration

Settings for each task and plugin list are defined on config.json

Sample:

````JSON
{
    "plugins": [
        {"wp-mail-smtp": ""},
        {"simple-automatic-updates": "0.1.3"},
        {"wordpress-seo": "7.9"},
        {"filenames-to-latin": "2.5"},
        {"white-label-cms": ""},
    ],
    "results_report": [
        {"send": 1},
        {"to": "info@subwaydesign.com.ar"}
    ],
    "delete_default_themes": [
        {"twentyfifteen": ""},
        {"twentysixteen":""}
    ],
    "update_wp_options": [
        {"blogdescription": ""},
        {"date_format":"d-m-Y"},
        {"permalink_structure":"/%postname%/"}
    ]
}
````

"plugins" is an array where each object is the name of the plugin on the WP plugins directory : version to install

## Script directory

It is assumed that this script is run from one directory deeper than the main WP folder, so wp-load.php is searched for on ````../````

## License

[GNU GPL v3](https://www.gnu.org/licenses/gpl.html)

## Author

Ignacio Nelson @ <info@subwaydesign.com.ar>
