# WPAfterInstallRoutine

## Simple, extendable script designed to run after doing a new WordPress installation

Based on a custom routine that I like to do on new websites.

The default routine follows my own personal preferences but it can be easily modified to add/remove functions via tasks.

**Note: this is an experiment.**
There are tons of scripts that have this same functionality (and even some well written WP plugins). This is just my take on the subject, which I'm doing *just for fun*.

## Configuration

Settings for each task and plugin list are defined on config.json

Sample:

````JSON
{
    "plugins": {
        "wp-mail-smtp": "",
        "wp-smushit": "2.8.0",
        "simple-automatic-updates": "0.1.3",
        "wordpress-seo": "7.9",
        "filenames-to-latin": "2.5",
        "white-label-cms": "",
    },
    "results_report": {
        "send": 1,
        "to": "info@subwaydesign.com.ar"
    },
    "delete_default_themes": {
        "twentyfifteen": "",
        "twentysixteen": ""
    },
    "update_wp_options": {
        "blogdescription": "",
        "date_format": "d-m-Y",
        "permalink_structure": "/%postname%/"
    }
}
````

"plugins" is an array where each object is the name of the plugin on the WP plugins directory : version to install

## Tasks

- Remove unwanted themes **(NYI)**
- Download and install plugins defined on the configuration file **(NYI)**
- Install plugins from the premium_plugins directory **(NYI)**
- Activate all installed plugins **(NYI)**
- Create .htaccess file if it doesn't exist. Populate with safe default information. **(NYI)**
- Update the options table with values defined on the configuration file **(NYI)**
- Set permalink structure (if in options & .htaccess was created succesfully) **(NYI)**
- Checks **(NYI)**
  - If options-table->siteurl has https
- E-mail execution results **(NYI)**
- Self-delete **(NYI)**

````NYI = Not Yet Implemented````

## Script directory

It is assumed that this script is run from one directory deeper than the main WP folder, so wp-load.php is searched for on ````../````

## License

[GNU GPL v3](https://www.gnu.org/licenses/gpl.html)

## Author

Ignacio Nelson @ <info@subwaydesign.com.ar>
